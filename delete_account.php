<?php
// Include database connection or any necessary files
require_once 'config.php';

// Start the session (if not already started)
session_start();

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];

    // Perform the account deletion
    $deleteQuery = "DELETE FROM registrations WHERE id = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param('i', $userId);
    $stmt->execute();

    // Check if deletion was successful
    if ($stmt->affected_rows > 0) {
        // Logout the user and redirect to a login page
        session_destroy();
        header('Location: login.php');
        exit();
    } else {
        // Handle deletion failure
        echo 'Error deleting account.';
    }

    // Close any database connections
    $stmt->close();
    $conn->close();
} else {
    // Redirect to login page if the user is not logged in
    header('Location: login.php');
    exit();
}
?>