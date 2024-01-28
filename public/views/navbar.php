<?php
include_once __DIR__.'/session.php';
?>
<nav>
    <a class="username">Welcome, <?php echo $_SESSION["username"]; ?></a>
    <a href="/home">Home</a>
    <a href="/learning">Learning</a>
    <img src="public/img/logo_no_text.svg" alt="Logo">
    <a href="/leaderboard">Leaderboard</a>
    <a href="/news">News</a>
    <a href="/logout">Logout</a>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var path = window.location.pathname;

        var navLinks = document.querySelectorAll('nav a');

        var isPathInNav = Array.from(navLinks).some(function(link) {
            return path.includes(link.getAttribute('href'));
        });

        if (isPathInNav) {
            navLinks.forEach(function(link) {
                if (path.includes(link.getAttribute('href'))) {
                    link.classList.add('active');
                }
            });
        }
    });
</script>
