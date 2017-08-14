<?php
header('Content-Type: text/html; charset=utf-8');
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<!DOCTYPE html >
<html lang="ru">
<head>
<title>Ekb 20+</title>
    <meta name="Description" content="Ekaterinburg 20+" />
    <meta name="Keywords" content="Ekaterinburg, SSC" />
    <meta name="Author" content="Ilis" />
</head>
<body>
<h1>EKB 20+</h1>

<?php

require_once('config/db.php');

$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

/* проверка подключения */
if ($mysqli->connect_errno) {
    printf("Не удалось подключиться: %s\n", $mysqli->connect_error);
    exit();
}

$mysqli->set_charset("utf8");

$query = "SELECT
s.id,
s.ssc_name,
s.levels,
s.osm_type,
s.osm_id
FROM skyscrapers s
ORDER BY s.id;";
$result = $mysqli->query($query);

echo "<p>\n";

/* ассоциативный массив */
while ($row = $result->fetch_array(MYSQLI_ASSOC)){
    printf ("{\"id\": %s, \"ssc_name\": \"%s\", \"levels\": %s} ", $row["id"], $row["ssc_name"], $row["levels"]);
    //$url = "http://www.openstreetmap.org/api/0.6/relation/0/full";
    switch ($row["osm_type"]) {
        case "n":
            $url_api = "http://www.openstreetmap.org/api/0.6/node/".$row["osm_id"];
            $url_osm = "http://www.openstreetmap.org/node/".$row["osm_id"];
            break;
        case "w":
            $url_api = "http://www.openstreetmap.org/api/0.6/way/".$row["osm_id"]."/full";
            $url_osm = "http://www.openstreetmap.org/way/".$row["osm_id"];
            break;
        case "r":
            $url_api = "http://www.openstreetmap.org/api/0.6/relation/".$row["osm_id"]."/full";
            $url_osm = "http://www.openstreetmap.org/relation/".$row["osm_id"];
            break;
        default:
            $url_api = "http://www.openstreetmap.org/";
            $url_osm = "http://www.openstreetmap.org/";
            break;
    }
    printf ("<a href=\"%s\">osm</a> <a href=\"%s\">api</a><br />\n", $url_osm, $url_api);
}

echo "</p>\n";

$result->free();

$mysqli->close();
?>
</body>
</html>
