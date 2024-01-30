<?php

require_once 'AppController.php';
require_once __DIR__.'/../repository/NewsRepository.php';
require_once __DIR__.'/../repository/TipRepository.php';
require_once __DIR__.'/../repository/LearningRepository.php';

class HomeController extends AppController
{
    private $newsRepository;
    private $tipRepository;
    private $learningRepository;
    private $userRepository;

    public function __construct()
    {
        parent::__construct();
        $this->newsRepository = new NewsRepository();
        $this->tipRepository = new TipRepository();
        $this->userRepository = new UserRepository();
        $this->learningRepository = new LearningRepository();
    }

    public function home() {
        session_start();
        if (!isset($_SESSION["username"])) {
            header("Location: /");
        }

        $latestNotification = $this->newsRepository->getLatestNotification($_SESSION['username'] ?? null);

        $user = $this->userRepository->getUserByUsername($_SESSION['username'] ?? null);
        $userId = $user->getUserId();

        $modulesWithProgress = $this->learningRepository->getLearningProgress($userId);
        $latestNews = $this->newsRepository->getLatestNews();
        $tipOfTheDay = $this->tipRepository->getRandomTip();
        if($user->getIsAdmin())
        {
            $this->render('admin');
        }
        else
        {
            $this->render('home',
                ['latestNotification' => $latestNotification,
                    'latestNews' => $latestNews,
                    'modulesWithProgress' => $modulesWithProgress,
                    'tipOfTheDay' => $tipOfTheDay]);
        }
    }
}