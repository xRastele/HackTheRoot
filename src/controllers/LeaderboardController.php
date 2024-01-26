<?php

require_once 'AppController.php';
require_once __DIR__.'/../repository/LeaderboardRepository.php';

class LeaderboardController extends AppController
{
    private $leaderboardRepository;

    public function __construct()
    {
        parent::__construct();
        $this->leaderboardRepository = new LeaderboardRepository();
    }

    public function leaderboard() {
        $leaderboard = $this->leaderboardRepository->getLeaderboard();
        $this->render('leaderboard', ['leaderboard' => $leaderboard]);
    }

}