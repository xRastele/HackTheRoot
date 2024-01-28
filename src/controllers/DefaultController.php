<?php

require_once 'AppController.php';
session_start();
class DefaultController extends AppController {
    public function index() {
        if (isset($_SESSION["username"])) {
            header("Location: home");
        }
        else
        {
            $this->render('login');
        }
    }

    public function home() {
        $this->render('home');
    }

    public function learning() {
        $this->render('learning');
    }
}
