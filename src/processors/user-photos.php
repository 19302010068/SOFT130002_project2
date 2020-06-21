<?php
session_start();
require "../mysqli.php";
$name = $_POST["name"];
$sql = "SELECT ImageID FROM travelimage INNER JOIN traveluser ON travelimage.UID = traveluser.UID WHERE UserName = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $name);
$stmt->execute();
$result = $stmt->get_result();
$_SESSION["query-result"] = array_map(function($item){return $item[0];}, $result->fetch_all());
echo $result->num_rows;