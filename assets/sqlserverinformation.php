<?php
$servername = "127.0.0.1";
$username = "root";
$password = "sami1net";
$database="samanedb";

// Create connection

$conn = mysqli_connect($servername, $username, $password,$database);

if (!$conn){
    die(mysqli_connect_error());
}
