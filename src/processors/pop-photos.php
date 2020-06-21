<?php
require "../mysqli.php";
$sql = "SELECT travelimage.ImageID, Title, Description, PATH FROM travelimage INNER JOIN travelimagefavor
ON travelimage.ImageID = travelimagefavor.ImageID GROUP BY travelimagefavor.ImageID ORDER BY COUNT(*) DESC LIMIT 6";
$result = $mysqli->query($sql)->fetch_all();
echo json_encode($result);