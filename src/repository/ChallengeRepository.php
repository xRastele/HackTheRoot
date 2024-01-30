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
            $rewardId = $challengeData['reward_id'];
            $reward = $this->getRewardPoints($rewardId);
            $challengeId = $challengeData['challenge_id'];
            $isCompleted = $this->isChallengeCompleted($userId, $challengeId);
            $challenges[] = new Challenge(
                $challengeData['challenge_id'],
                $challengeData['lesson_id'],
                $reward,
                $challengeData['challenge_text'],
                $challengeData['challenge_answer'],
                $isCompleted
            );
        }

        return $challenges;
    }

    public function isChallengeCompleted($userId, $challengeId)
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

        if ($result === false) {
            return false;
        }

        $isCompleted = $result['is_completed'];
        return $isCompleted;
    }

    public function getChallengeById($challengeId, $userId)
    {
        $stmt = $this->database->connect()->prepare('
            SELECT challenges.*, rewards.reward_points 
            FROM challenges 
            JOIN rewards ON challenges.reward_id = rewards.reward_id
            WHERE challenge_id = :challengeId;
        ');
        $stmt->bindParam(':challengeId', $challengeId, PDO::PARAM_INT);
        $stmt->execute();
        $challengeData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($challengeData === false) {
            return null;
        }

        $rewardId = $challengeData['reward_id'];
        $reward = $this->getRewardPoints($rewardId);

        return new Challenge(
            $challengeData['challenge_id'],
            $challengeData['lesson_id'],
            $reward,
            $challengeData['challenge_text'],
            $challengeData['challenge_answer'],
            $this->isChallengeCompleted($userId, $challengeData['challenge_id'])
        );
    }

    public function getRewardPoints($rewardId){
        $stmt = $this->database->connect()->prepare('
                SELECT reward_points FROM rewards WHERE reward_id = :reward_id;
            ');
        $stmt->bindParam(':reward_id', $rewardId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC)['reward_points'];
    }

    public function updateUserProgress($userId, $challengeId, $isCorrect)
    {
        $stmt = $this->database->connect()->prepare('
        SELECT update_user_progress(:userId, :challengeId, :isCorrect);
    ');
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':challengeId', $challengeId, PDO::PARAM_INT);
        $stmt->bindParam(':isCorrect', $isCorrect, PDO::PARAM_BOOL);
        $stmt->execute();
    }

}