<?php

class Leaderboard {
    private $users = [];

    public function addUser($user) {
        $this->users[] = $user;
    }

    public function getUsers() {
        return $this->users;
    }
}
