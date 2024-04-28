<?php
// Assuming you have a database connection in config.php
require_once 'config.php';

// Fetch only tasks from the database with associated username
$sql = "SELECT t.id, t.title, t.start_date, t.end_date, t.description, t.color_user, t.created_at, u.name
        FROM tasks t
        JOIN registrations u ON t.user_id = u.id";

$result = $conn->query($sql);

// Initialize an array to store tasks
$tasks = array();

// Check if there are rows in the result set
if ($result->num_rows > 0) {
    // Loop through each row and add it to the tasks array
    while ($row = $result->fetch_assoc()) {
        // Format dates before adding them to the $tasks array
        $formattedStartDate = date("Y-m-d H:i:s", strtotime($row['start_date']));
        $formattedEndDate = date("Y-m-d H:i:s", strtotime($row['end_date']));

        // Add the task with formatted dates to the $tasks array
        $tasks[] = array(
            'id' => $row['id'],
            'title' => $row['title'],
            'start' => $formattedStartDate,
            'end' => $formattedEndDate,
            'description' => $row['description'],
            'color' => $row['color_user'],
            'created_at' => $row['created_at'],
            'username' => $row['name'],
            'color_user' => $row['color_user'],
            'comments' => array(), // Initialize an empty array for comments
        );
    }
}

// Close the database connection
$conn->close();

// Output the tasks in JSON format
header('Content-Type: application/json');
echo json_encode($tasks);
?>