<?php
// Assuming you have a database connection in config.php
require_once 'config.php';

// Check if the user is logged in
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Access user information from the session
$userID = $_SESSION['user_id'];

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve task information from the form
    $title = $_POST["title"];
    $description = $_POST["description"];
    $startDateTime = $_POST["startDateTime"];  
    $endDateTime = $_POST["endDateTime"];
    $color = $_SESSION['color'];

    // Insert the new task into the database
    $sql = "INSERT INTO tasks (user_id, title, description, start_date, end_date, color_user) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssss", $userID, $title, $description, $startDateTime, $endDateTime, $color);
    
    if ($stmt->execute()) {
        // Task insertion successful
        // Redirect back to the tasks page or perform other actions as needed
        header("Location: index.php");
        exit;
    } else {
        // Task insertion failed
        // You might want to handle this situation, e.g., display an error message
        echo "Error: " . $stmt->error;
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
} else {
    // If the form is not submitted via POST, redirect to the tasks page
    header("Location: index.php");
    exit;
}

// Don't close the database connection here if you plan to perform further operations
?>