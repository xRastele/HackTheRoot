<?php

require 'Routing.php';

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url($path, PHP_URL_PATH);

Routing::get('', 'DefaultController');
Routing::get('register', 'DefaultController');
Routing::get('leaderboard', 'LeaderboardController');
Routing::get('news', 'DefaultController');
Routing::get('learning', 'DefaultController');
Routing::get('home', 'DefaultController');

Routing::post('login', 'SecurityController');
Routing::post('register', 'SecurityController');

Routing::run($path);
