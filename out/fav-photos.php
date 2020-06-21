<?php
session_start();
require "../mysqli.php";
$user = $_SESSION["user"];
$sql = "SELECT ImageID FROM travelimagefavor INNER JOIN traveluser ON travelimagefavor.UID = traveluser.UID
WHERE UserName = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $user);
$stmt->execute();
$result = $stmt->get_result();
$_SESSION["query-result"] = array_map(function($item){return $item[0];}, $result->fetch_all());
echo $result->num_rows;