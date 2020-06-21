<?php
session_start();
$from = (int)$_GET["from"];
$to = (int)$_GET["to"];
$columns = $_GET["columns"];
$range = array_slice($_SESSION["query-result"], $from, $to - $from);
$range = join(",", $range);

require "../mysqli.php";
switch ($columns)
{
    case ["id", "title", "path"]:
        travelImageFetch("ImageID, Title, PATH");
        break;
    case ["id", "title", "description", "path"]:
        travelImageFetch("ImageID, Title, Description, PATH");
        break;
}

function travelImageFetch($columns)
{
    global $mysqli, $range;

    $sql = "SELECT $columns FROM travelimage WHERE ImageID IN ($range)";
    $result = $mysqli->query($sql)->fetch_all();
    echo json_encode($result);
}