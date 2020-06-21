<?php
session_start();
require "../mysqli.php";

$sql = "SELECT UID FROM traveluser WHERE UserName = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $_SESSION["user"]);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 1)
    $user = $result->fetch_row()[0];
else
    error();

if (array_keys($_POST) === ["id"])
{
    $sql = "SELECT PATH FROM travelimage WHERE ImageID = ? AND UID = $user";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $_POST["id"]);
    $stmt->execute();
    $path = $stmt->get_result()->fetch_row()[0];

    query("DELETE FROM travelimage WHERE ImageID = ?", "i" , $_POST["id"]);
    queryIgnoreResult("DELETE FROM travelimagefavor WHERE ImageID = ?", "i", $_POST["id"]);
    unlink("img/medium/$path");
    echo "success";
}
elseif ($_POST["id"] === "0")
{
    $file = $_FILES["file"];
    if (is_uploaded_file($file["tmp_name"]))
    {
        if (preg_match("/.*(\..*)/", $file["name"], $extension))
            $extension = $extension[1];
        else
            $extension = "";

        do
        {
            $path = rand(1E9, 1E10 - 1).$extension;
            $sql = "SELECT COUNT(*) FROM travelimage WHERE PATH = ?";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("s", $path);
            $stmt->execute();
        }
        while ($stmt->get_result()->fetch_row()[0]);
    }
    else
        error();

    $sql = "SELECT ImageID FROM travelimage ORDER BY ImageID DESC LIMIT 1";
    $imageID = $mysqli->query($sql)->fetch_row()[0] + 1;

    $sql = "SELECT ISO FROM geocountries_regions WHERE Country_RegionName = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $_POST["country"]);
    $stmt->execute();
    $country = $stmt->get_result()->fetch_row()[0];

    $sql = "SELECT GeoNameID FROM geocities WHERE AsciiName = ? AND Country_RegionCodeISO = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ss", $_POST["city"], $country);
    $stmt->execute();
    $city = $stmt->get_result()->fetch_row()[0];

    if (array_search($_POST["content"], ["Scenery", "City", "People", "Animal", "Building", "Wonder", "Other"], true) === false)
        error();
    else
        $content = strtolower($_POST["content"]);

    query("INSERT INTO travelimage (ImageID, Title, Description, CityCode, Country_RegionCodeISO, UID, PATH, Content) VALUES (?, ?, ?, ?, ?, ?, ?, ?)",
        "issisiss", $imageID, $_POST["title"], $_POST["description"], $city, $country, $user, $path, $content);
    move_uploaded_file($file["tmp_name"], "img/medium/$path");
    header("Location: photos.php");
}
else
{
    $sql = "SELECT PATH FROM travelimage WHERE ImageID = ? AND UID = $user";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $_POST["id"]);
    $stmt->execute();
    $path = $stmt->get_result()->fetch_row()[0];

    $file = $_FILES["file"];
    if (is_uploaded_file($file["tmp_name"]))
    {
        $originalPath = $path;
        if (preg_match("/.*(\..*)/", $file["name"], $extension))
            $extension = $extension[1];
        else
            $extension = "";

        if (preg_match("/(.*)\..*/", $path, $name))
            $path = $name[1].$extension;
        else
            $path .= $extension;
    }

    $sql = "SELECT ISO FROM geocountries_regions WHERE Country_RegionName = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $_POST["country"]);
    $stmt->execute();
    $country = $stmt->get_result()->fetch_row()[0];

    $sql = "SELECT GeoNameID FROM geocities WHERE AsciiName = ? AND Country_RegionCodeISO = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ss", $_POST["city"], $country);
    $stmt->execute();
    $city = $stmt->get_result()->fetch_row()[0];

    if (array_search($_POST["content"], ["Scenery", "City", "People", "Animal", "Building", "Wonder", "Other"], true) === false)
        error();
    else
        $content = strtolower($_POST["content"]);

    queryIgnoreResult("UPDATE travelimage SET Title = ?, Description = ?, CityCode = ?, Country_RegionCodeISO = ?, PATH = ?, Content = ? WHERE ImageID = ?",
        "ssisssi", $_POST["title"], $_POST["description"], $city, $country, $path, $content, $_POST["id"]);
    if (isset($originalPath))
    {
        unlink($originalPath);
        move_uploaded_file($file["tmp_name"], "img/medium/$path");
    }
    header("Location: photos.php");
}

function query($sql, $types, ...$params)
{
    if (queryIgnoreResult($sql, $types, ...$params) !== 1)
        error();
}

function queryIgnoreResult($sql, $types, ...$params)
{
    global $mysqli;

    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    return $stmt->affected_rows;
}

function error()
{
    throw new Exception();
}