<?php

// phpinfo();

require_once('classes/db.php');

$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'advertapi';

const key = 'testKey672138'; // for authentication

$DB = new db($host, $user, $pass, $db);

//echo $_SERVER['REQUEST_URI'];

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
}
