<?php
$path = $argv[1];
$file = array_map("rtrim", file($path));

$index = strrpos($path, "/");
$dir = substr($path, 0, $index);
$path = substr($path, 0, -4);
$name = substr($path, $index + 1);
?>
<?php
php(<<< 'PHP'
session_start();
$logged = isset($_SESSION["user"]) ? "\"$_SESSION[user]\"" : "false";
if (isset($_SESSION["msg"]))
{
    $message = "\"$_SESSION[msg]\"";
    unset($_SESSION["msg"]);
}
else
    $message = "false";
PHP
);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $file[0]; ?></title>
    <link rel="stylesheet" href="css/styles.css" media="all">
    <link rel='stylesheet' href='css/<?php echo $name; ?>.css' media='all'>
    <script src="lib/jquery-3.5.1.min.js"></script>
    <script src="lib/vue.min.js"></script>
    <script>
        data = {
            logged: <?php php('echo $logged;') ?>,
            message: <?php php('echo $message;') ?>,};
        if (data.message)
            $(document).ready(function(){msgbox.setMessage(data.message);});
    </script>
</head>
<body><?php
$css = file_get("$path.css");
$js = file_get("$path.js");

$components = [];
$dependencies = [];
for ($i = 1; $i < count($file); $i++)
{
    $line = $file[$i];
    switch ($line[0])
    {
        case "#":
            $args = args_get($line);
            $subpath = "$dir/$args[0]/$args[0]";
            break;
        case " ":
            $args = args_get($line);
            $subpath = "src/components/$args[0]/$args[0]";
            break;
        default:
            $i++;
            error_log("Syntax error in $name.php:$i");
            exit(1);
    }
    array_shift($args);
    $GLOBALS["args"] = $args;
    $GLOBALS["reqs"] = [$subpath];
    echo "\r\n";
    try
    {
        require "$subpath.php";
    }
    catch (Exception $ex)
    {
        error_log($ex->getMessage());
        exit(1);
    }

    foreach ($GLOBALS["reqs"] as $req)
    {
        if (array_search($req, $components, true))
            continue;
        array_push($components, $req);
        array_push($dependencies, "$req.php");

        if (file_exists("$req.css"))
        {
            array_push($dependencies, "$req.css");

            $cls = class_get("$req.php");
            $cssFile = file("$req.css");
            $selectors = array_filter($cssFile, function($item){return $item[0] === "{";});
            foreach ($selectors as $key => $ignored)
            {
                $key--;
                $cls = ".".class_get("$req.php")." ";
                $cssFile[$key] = join(", ", array_map(function($item)use($cls){return $cls.$item;},
                    mb_split(", ", $cssFile[$key])));
            }

            if ($css)
                $css .= "\r\n\r\n";
            $css .= join($cssFile);
        }

        if ($jsFile = file_get("$req.js"))
        {
            array_push($dependencies, "$req.js");
            if ($js)
                $js .= "\r\n\r\n";
            $js .= "(function ()\r\n{\r\n$jsFile\r\n}());";
        }
    }

}
?>

<script src='js/<?php echo $name; ?>.js'></script>
</body>
</html><?php
echo "<css>$css";
echo "<js>$js";
echo "<dependencies>".serialize($dependencies);

function file_get($path)
{
    return file_exists($path) ? file_get_contents($path) : "";
}

function args_get($str)
{
    $end = strpos($str, "<");
    if ($end === false)
        $end = strlen($str) - 1;
    return mb_split(" ", substr($str, 1, $end));
}

function class_get($file)
{
    $res = fopen($file, "r");
    $line = fgets($res);
    preg_match("/class=\"(.*?)[\" ]/", $line, $result);
    if (array_key_exists(1, $result)) // TODO: should always have a class
    return $result[1];
    return "";
}

function req($req)
{
    $fragments = mb_split("/", $req);
    $req = "src/$req/$fragments[1]";
    array_push($GLOBALS["reqs"], $req);
    require "$req.php";
}

function php($code)
{
    echo "<?php\r\n$code\r\n?>\r\n";
}
?>