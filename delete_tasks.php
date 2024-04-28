<?php
// Assuming you have a database connection in config.php
require_once 'config.php';

// Get the task ID from the AJAX request
$taskId = $_POST['id'];

$deleteCommentsQuery = "DELETE FROM comments WHERE task_id = ?";
$stmtComments = $conn->prepare($deleteCommentsQuery);
$stmtComments->bind_param('i', $taskId);
$stmtComments->execute();
$stmtComments->close();


$sql = "DELETE FROM tasks WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $taskId);
$stmt->execute();
$stmt->close();
$conn->close();



// Send a response back to the client (optional)
echo json_encode(['status' => 'success']);
?>