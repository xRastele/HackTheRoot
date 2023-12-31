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
        <div class="modules-container">
            <div class="module-name-and-progress-container">
                <span class="module-name-only">ATTACK</span>
                <span class="module-progress-only">10%</span>
            </div>
            <div class="module-name-and-progress-container">
                <span class="module-name-only">GENERAL</span>
                <span class="module-progress-only">0%</span>
            </div>
            <div class="module-name-and-progress-container">
                <span class="module-name-only">DEFENCE</span>
                <span class="module-progress-only"></span>
            </div>
        </div>
        <div class="lessons-container" id="background-dark">
            <div class="lessons-column-container">
                <div id="background-light" class="lesson-name-and-progress-container">
                    <span id="lesson-name-only"><a href="learning/1/lesson/1">SQL Injection</a></span>
                    <span id="lesson-progress-only">0/11</span>
                </div>
                <div class="lesson-name-and-progress-container">
                    <span id="lesson-name-only"><a href="learning/1/lesson/2">Cross-Site Scripting (XSS)</a></span>
                    <span id="lesson-progress-only">0/11</span>
                </div>
                <div id="background-light" class="lesson-name-and-progress-container">
                    <span id="lesson-name-only"><a href="learning/1/lesson/3">File inclusion</a></span>
                    <span id="lesson-progress-only">0/11</span>
                </div>
            </div>
            <div class="lessons-column-container">
                <div id="background-light" class="lesson-name-and-progress-container">
                    <span class="background-light" id="lesson-name-only"><a href="learning/2/lesson/1">Linux commands</a></span>
                    <span class="background-light" id="lesson-progress-only">0/11</span>
                </div>
                <div class="lesson-name-and-progress-container">
                    <span id="lesson-name-only"><a href="learning/2/lesson/2">Bash</a></span>
                    <span id="lesson-progress-only">0/11</span>
                </div>
                <div id="background-light" class="lesson-name-and-progress-container">
                    <span id="lesson-name-only"><a href="learning/2/lesson/3">Python3</a></span>
                    <span id="lesson-progress-only">0/11</span>
                </div>
            </div>
            <div class="lessons-column-container">
                <div id="not-available" class="lesson-name-and-progress-container">
                    <span>Coming soon...</span>
                </div>
            </div>

        </div>
    </div>
</div>
</body>