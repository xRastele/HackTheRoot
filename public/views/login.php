<!DOCTYPE html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1"/>
    <link rel="stylesheet" type="text/css" href="public/css/style.css">
    <link rel="stylesheet" type="text/css" href="public/css/login.css">
    <title>HackTheRoot $ Login</title>
</head>
<body>
<div class="container">
    <div class="logo">
        <img src="public/img/logo.svg" alt="Logo">
    </div>
    <div id="bottom-div">
        <div class="start-learning-container">
            <h1>Master</h1>
            <h1>Cybersecurity</h1>
            <p>
                Practice vulnerabilities with challenges
                and improve your hacking skills
            </p>
            <a href="/register"><button>Start learning</button></a>
        </div>
        <div class="login-container">
            <form class="login" action="login" method="POST">
                <div class="messages">
                    <?php if(isset($messages)) {
                        foreach ($messages as $message) {
                            echo $message;
                        }
                    }
                    ?>
                </div>
                <input name="email" type="text" placeholder="Email">
                <input name="password" type="password" placeholder="Password">
                <button type="submit">Login</button>
            </form>
        </div>
    </div>
</div>
</body>