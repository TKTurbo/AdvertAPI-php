<?php

require_once('classes/db.php');
$dbString = file_get_contents("data/db.json");
$dbJSON = json_decode($dbString, true);
$DB = new db($dbJSON['host'], $dbJSON['user'], $dbJSON['pass'], $dbJSON['db']);

if ($DB->connect()) {
    $DB->query('SELECT * FROM entries');
    if ($DB->query->rowCount() != 0) {
        $result = $DB->get('all');
        echo json_encode($result);
    }
    $DB->close();
}
