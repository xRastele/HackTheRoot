<?php

require_once 'AppController.php';
require_once __DIR__.'/../repository/NewsRepository.php';
require_once __DIR__.'/../repository/TipRepository.php';

class HomeController extends AppController
{
    private $newsRepository;
    private $tipRepository;

    public function __construct()
    {
        parent::__construct();
        $this->newsRepository = new NewsRepository();
        $this->tipRepository = new TipRepository();
    }

    public function home() {
        session_start();
        $latestNotification = $this->newsRepository->getLatestNotification($_SESSION['username'] ?? null);
        $latestNews = $this->newsRepository->getLatestNews();
        $tipOfTheDay = $this->tipRepository->getRandomTip();
        $this->render('home',
            ['latestNotification' => $latestNotification,
                'latestNews' => $latestNews,
                'tipOfTheDay' => $tipOfTheDay]);
    }
}