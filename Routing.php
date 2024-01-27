<?php

require_once 'src/controllers/DefaultController.php';
require_once 'src/controllers/SecurityController.php';
require_once 'src/controllers/LeaderboardController.php';
require_once 'src/controllers/NewsController.php';

class Routing {
    public static $routes;

    public static function get($url, $controllerAction) {
        self::$routes[$url] = $controllerAction;
    }

    public static function post($url, $controllerAction) {
        self::$routes[$url] = $controllerAction;
    }

    public static function run($url) {
        if (!array_key_exists($url, self::$routes)) {
            die("This URL doesn't exist.");
        }

        $controllerAction = self::$routes[$url];
        $parts = explode("::", $controllerAction);
        $controllerName = $parts[0];
        $methodName = $parts[1] ?? $url;

        if (count($parts) == 1) {
            $methodName = $methodName ?: 'index';
        }

        if (!class_exists($controllerName)) {
            die("Controller doesn't exist.");
        }

        $controllerObject = new $controllerName();

        if (!method_exists($controllerObject, $methodName)) {
            die("Method doesn't exist.");
        }

        $controllerObject->$methodName();
    }
}
