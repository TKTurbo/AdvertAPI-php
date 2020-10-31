<?php

require_once('classes/db.php');
$dbString = file_get_contents("data/db.json");
$dbJSON = json_decode($dbString, true);
$DB = new db($dbJSON['host'], $dbJSON['user'], $dbJSON['pass'], $dbJSON['db']);
$data = json_decode(file_get_contents('php://input'), true);

if ($_GET['key'] === $dbJSON['key']) {
    if ($DB->connect()) {
        $DB->query('DELETE FROM entries WHERE ID = :id', [':id' => $data['id']]);

        echo 'Entry met ID ' . $data['id'] . ' verwijderd';
        $DB->close();
    }
} else {
    echo 'Verkeerde key!';
}
