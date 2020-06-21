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
    <title>Search</title>
    <link rel="stylesheet" href="css/styles.css" media="all">
    <link rel='stylesheet' href='css/search.css' media='all'>
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
            <li><strong>Search</strong></li>
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
<main class="search-main">
<section id="v-search-parameters" class="search-parameters">
    <div class="where">
        <div>Search in</div>
        <div>
            <label><input type="radio" name="where" value="title" v-model="where">title</label>
            <label><input type="radio" name="where" value="description" v-model="where">description</label>
        </div>
    </div>
    <div class="what">
        <div>Search for</div>
        <div><label><input type="search" name="what" v-model="what"></label></div>
    </div>
    <input class="action" type="button" value="Search" @click="search">
</section>
    <hr>
<section id="v-search-result" class="search-result">
    <div class="load-result" style="display:none" @click="loadResult"></div>
    <p v-if="photos.length === 0">No result found</p>
<div class="overview">
    <article v-for="(photo, index) in photos" :class="active[index] ? '' : 'removed'">
        <div><a :href="'details.php?id=' + photo.id"><img :src="'/img/medium/' + photo.path" :alt="photo.path" :style="photo.style"></a></div>
        <h3>{{ photo.title }}</h3>
        <p>{{ photo.description }}</p>
    </article>
</div>
</section>
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
<script src='js/search.js'></script>
</body>
</html>