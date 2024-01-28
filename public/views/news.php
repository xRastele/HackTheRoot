<?php
include_once __DIR__.'/session.php';
?>
<!DOCTYPE html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1"/>
    <link rel="stylesheet" type="text/css" href="public/css/style.css">
    <link rel="stylesheet" type="text/css" href="public/css/news.css">
    <script type="text/javascript" src="public/js/news.js" defer></script>
    <title>HackTheRoot $ News</title>
</head>
<body>
<div class="container">
    <?php include __DIR__.'/navbar.php'; ?>
    <div class="sub-container">
        <div class="news-htr">
            <h1 class="news-header">HTR</h1>
            <h2 class="news-header">notifications</h2>
            <div class="content-notifications">
                <div id="notifications-container">
                    <div class="notifications-text"></div>
                    <div class="notifications-date"></div>
                </div>
            </div>
        </div>
        <div class="news-cybersec">
            <h1 class="news-header">Cybersecurity</h1>
            <h2 class="news-header">news</h2>
            <div class="content-cybersec">
                <div id="news-container">
                    <div class="news-text"></div>
                    <div class="news-source"></div>
                    <div class="news-date"></div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>