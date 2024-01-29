<?php
class Lesson {
    private $lessonId;
    private $moduleId;
    private $lessonName;
    private $challenges;
    private $totalChallenges = 0;
    private $completedChallenges = 1;

    public function __construct($lessonId, $moduleId, $lessonName, $challenges = []) {
        $this->lessonId = $lessonId;
        $this->moduleId = $moduleId;
        $this->lessonName = $lessonName;
        $this->challenges = $challenges;
    }

    public function getLessonId() {
        return $this->lessonId;
    }

    public function getModuleId() {
        return $this->moduleId;
    }

    public function getLessonName() {
        return $this->lessonName;
    }

    public function getChallenges() {
        return $this->challenges;
    }

    public function addChallenge($challenge) {
        $this->challenges[] = $challenge;
    }

    public function getTotalChallenges() {
        return $this->totalChallenges;
    }

    public function getCompletedChallenges() {
        return $this->completedChallenges;
    }

    public function setTotalChallenges($totalChallenges) {
        $this->totalChallenges = $totalChallenges;
    }

    public function setCompletedChallenges($completedChallenges) {
        $this->completedChallenges = $completedChallenges;
    }
}