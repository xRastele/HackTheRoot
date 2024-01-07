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

        if ($user->getEmail() !== $email) {
            return $this->render('login', ['messages' => ['User with this email doesn\'t exist']]);
        }

        if ($user->getPassword() !== $password) {
            var_dump($email);
            var_dump($password);
            var_dump($user);
            return $this->render('login', ['messages' => ['Wrong password']]);
        }

        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/register");

        //return $this->render('news');
    }

    public function register()
    {
        if (!$this->isPost()) {
            return $this->render('register');
        }

        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = $_POST['password'];

        $salt = bin2hex(random_bytes(16));
        $hashedPassword = hash('sha512', $salt . $password);
        $passwordWithSalt = $salt . '$' . $hashedPassword;

        $user = new User($email, $username, $passwordWithSalt);

        $this->userRepository->addUser($user);

        return $this->render('register', ['messages' => ['You\'ve been succesfully registered!']]);
    }
}