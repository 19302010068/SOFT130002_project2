<?php
session_start();
$logged = isset($_SESSION["user"]) ? "\"$_SESSION[user]\"" : "false";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php</title>
    <link rel="stylesheet" href="css/styles.css" media="all">
    <link rel='stylesheet' href='css/login-auth.css' media='all'>
    <script src="lib/jquery-3.5.1.js"></script>
    <script src="lib/vue.js"></script>
    <script>
        data = {logged: <?php
echo $logged;
?>
};
    </script>
</head>
<body>
<script src='js/login-auth.js'></script>
</body>
</html>