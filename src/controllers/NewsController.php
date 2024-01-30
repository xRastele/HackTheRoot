<?php

require_once 'AppController.php';
require_once __DIR__.'/../repository/NewsRepository.php';

class NewsController extends AppController
{
    private $newsRepository;

    public function __construct()
    {
        parent::__construct();
        $this->newsRepository = new NewsRepository();
    }

    public function news() {
        $this->render('news');
    }

    public function fetchNews() {
        if (!isset($_SESSION["username"])) {
            header("Location: /");
        }
        header('Content-Type: application/json');
        $news = $this->newsRepository->getNews();
        echo json_encode($news);
    }

    public function fetchNotifications() {
        if (!isset($_SESSION["username"])) {
            header("Location: /");
        }
        header('Content-Type: application/json');
        $notifications = $this->newsRepository->getNotifications();
        echo json_encode($notifications);
    }


}