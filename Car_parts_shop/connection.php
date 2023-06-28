<?php
$servername = "localhost";
$username = "root";
$connectionPassword = "";
$dbname = "car_parts_shop";

// Create connection
$conn = mysqli_connect($servername, $username, $connectionPassword, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}