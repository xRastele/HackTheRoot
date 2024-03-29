<?php
include_once __DIR__.'/session.php';
$currentUsername = $_SESSION['username'] ?? '';
?>
<!DOCTYPE html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1"/>
    <link rel="stylesheet" type="text/css" href="public/css/style.css">
    <link rel="stylesheet" type="text/css" href="public/css/leaderboard.css">
    <script src="public/js/leaderboard.js" defer></script>
    <title>HackTheRoot $ Leaderboard</title>
</head>
<body>
<div class="container">
    <?php include __DIR__.'/navbar.php'; ?>
    <div class="sub-container">
        <div class="leaderboard-top3">
            <?php foreach ($leaderboard->getUsers() as $index => $user): ?>
                <?php if ($index < 3): ?>
                    <?php
                    $isCurrentUser = ($user->getUsername() === $currentUsername);
                    ?>
                    <div class="top<?= $index + 1; ?> user-entry-top3 <?= $isCurrentUser ? 'current-user' : '' ?>">
                        <img src="public/img/crown.svg">
                        <div>
                            <?= $index+1 . '. ' . $user->getUsername() ?>
                        </div>
                        <div>
                            <img src="public/img/points_icon.svg"><?= $user->getPoints(); ?> pts
                        </div>
                    </div>
                <?php else: ?>
                    <?php break; ?>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
        <div class="leaderboard-rest">
            <?php foreach ($leaderboard->getUsers() as $index => $user): ?>
                <?php if ($index >= 3): ?>
                    <?php
                    $isCurrentUser = ($user->getUsername() === $currentUsername);
                    ?>
                    <div class="user-entry <?= $isCurrentUser ? 'current-user' : '' ?>">
                        <div class="username">
                            <?= $index+1 . '. ' . $user->getUsername() ?>
                        </div>
                        <div class="points">
                            <img src="public/img/points_icon.svg"><?= $user->getPoints() ?> pts
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
            <div class="pagination">
                <button id="prevPage"><</button>
                <span id="currentPage">1</span>
                <button id="nextPage">></button>
            </div>
        </div>

    </div>
</div>
</body>