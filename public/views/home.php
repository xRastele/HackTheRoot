<?php
include_once __DIR__.'/session.php';
?>
<!DOCTYPE html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1"/>
    <link rel="stylesheet" type="text/css" href="public/css/style.css">
    <link rel="stylesheet" type="text/css" href="public/css/home.css">
    <title>HackTheRoot $ Home</title>
</head>
<body>
<div class="container">
    <?php include __DIR__.'/navbar.php'; ?>

    <div class="sub-container">
        <div class="first-box">
            <p class="box-header">Latest news</p>
            <p><?= $latestNews['news_text'] ?? 'No news'?></p>
            <p><a class="button-link" href="news">Go to news</a></p>
        </div>

        <div class="second-box">
            <p class="box-header">Module Progress</p>
            <?php foreach ($modulesWithProgress as $module): ?>
                <div class="module-progress">
                    <?= $module->getModuleName() ?>
                    <?php
                    $totalChallenges = 0;
                    $completedChallenges = 0;
                    foreach ($module->getLessons() as $lesson) {
                        $totalChallenges += $lesson->getTotalChallenges();
                        $completedChallenges += $lesson->getCompletedChallenges();
                    }

                    $progressPercent = '';
                    if($totalChallenges > 0)
                    {
                        $progressPercent = ' - '.strval(round(($completedChallenges / $totalChallenges) * 100, 2)) . '%';
                    }
                    else
                        $progressPercent = '- Challenges coming soon..';
                    ?>
                    <?= $progressPercent ?>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="third-box">
            <p class="box-header">Latest notification</p>
            <p><?= $latestNotification['notification_text'] ?? 'No notifications'?></p>
            <p><a class="button-link" href="news">Go to notifications</a></p>
        </div>

        <div class="fourth-box">
            <p class="box-header">Tip of the Day</p>
            <p><?= $tipOfTheDay ? $tipOfTheDay->getTipText() : 'No tip for today :(' ?></p>
        </div>
    </div>
</div>
</body>