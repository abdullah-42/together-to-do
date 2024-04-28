<?php
// Assuming you have a database connection in config.php
require_once 'config.php';

// Retrieve the task ID from the AJAX request
$taskId = $_POST['id'];
$title = $_POST['title'];
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];

// Update the task record in the database
$sql = "UPDATE tasks
        SET title=?, start_date=?, end_date=?
        WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssi", $title, $start_date, $end_date, $taskId);
$stmt->execute();
$stmt->close();
$conn->close();

// Send a response back to the client (optional)
echo json_encode(['status' => 'success']);
?>