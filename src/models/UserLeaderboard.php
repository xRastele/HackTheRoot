<?php
class UserLeaderboard {
    public $username;
    public $points;

    public function __construct($username, $points) {
        $this->username = $username;
        $this->points = $points;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getPoints() {
        return $this->points;
    }
}