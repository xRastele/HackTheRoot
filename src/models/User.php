<?php
class User
{
    private $email;
    private $username;
    private $password;
    private $userId;

    public function __construct(string $email, string $username, string $password, int $userId)
    {
        $this->email = $email;
        $this->username = $username;
        $this->password = $password;
        $this->userId = $userId;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function setUserId(int $id): void
    {
        $this->userId = $id;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }
}