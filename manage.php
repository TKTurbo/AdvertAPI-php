<?php

$dbString = file_get_contents("data/db.json");
$dbJSON = json_decode($dbString, true);

if(!$_GET['key']) {
    echo 'Key is undefined';
} else if($_GET['key'] === $dbJSON['key']) {
    readfile("templates/manage.html");
    echo '<script src="templates/index.js"></script>';
} else {
    echo 'Key is incorrect';
}
