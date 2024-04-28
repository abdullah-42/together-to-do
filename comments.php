<?php
// fetch_comments.php
// Assuming you have a database connection in config.php
require_once 'config.php';

// Check if the task_id is set in the POST request
if (isset($_POST['task_id'])) {
    $taskId = $_POST['task_id'];

    // Fetch comments and user information for the given task_id from the database
    $fetchCommentsQuery = "SELECT c.comment_text, c.created_at, u.name AS username, u.color AS color_user
                      FROM comments c
                      JOIN registrations u ON c.user_id = u.id
                      WHERE c.task_id = ?
                      ORDER BY c.created_at ASC";


    $stmt = $conn->prepare($fetchCommentsQuery);
    $stmt->bind_param('i', $taskId);
    $stmt->execute();
    $result = $stmt->get_result();

    $comments = array();

    // Fetch comments and user information
    while ($row = $result->fetch_assoc()) {
        $commentInfo = array(
            'created_at' => $row['created_at'],
            'comment_text' => $row['comment_text'],
            'username' => $row['username'],
            'user_color' => $row['color_user']
        );
        $comments[] = $commentInfo;
    }

    $response = array('success' => true, 'comments' => $comments);
} else {
    // Invalid request, task_id not set
    $response = array('success' => false, 'message' => 'Invalid request');
}

// Output the response in JSON format
header('Content-Type: application/json');
echo json_encode($response);

// Close the database connection
$conn->close();
?>