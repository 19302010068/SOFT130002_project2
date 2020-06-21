<?php
session_start();
require "../mysqli.php";
$imageID = (int)$_POST["img"];

$sql = "SELECT UID FROM traveluser WHERE UserName = $_SESSION[user]";
$result = $mysqli->query($sql)->fetch_row();
$userID = $result[0];

$sql = "SELECT COUNT(*) FROM travelimagefavor WHERE UID = ? and ImageID = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("ii", $userID, $imageID);
$stmt->execute();
$result = $stmt->get_result()->fetch_row();

if ($result[0] === 0)
    toggleFavor("INSERT INTO travelimagefavor (UID, ImageID) VALUES (?, ?)");
else
    toggleFavor("DELETE FROM travelimagefavor WHERE UID = ? and ImageID = ?");

function toggleFavor($sql)
{
    global $mysqli, $userID, $imageID;

    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ii", $userID, $imageID);
    $stmt->execute();
    if ($stmt->affected_rows === 1)
        echo "success";
}