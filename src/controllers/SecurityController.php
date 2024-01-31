<?php

require_once 'AppController.php';
require_once __DIR__ .'/../models/User.php';
require_once __DIR__.'/../repository/UserRepository.php';

session_start();

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
        if (isset($_SESSION["username"])) {
            header("Location: home");
        }

        if(!$this->isPost()) {
            return $this->render('login');
        }

        $email = $_POST["email"];
        $password = $_POST["password"];

        $user = $this->userRepository->getUserByEmail($email);

        if(!$user) {
            return $this->render('login', ['messages' => ['Wrong email or password']]);
        }

        list($salt, $hashedPassword) = explode('$', $user->getPassword());
        $hashedInputPassword = hash('sha512', $salt . $password);

        if ($hashedInputPassword !== $hashedPassword) {
            return $this->render('login', ['messages' => ['Wrong email or password']]);
        }

        $_SESSION["username"] = $user->getUsername();

        header("Location: home");
    }

    private function arePasswordsSame($password, $confirmPassword) {
        return $password === $confirmPassword;
    }

    public function register()
    {
        if (isset($_SESSION["username"])) {
            header("Location: home");
        }

        if (!$this->isPost()) {
            return $this->render('register');
        }

        $email = $_POST['email'] ?? null;
        $username = $_POST['username'] ?? null;
        $password = $_POST['password'] ?? null;
        $confirmPassword = $_POST["confirmPassword"] ?? null;

        if(!$this->arePasswordsSame($password, $confirmPassword))
        {
            return $this->render('register', ['messages' => ['Passwords must be the same']]);
        }

        if (empty($email) || empty($username) || empty($password) || empty($confirmPassword)) {
            return $this->render('register', ['messages' => ['Please fill in all fields']]);
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $this->render('register', ['messages' => ['Email address is invalid']]);
        }

        if ($this->userRepository->doesUserExist($email, $username)) {
            return $this->render('register', ['messages' => ['Username or email already exists']]);
        }

        $salt = bin2hex(random_bytes(16));
        $hashedPassword = hash('sha512', $salt . $password);
        $passwordWithSalt = $salt . '$' . $hashedPassword;

        $this->userRepository->addUser($email, $username, $passwordWithSalt);

        return $this->render('login', ['messages' => ['You\'ve been succesfully registered! You can now login below.']]);
    }

    public function logout() {
        if(isset($_SESSION['username'])) {
            $_SESSION = array();
            if (ini_get("session.use_cookies")) {
                $params = session_get_cookie_params();
                setcookie(session_name(), '', time() - 42000,
                    $params["path"], $params["domain"],
                    $params["secure"], $params["httponly"]
                );
            }
            session_destroy();
            header('Location: login');
        }
        else {
            header('Location: /home');
        }
    }
}