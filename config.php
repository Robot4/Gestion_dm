<?php

$host = "localhost";
$user = "root";
$password = "";
$db = "gestion_dm";

session_start();

$data = mysqli_connect($host, $user, $password, $db);

if ($data === false) {
    die("connection error");
}

?>