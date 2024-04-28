<?php

$server = 'localhost';  // Change this if your MySQL server is on a different machine
$username = 'root';     // Your MySQL username
$password = '';         // Your MySQL password
$database = 'test';     // Your MySQL database name

// Create a global connection
global $conn;
$conn = new mysqli($server, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>