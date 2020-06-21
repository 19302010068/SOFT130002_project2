<?php
require "../mysqli.php";
$sql = "SELECT travelimage.ImageID, Title, Description, PATH FROM travelimage";
$result = $mysqli->query($sql);

const LIMIT = 6;
$random = [];
while (count($random) < LIMIT)
{
    $val = rand(0, $result->num_rows - 1);
    if (array_search($val, $random, true) === false)
        array_push($random, $val);
}
for ($i = 0; $i < LIMIT; $i++)
{
    $result->data_seek($random[$i]);
    $random[$i] = $result->fetch_row();
}
echo json_encode($random);