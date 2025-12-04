<?php

class Router {

    public static function route($controller, $method) {

        $controllerFile = __DIR__ . "/../controllers/" . $controller . ".php";

        // Verificamos que el archivo del controlador exista
        if (!file_exists($controllerFile)) {
            die("El controlador $controller no existe.");
        }

        require_once $controllerFile;

        // Creamos una instancia del controlador
        if (!class_exists($controller)) {
            die("La clase $controller no fue encontrada.");
        }

        $obj = new $controller();

        // Verificamos que el método exista
        if (!method_exists($obj, $method)) {
            die("El método $method no existe en el controlador $controller.");
        }

        // Ejecutamos el método
        $obj->$method();
    }
}
