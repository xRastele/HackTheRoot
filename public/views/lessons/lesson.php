<?php
include_once __DIR__.'/../session.php';
?>

<!DOCTYPE html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1"/>
    <link rel="stylesheet" type="text/css" href="public/css/style.css">
    <link rel="stylesheet" type="text/css" href="public/css/lesson.css">
    <script type="text/javascript" src="public/js/lesson.js" defer></script>
    <title>HackTheRoot $ Home</title>
</head>
<body>
<div class="container">
    <?php include __DIR__.'/../navbar.php'; ?>

    <div class="sub-container">
        <article>
            <h1><?= $lesson->getLessonName() ?></h1>
            <div id="lesson">
                <h3>
                    <?php
                    $lessonFilePath = __DIR__.'/'.$lesson->getLessonId().'.php';
                    if (file_exists($lessonFilePath)) {
                        include($lessonFilePath);
                    } else {
                        echo "<h1>Lesson is currently under maintenance. Thank you for your patience</h1>";
                    }
                    ?>
                </h3>
            </div>
            <h1>Challenges</h1>
            <?php foreach ($lesson->getChallenges() as $challenge): ?>
                <h3>
                    <?= $challenge->getChallengeText(); ?>

                        <?php
                        if($challenge->getIsCompleted()) {
                            echo "- Completed (" . $challenge->getReward() . ' pts)';
                        } else {
                            echo "- <span id='is-done-".$challenge->getChallengeId() . "'>Not completed</span> (" . $challenge->getReward() . ' pts)';
                        }
                        ?>
                    </span>
                </h3>
                <?php if (!$challenge->getIsCompleted()): ?>
                    <form class="challenge-form" data-challenge-id="<?= $challenge->getChallengeId(); ?>">
                        <input id="input-to-hide-<?= $challenge->getChallengeId(); ?>" type="text" name="answer" placeholder="Type your answer here">
                        <button id="button-to-hide-<?= $challenge->getChallengeId(); ?>" type="submit">Submit</button>
                    </form>
                    <div class="challenge-feedback" id="feedback-<?= $challenge->getChallengeId(); ?>"></div>
                <?php endif; ?>
            <?php endforeach; ?>
        </article>
    </div>
</div>
</body>