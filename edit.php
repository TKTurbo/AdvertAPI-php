<?php

require_once('classes/db.php');
$dbString = file_get_contents("data/db.json");
$dbJSON = json_decode($dbString, true);
$DB = new db($dbJSON['host'], $dbJSON['user'], $dbJSON['pass'], $dbJSON['db']);
$data = json_decode(file_get_contents('php://input'), true);

//echo $DB->pdo->lastInsertId();

if ($_GET['key'] === $dbJSON['key']) {
    if ($DB->connect()) {
        $DB->query('SELECT * FROM entries WHERE ID = :id',
            [':id' => $data['id']]);
        $previousData = $DB->get();

        $DB->query('UPDATE entries SET content = :content, link = :link, type = :contentType WHERE id = :id',
            [':content' => $data['content'], ':link' => $data['link'], ':contentType' => $data['type'], ':id' => $data['id']]);

        echo 'Bij de entry met het ID ' . $data['id'] . ' is de content "' . $data['content'] . '", de link "' . $data['link'] . '" en het type "' . $data['type'] .
            '" (hiervoor was de content "' . $previousData['content'] . '", de link "' . $previousData['link'] . '" en het type "' . $previousData['type'] . '")';
        // TODO: add link
        $DB->close();
    }
} else {
    echo 'Verkeerde key!';
}
