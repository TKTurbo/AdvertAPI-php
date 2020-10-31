<?php

require_once('classes/db.php');
$dbString = file_get_contents("data/db.json");
$dbJSON = json_decode($dbString, true);
$DB = new db($dbJSON['host'], $dbJSON['user'], $dbJSON['pass'], $dbJSON['db']);

/**
 * The route for retrieving content using the ID parameter
 */

if ($DB->connect()) {
    if (!$_GET['id']) {
        echo 'Query ID is undefined';
    } else {
        $DB->query('SELECT * FROM entries WHERE ID = :id', [':id' => $_GET['id']]);
        if ($DB->query->rowCount() != 0) {
            $result = $DB->get();
            if ($result['type'] === 'image') {
                header('Location: ' . $result['content']);
                die();
            } else {
                echo $result['content'];
            }
        } else {
            echo 'Geen entries met dit ID gevonden';
        }
    }
    $DB->close();
}
