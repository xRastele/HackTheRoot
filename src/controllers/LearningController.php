<?php

require_once 'AppController.php';
require_once __DIR__.'/../repository/LearningRepository.php';
require_once __DIR__.'/../repository/UserRepository.php';

class LearningController extends AppController
{
    private $learningRepository;
    private $userRepository;

    public function __construct()
    {
        parent::__construct();
        $this->learningRepository = new LearningRepository();
        $this->userRepository = new UserRepository();
    }

    public function learning() {
        if (!isset($_SESSION["username"])) {
            header("Location: /");
        }
        $user = $this->userRepository->getUserByUsername($_SESSION['username']);
        $userId = $user->getUserId();
        $modules = $this->learningRepository->getLearningProgress($userId);
        $this->render('learning', ['modules' => $modules]);
    }
}