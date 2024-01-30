<?php

class Challenge {
    private $challengeId;
    private $lessonId;
    private $reward;
    private $challengeText;
    private $challengeAnswer;
    private $isCompleted;

    public function __construct($challengeId, $lessonId, $reward, $challengeText, $challengeAnswer, $isCompleted) {
        $this->challengeId = $challengeId;
        $this->lessonId = $lessonId;
        $this->reward = $reward;
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

    public function getReward() {
        return $this->reward;
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

    public function checkAnswer($answer) {
        return $this->challengeAnswer === $answer;
    }
}