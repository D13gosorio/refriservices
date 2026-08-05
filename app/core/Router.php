<?php

class Router {

    public static function route($controller, $method) {

        // $controller y $method llegan directo de $_GET. Se exige que sean
        // identificadores "sanos" (letras/números/guion bajo) ANTES de
        // usarlos para construir una ruta de archivo o instanciar una clase:
        // sin esto, un valor como "../../../../algo" podría hacer que
        // file_exists()/require_once() lean archivos fuera de app/controllers
        // (inclusión de archivos locales), y reflejar el valor crudo en un
        // mensaje de error habilitaría XSS reflejado.
        if (!is_string($controller) || !preg_match('/^[A-Za-z0-9_]+$/', $controller)) {
            self::noEncontrado();
        }

        if (!is_string($method) || !preg_match('/^[A-Za-z0-9_]+$/', $method)) {
            self::noEncontrado();
        }

        $controllerFile = ROOT_PATH . "/app/controllers/" . $controller . ".php";

        if (!file_exists($controllerFile)) {
            self::noEncontrado();
        }

        require_once $controllerFile;

        if (!class_exists($controller, false)) {
            self::noEncontrado();
        }

        $obj = new $controller();

        if (!method_exists($obj, $method)) {
            self::noEncontrado();
        }

        $obj->$method();
    }

    private static function noEncontrado(): void {
        http_response_code(404);
        die("Página no encontrada.");
    }
}
