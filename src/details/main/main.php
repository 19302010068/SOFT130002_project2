<main class="details-main">
<?php
php(<<< 'PHP'
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
PHP
);
?>
    <h2><?php php('echo $title'); ?></h2>
    <img src="/img/medium/<?php php('echo $path'); ?>" alt="<?php php('echo $path'); ?>">
    <hr>
    <section>
        <div id="author">by <a href="photos.php?name=<?php php('echo $user'); ?>"><?php php('echo $user'); ?></a></div>
        <div id="meta">
            <div id="content"><a href="#"><?php php('echo $content'); ?></a></div>
            <div id="location"><a href="#"><?php php('echo $city'); ?></a>, <a href="#"><?php php('echo $country'); ?></a></div>
        </div>
        <p><?php php('echo $description'); ?></p>
    </section>
    <button id="v-details-main" class="action" @click="toggleStar"><img src="/img/icons/5.png" alt="Starred" v-if="starred"><img src="/img/icons/6.png" alt="Unstarred" v-if="!starred"><span><?php php('echo $stars'); ?></span></button>
</main>