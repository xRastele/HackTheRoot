<?php

require 'Routing.php';

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url($path, PHP_URL_PATH);

Routing::get('', 'DefaultController');
Routing::get('login', 'SecurityController');
Routing::get('register', 'SecurityController');
Routing::get('logout', 'SecurityController');
Routing::get('leaderboard', 'LeaderboardController');
Routing::get('news', 'NewsController');
Routing::get('fetchNews', 'NewsController');
Routing::get('fetchNotifications', 'NewsController');

Routing::get('learning', 'DefaultController');
Routing::get('home', 'DefaultController');

Routing::post('login', 'SecurityController');
Routing::post('register', 'SecurityController');

Routing::run($path);
