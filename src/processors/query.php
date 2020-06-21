<?php
session_start();
require "../mysqli.php";
$db = $_POST["db"];
$columns = $_POST["columns"];
$data = $_POST["data"];
switch ($db)
{
    case "travelimage":
        switch ($columns)
        {
            case ["title"]:
                travelImageQuery("SELECT ImageID FROM travelimage WHERE Title LIKE ?", "%$data[0]%");
                break;
            case ["content"]:
                travelImageQuery("SELECT ImageID FROM travelimage WHERE Content = ?", $data[0]);
                break;
            case ["country"]:
                travelImageQuery("SELECT ImageID FROM travelimage INNER JOIN geocountries_regions ON Country_RegionCodeISO = ISO WHERE Country_RegionName = ?", $data[0]);
                break;
            case ["city"]:
                travelImageQuery("SELECT ImageID FROM travelimage INNER JOIN geocities ON CityCode = GeoNameID WHERE AsciiName = ?", $data[0]);
                break;
            case ["content", "country", "city"]:
                travelImageQuery("SELECT ImageID FROM (travelimage INNER JOIN geocountries_regions ON Country_RegionCodeISO = ISO) INNER JOIN geocities ON CityCode = geocities.GeoNameID WHERE Content = ? AND Country_RegionName = ? AND AsciiName = ?", ...$data);
                break;
            case ["where", "what"]:
                switch ($data[0])
                {
                    case "title":
                        travelImageQuery("SELECT ImageID FROM travelimage WHERE Title LIKE ?", "%$data[1]%");
                        break;
                    case "description":
                        travelImageQuery("SELECT ImageID FROM travelimage WHERE Description LIKE ?", "%$data[1]%");
                        break;
                }
        }
        break;
}

function travelImageQuery($sql, ...$params)
{
    global $mysqli;

    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param(str_repeat("s", count($params)), ...$params);
    $stmt->execute();
    $result = $stmt->get_result();
    $_SESSION["query-result"] = array_map(function($item){return $item[0];}, $result->fetch_all());
    echo $result->num_rows;
}