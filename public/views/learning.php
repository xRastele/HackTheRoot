<?php
include_once __DIR__.'/session.php';
?>
<!DOCTYPE html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1"/>
    <link rel="stylesheet" type="text/css" href="public/css/style.css">
    <link rel="stylesheet" type="text/css" href="public/css/learning.css">
    <title>HackTheRoot $ Learning</title>
</head>
<body>
<div class="container">
    <?php include __DIR__.'/navbar.php'; ?>
    <div class="sub-container">
        <?php foreach ($modules as $module): ?>
            <div class="module-container">
                <div class="module-name-and-progress-container">
                    <span class="module-name-only"><?= $module->getModuleName() ?></span>
                </div>
                <div class="lessons-container">
                    <?php if (count($module->getLessons()) > 0): ?>
                        <?php foreach ($module->getLessons() as $lesson): ?>
                            <div class="lesson-name-and-progress-container">
                                <span id="lesson-name-only"><a href="learning/<?= $module->getModuleId() ?>/lesson/<?= $lesson->getLessonId() ?>"><?= $lesson->getLessonName() ?></a></span>
                                <span id="lesson-progress-only"><?= $lesson->getCompletedChallenges() ?>/<?= $lesson->getTotalChallenges() ?></span>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="no-lessons-container">
                            <span id="no-lessons">Coming soon...</span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
</body>
