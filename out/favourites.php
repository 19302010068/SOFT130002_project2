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
    <title>Favourites</title>
    <link rel="stylesheet" href="css/styles.css" media="all">
    <link rel='stylesheet' href='css/favourites.css' media='all'>
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
<main>
    <h2>Favourites</h2>
<div id="v-favourites-result" class="favourites-result">
    <div class="load-result" style="display:none" @click="loadResult"></div>
    <p v-if="photos.length === 0">No photos yet</p>
<div class="overview">
    <article v-for="(photo, index) in photos" :class="active[index] ? '' : 'removed'">
        <div><a :href="'details.php?id=' + photo.id"><img :src="'/img/medium/' + photo.path" :alt="photo.path" :style="photo.style"></a></div>
        <h3>{{ photo.title }}<input type='image' src='/img/icons/5.png' alt='Starred' v-if='active[index]' @click='toggleStar(index)'><input type='image' src='/img/icons/6.png' alt='Unstarred' v-if='!active[index]' @click='toggleStar(index)'></h3>
        <p>{{ photo.description }}</p>
    </article>
</div>
</div>
<nav id="v-pages" class="pages" v-show="pages > 1">
    <div class="load-pages" style="display:none" @click="loadPages"></div>
    <div class="numbers">
        <template v-for="number in numbers">
            <input type="button" v-if="number" :class="(number === current) ? 'current' : ''" :value="number" @click="fetchPage($event)">
            <span v-else>...</span>
        </template>
    </div>
    <div class="operations">
        <input type="button" value="&lt; Prev" @click="fetchPage(current - 1)">
        <input type="button" value="Next &gt;" @click="fetchPage(current + 1)">
        <label>
            <span>Go to page:</span>
            <input type="number" v-model.number="toPage" :min="1" :max="pages">
            <input type="button" value="Go" @click="fetchPage(toPage)">
        </label>
    </div>
</nav>
</main>
<footer class="footer">19302010068@fudan.edu.cn</footer>
<script src='js/favourites.js'></script>
</body>
</html>