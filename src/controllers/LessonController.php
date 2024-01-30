<?php

require_once 'AppController.php';
require_once __DIR__.'/../repository/LessonRepository.php';
require_once __DIR__.'/../repository/ChallengeRepository.php';
require_once __DIR__.'/../repository/UserRepository.php';

class LessonController extends AppController
{
    public function __construct()
    {
        parent::__construct();
        $this->lessonRepository = new LessonRepository();
        $this->challengeRepository = new ChallengeRepository();
        $this->userRepository = new UserRepository();
    }

    public function lesson()
    {
        if (!isset($_SESSION["username"])) {
            header("Location: /");
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['lesson_id'])) {
            $lessonId = $_POST['lesson_id'];
            $this->lessonRepository = new LessonRepository();

            $user = $this->userRepository->getUserByUsername($_SESSION['username']);
            $userId = $user->getUserId();

            $lesson = $this->lessonRepository->getLesson($lessonId, $userId);

            $this->render('lessons/lesson', ['lesson' => $lesson]);
        } else {
            die("Invalid request");
        }
    }

    public function submitChallenge()
    {
        if (!isset($_SESSION["username"])) {
            header("Location: /");
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            $challengeId = $data['challengeId'] ?? '';
            $answer = $data['answer'] ?? '';

            $user = $this->userRepository->getUserByUsername($_SESSION['username']);
            $userId = $user->getUserId();

            $challenge = $this->challengeRepository->getChallengeById($challengeId, $userId);
            $isCorrect = $challenge->checkAnswer($answer);
            $reward = $isCorrect ? $challenge->getReward() : 0;
            if($isCorrect)
                $this->challengeRepository->updateUserProgress($userId, $challengeId, $isCorrect);

            header('Content-Type: application/json');
            echo json_encode(['correct' => $isCorrect, 'reward' => $reward]);
        } else {
            http_response_code(405); // Method Not Allowed
            echo "Invalid request method";
        }
    }
}