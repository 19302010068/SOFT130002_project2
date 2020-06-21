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
    <title>Details</title>
    <link rel="stylesheet" href="css/styles.css" media="all">
    <link rel='stylesheet' href='css/details.css' media='all'>
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
<main class="details-main">
<?php
$imageID = (int)$_GET["id"];
require "../mysqli.php";

$sql = "SELECT Title, Description, AsciiName, Country_RegionName, UID, PATH, Content
FROM (travelimage INNER JOIN geocities ON CityCode = GeoNameID)
INNER JOIN geocountries_regions ON travelimage.Country_RegionCodeISO = ISO
WHERE ImageID = $imageID";
$result = $mysqli->query($sql)->fetch_row();
[$title, $description, $city, $country, $userID, $path, $content] = $result;

$sql = "SELECT UserName FROM traveluser WHERE UID = $userID";
$result = $mysqli->query($sql)->fetch_row();
$user = $result[0];

$sql = "SELECT COUNT(*) FROM travelimagefavor WHERE ImageID = $imageID";
$result = $mysqli->query($sql)->fetch_row();
$stars = $result[0];

$starred = "false";
if ($logged)
{
    $sql = "SELECT COUNT(*) FROM travelimagefavor INNER JOIN traveluser ON travelimagefavor.UID = traveluser.UID
    WHERE ImageID = $imageID AND UserName = $logged";
    $result = $mysqli->query($sql)->fetch_row();
    if ($result[0])
        $starred = "true";
}
echo "<script>data.starred = $starred;</script>";

$mysqli->close();
?>
    <h2><?php
echo $title
?>
</h2>
    <img src="/img/medium/<?php
echo $path
?>
" alt="<?php
echo $path
?>
">
    <hr>
    <section>
        <div id="author">by <a href="photos.php?name=<?php
echo $user
?>
"><?php
echo $user
?>
</a></div>
        <div id="meta">
            <div id="content"><a href="#"><?php
echo $content
?>
</a></div>
            <div id="location"><a href="#"><?php
echo $city
?>
</a>, <a href="#"><?php
echo $country
?>
</a></div>
        </div>
        <p><?php
echo $description
?>
</p>
    </section>
    <button id="v-details-main" class="action" @click="toggleStar"><img src="/img/icons/5.png" alt="Starred" v-if="starred"><img src="/img/icons/6.png" alt="Unstarred" v-if="!starred"><span><?php
echo $stars
?>
</span></button>
</main>
<footer class="footer">19302010068@fudan.edu.cn</footer>
<script src='js/details.js'></script>
</body>
</html>