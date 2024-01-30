<?php
include_once __DIR__.'/session.php';
if ($_SESSION["username"] != "admin") {
    header("Location: /");
}
?>
<!DOCTYPE html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1"/>
    <link rel="stylesheet" type="text/css" href="public/css/style.css">
    <link rel="stylesheet" type="text/css" href="public/css/news.css">
    <link rel="stylesheet" type="text/css" href="public/css/admin.css">
    <script src="public/js/admin.js" defer></script>
    <title>HackTheRoot $ Home</title>
</head>
<body>
<div class="container">
    <?php include __DIR__.'/navbar.php'; ?>

    <div class="sub-container">
        <div class="admin-panel">
            <h2>Admin Panel - Insert Tip of the Day</h2>
            <form id="tipForm" action="/insertTip" method="POST">
                <textarea name="tipText" placeholder="Enter your tip here..." required></textarea>
                <button type="submit">Submit Tip</button>
            </form>
            <div id="message"></div>
        </div>
    </div>
</div>

</body>