<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/Challenge.php';
require_once __DIR__.'/../models/Lesson.php';

class LessonRepository extends Repository {
    public function getLesson($lessonId, $userId) {
        $stmt = $this->database->connect()->prepare('
        SELECT * FROM lessons WHERE lesson_id = :lessonId;
    ');
        $stmt->bindParam(':lessonId', $lessonId, PDO::PARAM_INT);
        $stmt->execute();
        $lessonData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($lessonData === false) {
            return null;
        }

        $challengeRepository = new ChallengeRepository();
        $challenges = $challengeRepository->getChallengesForLesson($lessonId, $userId ?? null);

        return new Lesson(
            $lessonData['lesson_id'],
            $lessonData['module_id'],
            $lessonData['lesson_name'],
            $challenges
        );
    }

}