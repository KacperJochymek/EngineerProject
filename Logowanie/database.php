<?php

$hostName = "localhost";
$dbUser = "root";
$dbPassword ="";
$dbName = "login_register";
$conn = mysqli_connect($hostName, $dbUser, $dbPassword, $dbName);

if(!$conn){
    die("Coś poszło nie tak. 404 ERROR.");
}

?>