<?php
require "../mysqli.php";
$sql = "SELECT Country_RegionName FROM travelimage INNER JOIN geocountries_regions ON Country_RegionCodeISO = ISO
GROUP BY Country_RegionCodeISO ORDER BY COUNT(*) DESC LIMIT 4";
$result = $mysqli->query($sql)->fetch_all();
$result = array_map(function($item){return $item[0];}, $result);
echo json_encode($result);