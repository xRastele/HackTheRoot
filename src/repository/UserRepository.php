<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/User.php';

class UserRepository extends Repository
{
    public function getUser(string $email): ?User
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
            $user['password']
        );
    }

    public function getAllUsers(): array
    {
        $stmt = $this->database->connect()->prepare('SELECT * FROM users;');
        $stmt->execute();

        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $result = [];

        foreach ($users as $user) {
            $result[] = new User($user['email'], $user['username'], $user['password']);
        }

        return $result;
    }

    public function addUser(User $user)
    {
        $stmt = $this->database->connect()->prepare('
            INSERT INTO users (email, username, password)
            VALUES (?, ?, ?)
        ');

        $stmt->execute([
            $user->getEmail(),
            $user->getUsername(),
            $user->getPassword()
        ]);
    }
}