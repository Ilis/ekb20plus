<?php
header('Content-Type: text/html; charset=utf-8');
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<!DOCTYPE html >
<html lang="ru">
<head>
<title>Ilis — welcome</title>
    <meta name="Description" content="000webhost explore" />
    <meta name="Keywords" content="Ilis, Deore, test" />
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
s.levels
FROM skyscrapers s
ORDER BY s.id;";
$result = $mysqli->query($query);

echo "<p>\n";

/* ассоциативный массив */
while ($row = $result->fetch_array(MYSQLI_ASSOC)){
    printf ("{\"id\": %s, \"ssc_name\": \"%s\"}, \"levels\": %s}<br />\n", $row["id"], $row["ssc_name"], $row["levels"]);
}

echo "</p>\n";

$result->free();

$mysqli->close();
?>
</body>
</html>
