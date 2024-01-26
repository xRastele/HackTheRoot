<!DOCTYPE html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1"/>
    <link rel="stylesheet" type="text/css" href="public/css/style.css">
    <link rel="stylesheet" type="text/css" href="public/css/leaderboard.css">
    <title>HackTheRoot $ Leaderboard</title>
</head>
<body>
<div class="container">
    <?php include __DIR__.'/navbar.php'; ?>
    <div class="sub-container">
        <div class="leaderboard-top3">
            <?php foreach ($leaderboard->getUsers() as $index => $user): ?>
                <?php if ($index < 3): ?>
                    <div class="top<?= $index + 1; ?>">
                        <img src="public/img/crown.svg">
                        <?= $user->getUsername() ?> <br> <?= $user->getPoints(); ?> pts
                    </div>
                <?php else: ?>
                    <?php break; ?>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
        <div class="leaderboard-rest">
            <?php foreach ($leaderboard->getUsers() as $index => $user): ?>
                <?php if ($index >= 3): ?>
                    <div class="user-entry">
                        <?= $user->getUsername() . ' - ' . $user->getPoints(); ?>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
        <div class="leaderboard-buttons">
            <div class="buttons-left"><-</div>
            <div class="buttons-count">1/1</div>
            <div class="buttons-right">-></div>
        </div>
    </div>
</div>
</body>
