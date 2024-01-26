<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/User.php';

class UserRepository extends Repository
{
    public function getUserByEmail(string $email): ?User
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM public.users WHERE email = :email
        ');
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user == false) {
            return null;
        }

        return new User(
            $user['email'],
            $user['username'],
            $user['password'],
            $user['user_id']
        );
    }

    public function getAllUsers(): array
    {
        $stmt = $this->database->connect()->prepare('SELECT * FROM users;');
        $stmt->execute();

        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $result = [];

        foreach ($users as $user) {
            $result[] = new User($user['email'], $user['username'], $user['password'], $user['user_id']);
        }

        return $result;
    }

    public function addUser(string $email, string $username, string $password): void
    {
        $stmt = $this->database->connect()->prepare('
            INSERT INTO users (email, username, password)
            VALUES (:email, :username, :password)
        ');

        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":password", $password);
        $stmt->execute();

        //Add user to leaderboard with default (0) points
        $user = $this->getUserByEmail($email);
        $userId = $user->getUserId();

        $stmt = $this->database->connect()->prepare('
            SELECT add_to_leaderboard(:user_id, 0);
        ');
        $stmt->bindParam(":user_id", $userId, PDO::PARAM_INT);
        $stmt->execute();

    }

    public function doesUserExist($email, $username): bool
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM users WHERE email = :email OR username = :username
        ');
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user !== false;
    }

    public function getAllUsersSortedLeaderboard(): array
    {
        $stmt = $this->database->connect()->prepare('
            SELECT users.username, leaderboard.points_challenges
            FROM users
            INNER JOIN leaderboard ON users.user_id = leaderboard.user_id
            ORDER BY leaderboard.points_challenges DESC;
        ');
        $stmt->execute();

        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $result = [];

        foreach ($users as $user) {
            $result[] = new User($user['email'], $user['username'], $user['password'], $user['user_id']);
        }

        return $result;
    }
}