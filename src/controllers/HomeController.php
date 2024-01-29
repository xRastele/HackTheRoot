<?php

require_once 'AppController.php';
require_once __DIR__.'/../repository/NewsRepository.php';

class HomeController extends AppController
{
    private $newsRepository;

    public function __construct()
    {
        parent::__construct();
        $this->newsRepository = new NewsRepository();
    }

    public function home() {
        session_start();
        $latestNotification = $this->newsRepository->getLatestNotification($_SESSION['username'] ?? null);
        $latestNews = $this->newsRepository->getLatestNews();
        $this->render('home', ['latestNotification' => $latestNotification, 'latestNews' => $latestNews]);
    }
}