<?php
session_start();
require "../mysqli.php";
$salt = "aCzAIA3hKgDfR6AS4";
$sql = "SELECT COUNT(*) FROM traveluser WHERE UserName = ? AND Pass = ?";
$pwh = hash("sha256", $_POST["password"].$salt);
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("ss", $_POST["username"], $pwh);
$stmt->execute();
if ($stmt->get_result()->fetch_row()[0])
{
    $now = gmdate("Y-m-d H:i:s");
    $sql = "UPDATE traveluser SET DateLastModified = ?  WHERE UserName = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ss", $now, $_POST["username"]);
    $stmt->execute();

    $_SESSION["user"] = $_POST["username"];
    $_SESSION["msg"] = "Login successful";

    if (isset($_GET["from"]))
    {
        $from = $_GET["from"];
        unset($_GET["from"]);
    }
    else
        $from = "";
    header("Location: /$from".queryString());
}
else
{
    $_SESSION["msg"] = "Wrong username or password";
    header("Location: login.php".queryString());
}

function queryString()
{
    $fragments = [];
    foreach ($_GET as $key => $value)
        array_push($fragments, "$key=$value");
    return $fragments ? "?".join("&", $fragments) : "";
}