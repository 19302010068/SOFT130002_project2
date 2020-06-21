<main class="upload-main">
<?php
php(<<< 'PHP'
if (isset($_GET["id"]))
{
    require "../mysqli.php";
    $sql = "SELECT ImageID, Title, Description, AsciiName, Country_RegionName, PATH, Content FROM travelimage
INNER JOIN geocities ON CityCode = geocities.GeoNameID
INNER JOIN geocountries_regions ON travelimage.Country_RegionCodeISO = ISO
INNER JOIN traveluser ON travelimage.UID = traveluser.UID
WHERE ImageID = ? AND UserName = ?
";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("is", $_GET["id"], $_SESSION["user"]);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 1)
    {
        $result = $result->fetch_row();
        echo <<< HTML
<script>
data.imageData =
{
    id: $result[0],
    title: "$result[1]",
    description: "$result[2]",
    city: "$result[3]",
    country: "$result[4]",
    path: "img/medium/$result[5]",
    content: "$result[6]",
};
</script>

HTML;
    }
    else
        $_SESSION["msg"] = "The requested photo does not exist, or you are not its author";
}
PHP
);
?>
    <h2>Upload</h2>
<?php req("components/form-styles"); ?>

<?php req("upload/form"); ?>

</main>