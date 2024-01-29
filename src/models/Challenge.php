<?php

class Challenge {
    private $challengeId;
    private $lessonId;
    private $rewardId;
    private $challengeText;
    private $challengeAnswer;
    private $isCompleted;

    public function __construct($challengeId, $lessonId, $rewardId, $challengeText, $challengeAnswer, $isCompleted) {
        $this->challengeId = $challengeId;
        $this->lessonId = $lessonId;
        $this->rewardId = $rewardId;
        $this->challengeText = $challengeText;
        $this->challengeAnswer = $challengeAnswer;
        $this->isCompleted = $isCompleted;
    }

    public function getChallengeId() {
        return $this->challengeId;
    }

    public function getLessonId() {
        return $this->lessonId;
    }

    public function getRewardId() {
        return $this->rewardId;
    }

    public function getChallengeText() {
        return $this->challengeText;
    }

    public function getChallengeAnswer() {
        return $this->challengeAnswer;
    }

    public function getIsCompleted() {
        return $this->isCompleted;
    }
}