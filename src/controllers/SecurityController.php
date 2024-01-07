<?php

require_once 'AppController.php';
require_once __DIR__ .'/../models/User.php';
require_once __DIR__.'/../repository/UserRepository.php';

class SecurityController extends AppController
{
    private $userRepository;

    public function __construct()
    {
        parent::__construct();
        $this->userRepository = new UserRepository();
    }

    public function login()
    {
        if(!$this->isPost()) {
            return $this->render('login');
        }

        $email = $_POST["email"];
        $password = $_POST["password"];

        $user = $this->userRepository->getUser($email);

        if(!$user) {
            return $this->render('login', ['messages' => ['User doesn\'t exist']]);
        }

        list($salt, $hashedPassword) = explode('$', $user->getPassword());
        $hashedInputPassword = hash('sha512', $salt . $password);

        if ($hashedInputPassword !== $hashedPassword) {
            return $this->render('login', ['messages' => ['Wrong password']]);
        }

        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/home");

        //return $this->render('news');
    }

    public function register()
    {
        if (!$this->isPost()) {
            return $this->render('register');
        }

        $email = $_POST['email'] ?? null;
        $username = $_POST['username'] ?? null;
        $password = $_POST['password'] ?? null;

        if (empty($email) || empty($username) || empty($password)) {
            return $this->render('register', ['messages' => ['Please fill in all fields']]);
        }

        if ($this->userRepository->doesUserExist($email, $username)) {
            return $this->render('register', ['messages' => ['Username or email already exists']]);
        }

        $salt = bin2hex(random_bytes(16));
        $hashedPassword = hash('sha512', $salt . $password);
        $passwordWithSalt = $salt . '$' . $hashedPassword;

        $user = new User($email, $username, $passwordWithSalt);

        $this->userRepository->addUser($user);
        return $this->render('login', ['messages' => ['You\'ve been succesfully registered! You can now login below.']]);
    }
}