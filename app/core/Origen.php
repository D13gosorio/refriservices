<?php

// Control de origen (la parte de "CORS" que de verdad protege al backend).
//
// La app no expone una API para terceros: todas las peticiones que cambian
// datos salen de sus propios formularios. Por eso NO se envía nunca la
// cabecera Access-Control-Allow-Origin — sin ella el navegador ya impide que
// una página ajena lea las respuestas.
//
// Lo que sí hay que bloquear a mano es la escritura: un formulario alojado en
// otro dominio puede enviar un POST a este sitio aunque no pueda leer la
// respuesta. El token CSRF es la defensa principal; comparar el origen es la
// segunda barrera, y es la que se aplica aquí.
class Origen {

    // Orígenes autorizados.
    //
    // - Si se define la variable de entorno APP_ORIGENES (lista separada por
    //   comas, p. ej. "https://refriservices.com,https://www.refriservices.com")
    //   se usa exactamente esa lista y nada más.
    // - Si no está definida, se acepta únicamente el propio origen de la
    //   petición, que es el comportamiento correcto por defecto.
    public static function permitidos(): array {
        $configurados = trim((string) getenv("APP_ORIGENES"));

        // Se pasan a minúsculas porque la comparación es estricta: un
        // "HTTPS://Refriservices.com" en la variable de entorno rechazaría
        // todos los envíos del sitio, que es un fallo muy difícil de rastrear.
        if ($configurados !== '') {
            return array_values(array_filter(array_map(
                fn($o) => strtolower(rtrim(trim($o), '/')),
                explode(',', $configurados)
            )));
        }

        return [self::origenPropio()];
    }

    // Origen de esta misma petición: esquema + host (+ puerto si lo trae).
    private static function origenPropio(): string {
        $esquema = (
            (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ||
            (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https')
        ) ? 'https' : 'http';

        return strtolower($esquema . '://' . ($_SERVER['HTTP_HOST'] ?? 'localhost'));
    }

    // Comprueba que la petición viene de un origen autorizado.
    //
    // Se mira primero Origin (los navegadores actuales la envían en todo POST,
    // también en los del mismo sitio) y, si falta, se deduce de Referer. Si no
    // llega ninguna de las dos no hay forma de saber de dónde viene, así que se
    // rechaza: es preferible cortar una petición rara que aceptar una forjada.
    public static function verificarOMorir(): void {
        $origen = self::origenDeLaPeticion();

        if ($origen === null || !in_array($origen, self::permitidos(), true)) {
            error_log('[ORIGEN] Petición rechazada. Origen recibido: ' . ($origen ?? 'ninguno'));
            http_response_code(403);
            die("Solicitud rechazada: origen no autorizado.");
        }
    }

    private static function origenDeLaPeticion(): ?string {
        $origin = $_SERVER['HTTP_ORIGIN'] ?? '';

        if ($origin !== '' && $origin !== 'null') {
            return strtolower(rtrim($origin, '/'));
        }

        $referer = $_SERVER['HTTP_REFERER'] ?? '';

        if ($referer === '') {
            return null;
        }

        $partes = parse_url($referer);

        if (empty($partes['scheme']) || empty($partes['host'])) {
            return null;
        }

        $esquema = strtolower($partes['scheme']);
        $reconstruido = $esquema . '://' . $partes['host'];

        // El puerto se omite cuando es el propio del esquema: HTTP_HOST tampoco
        // lo incluye, y dejarlo daría un 403 al comparar "https://sitio.com:443"
        // con "https://sitio.com".
        $puertoPorDefecto = ($esquema === 'https' && (int) ($partes['port'] ?? 0) === 443)
            || ($esquema === 'http' && (int) ($partes['port'] ?? 0) === 80);

        if (!empty($partes['port']) && !$puertoPorDefecto) {
            $reconstruido .= ':' . $partes['port'];
        }

        return strtolower($reconstruido);
    }
}
