<?php
$host = "127.0.0.1";
$user = "root";
$pass = "";
$database = "hbilling";
$port = 3307;

$conn = mysqli_connect($host, $user, $pass, $database, $port);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
