<?php

require_once('classes/db.php');
$dbString = file_get_contents("data/db.json");
$dbJSON = json_decode($dbString, true);
$DB = new db($dbJSON['host'], $dbJSON['user'], $dbJSON['pass'], $dbJSON['db']);

/**
 * The route for retrieving content using the ID parameter
 */

if ($DB->connect()) {
    if (isset($_GET['linkID'])){
        $DB->query('SELECT link FROM entries WHERE ID = :id', [':id' => $_GET['linkID']]);
        if ($DB->query->rowCount() != 0) {
            $result = $DB->get();
            header('Location: ' . $result['link']);
        } else {
            echo 'Geen entry met dit ID gevonden';
        }
    } else if(isset($_GET['id'])) {
        $DB->query('SELECT content, type FROM entries WHERE ID = :id', [':id' => $_GET['id']]);
        if ($DB->query->rowCount() != 0) {
            $result = $DB->get();
            if ($result['type'] === 'image') {
                echo 'JAJSDKALHJKLDSJLsda';
                header('Location: ' . $result['content']);
//                echo '<img src="'. header('Location: ' . $result['content']) .'" href="'. $result['link'] .'" alt="'. $result['link'] .'">';
                die();
            } else {
                echo $result['content'];
//                echo '<a href="'. $result['link'] .'">'. $result['content'] .'</a>';
            }
        } else {
            echo 'Geen entry met dit ID gevonden';
        }
    }
    $DB->close();
}
