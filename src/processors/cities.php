<?php
require "../mysqli.php";
$limit = 20;
$sql = "SELECT AsciiName FROM geocities INNER JOIN geocountries_regions ON Country_RegionCodeISO = ISO
WHERE Country_RegionName = ? AND AsciiName LIKE ? GROUP BY AsciiName LIMIT $limit";
$stmt = $mysqli->prepare($sql);
$country = $_GET["country"];
$city = "%$_GET[city]%";
$stmt->bind_param("ss", $country, $city);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === $limit)
    $result = [];
else
    $result = array_map(function($item){return $item[0];}, $result->fetch_all());
echo json_encode($result);