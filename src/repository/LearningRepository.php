<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/Lesson.php';
require_once __DIR__.'/../models/Module.php';
require_once __DIR__.'/../models/User.php';
require_once 'ChallengeRepository.php';

class LearningRepository extends Repository
{
    public function getModulesWithLessons(): array
    {
        $result = [];

        $stmt = $this->database->connect()->prepare('
            SELECT * FROM modules;
        ');
        $stmt->execute();
        $modulesData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($modulesData as $moduleData) {
            $moduleId = $moduleData['module_id'];
            $moduleName = $moduleData['module_name'];

            $stmt = $this->database->connect()->prepare('
                SELECT * FROM lessons WHERE module_id = :moduleId ORDER BY lesson_id;
            ');
            $stmt->bindParam(':moduleId', $moduleId, PDO::PARAM_INT);
            $stmt->execute();
            $lessonsData = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $lessons = [];
            foreach ($lessonsData as $lessonData) {
                $lessons[] = new Lesson(
                    $lessonData['lesson_id'],
                    $lessonData['module_id'],
                    $lessonData['lesson_name']
                );
            }

            $result[] = new Module($moduleId, $moduleName, $lessons);
        }

        return $result;
    }

    public function getLearningProgress($userId): array
    {
        $modulesWithLessons = $this->getModulesWithLessons();
        $challengeRepository = new ChallengeRepository();

        foreach ($modulesWithLessons as $module) {
            foreach ($module->getLessons() as $lesson) {
                $totalChallenges = 0;
                $completedChallenges = 0;

                $challenges = $challengeRepository->getChallengesForLesson($lesson->getLessonId(), $userId);

                foreach ($challenges as $challenge) {
                    $lesson->addChallenge($challenge);
                    $totalChallenges += 1;
                    if($challengeRepository->isChallengeCompleted($userId, $challenge->getChallengeId()))
                    {
                        $completedChallenges += 1;
                    }
                }

                $lesson->setTotalChallenges($totalChallenges);
                $lesson->setCompletedChallenges($completedChallenges);
            }
        }

        return $modulesWithLessons;
    }
}