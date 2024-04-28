<?php
// Assuming you have a database connection in config.php
require_once 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$userId = $_SESSION['user_id'];

// Check if the task_id and comment are set in the POST request
if (isset($_POST['task_id']) && isset($_POST['comment']) && $userId) {
    // Assuming you have a way to determine the current user's ID, replace 1 with the actual user ID
    $taskId = $_POST['task_id'];
    $commentText = $_POST['comment'];

    // Insert the comment into the database
    $insertCommentQuery = "INSERT INTO comments (task_id, user_id, comment_text) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($insertCommentQuery);
    $stmt->bind_param('iis', $taskId, $userId, $commentText);

    if ($stmt->execute()) {
        // Comment inserted successfully
        $response = array('success' => true, 'message' => 'Comment added successfully');
        console_log($response);
    } else {
        // Error inserting comment
        $response = array('success' => false, 'message' => 'Error adding comment');
         console_log($response);

    }

    $stmt->close();
} else {
    // Invalid request, task_id or comment not set
    $response = array('success' => false, 'message' => 'Invalid request');
    console_log('okey, userid leer');
}

// Output the response in JSON format
header('Content-Type: application/json');
echo json_encode($response);

// Close the database connection
$conn->close();
?>