<?php 
function updateProfile($userID, $newName, $newEmail, $newPosition, $newColor) {
    include("config.php");
    
    if($conn->connect_error) 
        return ['success' => false, 'error' => 'Connection failed: ' . $conn->connect_error];

    // Update the user profile in the database
    $sql = "UPDATE registrations SET name = '$newName', email = '$newEmail', position='$newPosition', color='$newColor' WHERE id = $userID";

    if ($conn->query($sql) === TRUE) {
        // Profile update successful
        $conn->close();
        return ['success' => true];
    } else {
        // Profile update failed
        $error = 'Error updating record: ' . $conn->error;
        $conn->close();
        return ['success' => false, 'error' => $error];
    }
}

function emailCheck($email) {
    include("config.php");
    // Check if email already exists
    $checkQuery = "SELECT COUNT(*) FROM registrations WHERE email = ?";
    $checkStmt = $conn->prepare($checkQuery);
    $checkStmt->bind_param("s", $email);
    $checkStmt->execute();
    $checkStmt->bind_result($count);
    $checkStmt->fetch();
    $checkStmt->close();
    return $count;
}
?>