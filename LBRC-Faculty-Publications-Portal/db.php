<?php
$servername = "localhost";
$username = "root";  // change to your MySQL username
$password = "";      // change to your MySQL password
$dbname = "lbrcernd";  // name of your database

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
