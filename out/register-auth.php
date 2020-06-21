<?php
session_start();
$salt = "aCzAIA3hKgDfR6AS4";
$username = $_POST["username"];
if (!preg_match("/^[\w.-]{1,32}$/", $username))
    reject("Invalid username");
$email = $_POST["email"];
if (!preg_match("/^\w+@\w+(\.\w+)*$/", $email) || strlen($email) > 255)
    reject("Invalid email");
$password = $_POST["password"];
if (!preg_match("/^.{8,32}$/", $password))
    reject("Invalid password");

require "../mysqli.php";
$tb = "traveluser";

$sql = "SELECT COUNT(*) FROM $tb WHERE UserName = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
if ($stmt->get_result()->fetch_row()[0])
    reject("Sorry, but that username has been taken");

$state = 1;
$now = gmdate("Y-m-d H:i:s");
$pwh = hash("sha256", $_POST["password"].$salt);
$sql = "INSERT INTO $tb (Email, UserName, Pass, State, DateJoined) VALUES (?, ?, ?, ?, ?)";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("sssis", $email, $username, $pwh, $state, $now);
$stmt->execute();
if (!$stmt->affected_rows)
    reject("An error occurred whilst trying to create your account<br>Please try again");
else
{
    $_SESSION["msg"] = "Your account has been successfully created. You may now log in";
    header("Location: login.php");
}

function reject($msg)
{
    $_SESSION["msg"] = $msg;
    header("Location: register.php");
}