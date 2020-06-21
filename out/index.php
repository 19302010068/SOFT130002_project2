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
    <title>Home</title>
    <link rel="stylesheet" href="css/styles.css" media="all">
    <link rel='stylesheet' href='css/index.css' media='all'>
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
            <li><strong>Home</strong></li>
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
<main class="index-main">
    <h2>Featured photos</h2>
    <a href="details.php?id=40"><img src="/img/medium/222222.jpg" alt="222222.jpg"></a>
    <hr>
<div id="v-index-dice" class="index-dice">
    <div class="roll" style="display:none" @click="roll"></div>
<div class="overview">
    <article v-for="(photo, index) in photos" :class="active[index] ? '' : 'removed'">
        <div><a :href="'details.php?id=' + photo.id"><img :src="'/img/medium/' + photo.path" :alt="photo.path" :style="photo.style"></a></div>
        <h3>{{ photo.title }}</h3>
        <p>{{ photo.description }}</p>
    </article>
</div>
</div>
</main>
<aside class="index-aside">
    <input type="image" src="/img/icons/30.png" alt="Refresh" onclick="$('.roll').click()">
    <a href="#"><img src="/img/icons/92.png" alt="To top"></a>
</aside>
<footer class="index-footer"><a href="https://github.com/19302010068"><img src="/img/55232798.png" alt="19302010068"></a>19302010068@fudan.edu.cn</footer>
<script src='js/index.js'></script>
</body>
</html>