<?php

require_once('classes/db.php');
$dbString = file_get_contents("data/db.json");
$dbJSON = json_decode($dbString, true);
$DB = new db($dbJSON['host'], $dbJSON['user'], $dbJSON['pass'], $dbJSON['db']);
$data = json_decode(file_get_contents('php://input'), true);

//echo $DB->pdo->lastInsertId();

if ($_GET['key'] === $dbJSON['key']) {
    print_r($data);
    if ($DB->connect()) {
        $DB->query('INSERT INTO entries (content, link, type) VALUES (:content, :link, :type)',
            [':content' => $data['content'], ':link' => $data['link'], ':type' => $data['type']]);

        $last_inserter = $DB->pdo->lastInsertId();
        echo 'Entry toegevoegd met ID ' . $last_inserter;
        $DB->close();
    }
} else {
    echo 'Verkeerde key!';
}
