<?php
require_once "../config.php";
require_once "../app/core/Router.php";

// Capturamos parámetros de la URL
$controller = $_GET['controller'] ?? "HomeController";
$method     = $_GET['method'] ?? "index";

// Pasamos la solicitud al Router
Router::route($controller, $method);
