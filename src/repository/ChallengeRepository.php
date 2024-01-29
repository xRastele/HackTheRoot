<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/Challenge.php';

class ChallengeRepository extends Repository
{
    public function getChallengesForLesson($lessonId, $userId) {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM challenges WHERE lesson_id = :lessonId;
        ');
        $stmt->bindParam(':lessonId', $lessonId, PDO::PARAM_INT);
        $stmt->execute();
        $challengesData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $challenges = [];
        foreach ($challengesData as $challengeData) {
            $challenges[] = new Challenge(
                $challengeData['challenge_id'],
                $challengeData['lesson_id'],
                $challengeData['reward_id'],
                $challengeData['challenge_text'],
                $challengeData['challenge_answer'],
                $this->isChallengeCompleted($userId, $challengeData['challenge_id'])
            );
        }

        return $challenges;
    }

    public function isChallengeCompleted($userId, $challengeId): bool
    {
        $userId = intval($userId);
        $stmt = $this->database->connect()->prepare('
            SELECT is_completed FROM user_progress 
            WHERE user_id = :userId AND challenge_id = :challengeId;
        ');
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':challengeId', $challengeId, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return (bool)$result['is_completed'];
    }
}