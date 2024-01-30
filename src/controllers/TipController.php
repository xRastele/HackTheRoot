<?php

require_once 'AppController.php';
require_once __DIR__.'/../repository/TipRepository.php';
require_once __DIR__.'/../repository/UserRepository.php';

class TipController extends AppController
{
    private $tipRepository;

    public function __construct()
    {
        parent::__construct();
        $this->tipRepository = new TipRepository();
        $this->userRepository = new UserRepository();
    }

    public function insertTip()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tipText'])) {
            $user = $this->userRepository->getUserByUsername($_SESSION['username']);
            if ($user && $user->getIsAdmin()) {
                $tipText = $_POST['tipText'];
                $this->tipRepository->insertTip($tipText);
                echo "Tip added successfully!";
            } else {
                //Fake information for security reasons
                echo "Invalid request";
            }
        } else {
            echo "Invalid request";
        }
        exit;
    }

}