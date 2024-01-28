<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/Leaderboard.php';
require_once __DIR__.'/../models/UserLeaderboard.php';

class LeaderboardRepository extends Repository
{
    public function getLeaderboard(): Leaderboard
    {
        $stmt = $this->database->connect()->prepare('
        SELECT users.username, leaderboard.points_challenges
        FROM users
        INNER JOIN leaderboard ON users.user_id = leaderboard.user_id
        ORDER BY leaderboard.points_challenges DESC LIMIT 10
    ');

        $stmt->execute();

        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $leaderboard = new Leaderboard();
        foreach ($users as $user) {
            $leaderboard->addUser(new UserLeaderboard($user['username'], $user['points_challenges']));
        }

        return $leaderboard;
    }
}