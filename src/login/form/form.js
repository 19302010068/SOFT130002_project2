let loc = document.URL.match(/.*(\?.*)/);
loc = loc ? loc[1] : "";
$("form").attr("action", "login-auth.php" + loc);