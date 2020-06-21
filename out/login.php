<?php
session_start();
$logged = isset($_SESSION["user"]) ? "\"$_SESSION[user]\"" : "false";
if (isset($_SESSION["msg"]))
{
    $message = "\"$_SESSION[msg]\"";
    unset($_SESSION["msg"]);
}
else
    $message = "false";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="css/styles.css" media="all">
    <link rel='stylesheet' href='css/login.css' media='all'>
    <script src="lib/jquery-3.5.1.min.js"></script>
    <script src="lib/vue.min.js"></script>
    <script>
        data = {
            logged: <?php
echo $logged;
?>
,
            message: <?php
echo $message;
?>
,};
        if (data.message)
            $(document).ready(function(){msgbox.setMessage(data.message);});
    </script>
</head>
<body>
<header id="v-header" class="header">
    <div class="info">
        <div v-if="logged">Logged in as <strong>{{ logged }}</strong></div>
        <div><time>{{ time }}</time></div>
    </div>
    <h1>Share Your Travels</h1>
    <nav>
        <ul class="site">
            <template></template>
            <li><a href="/">Home</a></li>
            <template></template>
            <li><a href="browse.php">Browse</a></li>
            <template></template>
            <li><a href="search.php">Search</a></li>
            <li v-if="!(logged || excluded)"><a :href="location">Login</a></li>
            <li v-if="excluded"><strong>Login</strong></li>
        </ul>
        <div class="user" v-if="logged">
            <span>Me</span>
            <ul>
                <li><a href="upload.php">Upload</a></li>
                <li><a href="photos.php">My photos</a></li>
                <li><a href="favourites.php">Favourites</a></li>
                <li><a href="logout.php">Log out</a></li>
            </ul>
        </div>
    </nav>
</header>
<div id="v-msgbox" class="msgbox"><p v-if="message" v-html="message"></p></div>
<main class="login-main">
    <h2>Login</h2>
<div class="form" style="display:none"></div>
<div class="login-form form">
    <form method="post">
        <label>
            <span>Username</span>
            <input type="text" name="username" required>
        </label>
        <label>
            <span>Password</span>
            <input type="password" name="password" required>
        </label>
        <div>
            <span></span>
            <input class="action" type="submit" value="Login">
        </div>
    </form>
    <p>If you don't have an account then please <a href="register.php">register</a>.</p>
</div>
</main>
<footer class="footer">19302010068@fudan.edu.cn</footer>
<script src='js/login.js'></script>
</body>
</html>