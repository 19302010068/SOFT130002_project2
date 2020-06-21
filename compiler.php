<?php
$time_start = microtime(true);

require "mysqli.php";

foreach (["out", "out/css", "out/js"] as $dir)
{
    if (!file_exists($dir))
        mkdir($dir);
}

$dirty_pages = [];
$dirty_components = [];
$components = [];

$sql = "SELECT Path FROM components";
$result = $mysqli->query($sql);
if ($result)
{
    foreach ($result->fetch_all() as $row)
        array_push($components, $row[0]);
}

foreach (descendantFiles("src") as $file)
{
    $md5_src = md5_file($file);

    $fragments = mb_split("/", $file,3);
    $isProc = $fragments[1] === "processors";
    if ($fragments[1].".php" === $fragments[2] || $isProc)
        $tb = "pages";
    else
    {
        $tb = "components";
        if (($index = array_search($file, $components, true)) !== false)
            unset($components[$index]);
    }

    $sql = "SELECT Checksum FROM $tb WHERE Path = '$file'";
    $result = $mysqli->query($sql);
    if ($result->num_rows)
    {
        $md5_dat = $result->fetch_row()[0];
        if ($md5_src === $md5_dat)
            continue;
        else
            $mysqli->query("UPDATE $tb SET Checksum = '$md5_src' WHERE Path = '$file'");
    }
    else
        $mysqli->query("INSERT INTO $tb (Path, Checksum) VALUES ('$file', '$md5_src')");

    if ($tb === "pages")
        array_push($dirty_pages, $file);
    else
        array_push($dirty_components, $file);
}

$sql = "SELECT pages.Path FROM pages INNER JOIN (dependencies INNER JOIN components ON ComponentID = components.ID)
ON pages.ID = PageID WHERE components.Path = ?";
$stmt = $mysqli->prepare($sql);
foreach ($dirty_components as $file)
{
    $stmt->bind_param("s", $file);
    $stmt->execute();
    $result = $stmt->get_result();
    foreach ($result->fetch_all() as $row)
    {
        if (array_search($row[0], $dirty_pages, true) === false)
            array_push($dirty_pages, $row[0]);
    }
}

changes_log("pages", $dirty_pages);
changes_log("components", $dirty_components);

if ($components)
{
    $sql = "DELETE FROM components WHERE Path = ?";
    $stmt = $mysqli->prepare($sql);
    foreach ($components as $file)
    {
        $stmt->bind_param("s", $file);
        $stmt->execute();
    }
}

foreach ($dirty_pages as $file)
{
    if (mb_split("/", $file,3)[1] === "processors")
    {
        $name = mb_split("/", $file, 3)[2];
        file_put_contents("out/$name", file($file));
        continue;
    }

    exec("\"xampp/php/php.exe\" \"compiler/template.php\" $file $isProc",$output, $ret);
    if ($ret !== 0)
        continue;

    $pageID = $mysqli->query("SELECT ID FROM pages WHERE Path = '$file'")->fetch_row()[0];

    $sql = "SELECT ID, Path FROM components INNER JOIN dependencies ON ID = ComponentID WHERE PageID = $pageID";
    $result = $mysqli->query($sql);
    $old_dependencies = $result->fetch_all();

    $output = join("\r\n", $output);
    $fragments = mb_split("<css>|<js>|<dependencies>", $output);
    $output = null;
    $name = mb_split("/", $file, 3)[1];
    file_put_contents("out/$name.php", $fragments[0]);
    file_put_contents("out/css/$name.css", $fragments[1]);
    file_put_contents("out/js/$name.js", $fragments[2]);
    $new_dependencies = unserialize($fragments[3]);

    for ($i = 0, $j = count($old_dependencies); $i < $j; $i++)
    {
        if (($index = array_search($old_dependencies[$i][1], $new_dependencies, true)) !== false)
            unset($old_dependencies[$i], $new_dependencies[$index]);
    }

    if ($old_dependencies)
    {
        $sql = "DELETE FROM dependencies WHERE PageID = $pageID AND ComponentID = ?";
        $stmt = $mysqli->prepare($sql);
        foreach ($old_dependencies as $row)
        {
            $stmt->bind_param("i", $row[1]);
            $stmt->execute();
        }
    }
    if ($new_dependencies)
    {
        $sql = "SELECT ID FROM components WHERE Path = ?";
        $stmt = $mysqli->prepare($sql);
        foreach ($new_dependencies as $key => $value)
        {
            $stmt->bind_param("s", $value);
            $stmt->execute();
            $result = $stmt->get_result();
            $new_dependencies[$key] = $result->fetch_row()[0];
        }

        $sql = "INSERT INTO dependencies (PageID, ComponentID) VALUES ($pageID, ?)";
        $stmt = $mysqli->prepare($sql);
        foreach ($new_dependencies as $row)
        {
            $stmt->bind_param("i", $row);
            $stmt->execute();
        }
    }
}

$time_end = microtime(true);
printf("Compilation complete in %.2fs\r\n", $time_end - $time_start);

function descendantFiles($dir)
{
    $descendants = [];
    foreach (scandir($dir) as $child)
    {
        if (in_array($child, [".", "..", "lib"]))
            continue;

        $child = "$dir/$child";
        if (is_dir($child))
        {
            foreach (descendantFiles($child) as $file)
                array_push($descendants, $file);
        }
        else
            array_push($descendants, $child);
    }
    return $descendants;
}

function changes_log($dirty_name, $dirty_var)
{
    if ($dirty_var)
    {
        echo "Changed $dirty_name:\r\n";
        foreach ($dirty_var as $file)
            echo $file."\r\n";
    }
    else
        echo "No $dirty_name changed\r\n";
    echo "--------------------------------\r\n";
}