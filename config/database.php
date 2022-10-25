<?php

require 'constants.php';


$hostname = "localhost";
$username = "sumit_sharma";
$password = "admin123";
$dbname = "blog";
$port = "3307";

$conn = new mysqli($hostname, $username, $password, $dbname, $port);

if (!$conn) {
    die(mysqli_error($conn));
}
