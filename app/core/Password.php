<?php

// Comprobaciones de calidad de la contraseña al crear una cuenta.
//
// Exigir "ocho caracteres con letras y números" deja pasar justo las que
// primero prueba un ataque de diccionario: "password1", "abc12345" o
// "contrasena1" cumplen la regla al pie de la letra. Esto rechaza las que se
// sabe de antemano que van a estar en la primera pasada.
class Password {

    private const MINIMO = 8;

    // Las contraseñas más repetidas que además superan la regla de letras y
    // números; sin ese filtro previo, la lista tendría que ser enorme para
    // aportar algo. Se compara en minúsculas.
    private const MAS_USADAS = [
        'password1', 'password12', 'password123', 'passw0rd', 'password1234',
        'contrasena1', 'contrasena123', 'contraseña1', 'contraseña123',
        'qwerty123', 'qwerty1234', 'qwertyui', 'qwerty12345', 'qwe123456',
        'abc12345', 'abcd1234', 'abc123456', 'abcdef123', 'a1234567', 'abcd12345',
        '1q2w3e4r', '1qaz2wsx', 'q1w2e3r4', 'zaq12wsx', '1q2w3e4r5t',
        'admin123', 'admin1234', 'administrador1', 'usuario123', 'usuario1',
        'iloveyou1', 'welcome1', 'welcome123', 'letmein1', 'letmein123',
        'monkey123', 'dragon123', 'football1', 'baseball1', 'superman1',
        'trustno1', 'sunshine1', 'princess1', 'starwars1', 'pokemon123',
        'michael1', 'jennifer1', 'jordan23', 'ashley123', 'daniel123',
        'colombia1', 'mexico123', 'panama123', 'espana123', 'america1',
        'familia1', 'familia123', 'teamo123', 'teamomucho1', 'micasa123',
        'juanito1', 'maria123', 'carlos123', 'jose1234', 'luis1234',
        'hola1234', 'hola12345', 'holamundo1', 'bienvenido1', 'buenos123',
        'master123', 'shadow123', 'ninja123', 'hunter123', 'batman123',
        'computadora1', 'internet1', 'telefono1', 'sistema123', 'secreto123',
        'prueba123', 'test1234', 'test12345', 'demo1234', 'ejemplo123',
        'asdf1234', 'asdfghjk1', 'zxcvbnm1', 'poiuytre1', 'qazwsx123',
        '12345678a', 'a12345678', '123456789a', '1234abcd', '12345abc',
        'verano2024', 'verano2025', 'enero2024', 'invierno1', 'navidad123',
        'refriservices1', 'refriservices123', 'aguadulce1', 'aguadulce123',
    ];

    // Devuelve el motivo por el que no sirve, o null si es aceptable.
    //
    // $contexto son datos del propio usuario (correo, nombre): una contraseña
    // que es su propio nombre o la parte inicial de su correo es de las
    // primeras que se prueban cuando el ataque va dirigido a alguien.
    public static function motivoRechazo(string $password, array $contexto = []): ?string {
        if (strlen($password) < self::MINIMO) {
            return "La contraseña debe tener al menos " . self::MINIMO . " caracteres.";
        }

        if (!preg_match('/[A-Za-z]/', $password) || !preg_match('/\d/', $password)) {
            return "La contraseña debe incluir letras y números.";
        }

        $normalizada = mb_strtolower($password);

        if (in_array($normalizada, self::MAS_USADAS, true)) {
            return "Esa contraseña es de las más usadas y es fácil de adivinar. Elige otra.";
        }

        // Muy pocos caracteres distintos: "aaaaaaa1", "1111111a" o "ababab12"
        // cumplen la regla de letras y números y no valen nada. Se cuenta la
        // variedad en vez de buscar patrones concretos, porque cualquier lista
        // de patrones deja fuera el siguiente.
        //
        // El umbral es cinco porque con cuatro se escapaban las alternancias
        // del tipo "abab1212"; subiéndolo más no se gana nada y empieza a
        // estorbar a contraseñas legítimas.
        if (count(array_unique(mb_str_split($normalizada))) < 5) {
            return "Esa contraseña repite demasiado los mismos caracteres. Elige otra.";
        }

        if (str_contains($normalizada, '12345678') || str_contains($normalizada, 'abcdefg')) {
            return "Esa contraseña es demasiado predecible. Elige otra.";
        }

        // El nombre llega entero ("Diego Osorio"), así que se parte en palabras:
        // comparando solo la cadena completa, un apellido suelto como
        // "osorio123" no se detectaría.
        foreach ($contexto as $dato) {
            foreach (preg_split('/[\s@._-]+/u', mb_strtolower(trim((string) $dato))) ?: [] as $parte) {
                // Solo se comparan trozos con cuerpo suficiente: descartar por
                // contener "ana" dejaría fuera contraseñas perfectamente buenas.
                if (mb_strlen($parte) < 4) {
                    continue;
                }

                if (str_contains($normalizada, $parte)) {
                    return "La contraseña no puede contener tu nombre ni tu correo.";
                }
            }
        }

        return null;
    }
}
