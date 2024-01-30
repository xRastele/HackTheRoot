<?php

require_once 'src/controllers/DefaultController.php';
require_once 'src/controllers/SecurityController.php';
require_once 'src/controllers/LeaderboardController.php';
require_once 'src/controllers/NewsController.php';
require_once 'src/controllers/HomeController.php';
require_once 'src/controllers/LearningController.php';
require_once 'src/controllers/LessonController.php';
require_once 'src/controllers/TipController.php';

class Routing {
    public static $routes;

    public static function get($url, $controller) {
        self::$routes[$url] = $controller;
    }

    public static function post($url, $controller) {
        self::$routes[$url] = $controller;
    }

    public static function run ($url) {
        $action = explode("/", $url)[0];

        if (!array_key_exists($action, self::$routes)) {
            die("This URL doesn't exist.");
        }

        $controller = self::$routes[$action];
        $object = new $controller;
        $action = $action ?: 'index';

        $object->$action();
    }
}