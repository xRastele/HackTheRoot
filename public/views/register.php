<!DOCTYPE html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1"/>
    <link rel="stylesheet" type="text/css" href="public/css/style.css">
    <link rel="stylesheet" type="text/css" href="public/css/register.css">
    <script type="text/javascript" src="public/js/register.js" defer></script>
    <title>HackTheRoot $ Register</title>
</head>
<body>
<div class="container">
    <div class="logo">
        <img src="public/img/logo.svg" alt="Logo">
    </div>
    <div class="login-container">
        <form action="register" method="POST">
            <div class="messages">
                <?php if(isset($messages)) {
                    foreach ($messages as $message) {
                        echo $message;
                    }
                }
                ?>
            </div>
            <input name="email" type="text" placeholder="Email">
            <input name="username" type="username" placeholder="Username">
            <input name="password" type="password" placeholder="Password">
            <input name="confirmPassword" type="password" placeholder="Confirm password">
            <button>Sign up</button>
            <p>Already have an account? Login <a href="/login">here</a>.</p>
        </form>
    </div>
</div>
</body>