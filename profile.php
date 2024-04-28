<?php
session_start();

// Include the function definition for updateProfile
include_once 'functions.php';

// Ensure the user is logged in before accessing the dashboard
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Access session data
$userID = $_SESSION['user_id'];
$username = $_SESSION['username'];
$email = $_SESSION['email'];
$password = $_SESSION['password'];
$position = $_SESSION['position'];
$color = $_SESSION['color'];

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the new profile information from the form
    $newName = $_POST['newName'];
    $newEmail = $_POST['newEmail'];
    $newPosition = $_POST['newPosition'];
    $newColor = $_POST['newColor'];

    // If the input is empty, use the old name
    $newName = !empty($newName) ? $newName : $username;

    // If the input is empty, use the old email
    $newEmail = !empty($newEmail) ? $newEmail : $email;

    $count = emailCheck($newEmail);
    if ($count > 0 && $userID != $userID) { 
             // Update the error message
            $errorMessage = "Email already exists. Please choose a different email address.";
            } else {
                // Call the function to update the profile
                $updateResult = updateProfile($userID, $newName, $newEmail, $newPosition, $newColor);

            if ($updateResult['success']) {
                // Profile update successful
                $_SESSION['username'] = $newName; 
                $_SESSION['email'] = $newEmail;  
                $_SESSION['position'] = $newPosition; 
                $_SESSION['color'] = $newColor;
                header("Location: profile.php");
                exit();
            } else {
                // Profile update failed
                $errorMessage = "Failed to update profile. " . $updateResult['error'];
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/dashboard.css">
    <script src="js/script.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <title>Profil</title>
</head>

<body>
    <?php include_once 'navbar.php'; echo PHP_EOL; ?>

    <div class="profile-container">
        <div class="form-container box">
            <h2>Benutzerprofil
                <button id="deleteAccountBtn" type="button" class="red-btn" style="float: right;">Account
                    Löschen</button>
            </h2>

            <!-- Display current profile information -->
            <label for="name">Name:</label>
            <p><?php echo htmlspecialchars($username); ?></p>

            <label for="email">Email:</label>
            <p><?php echo htmlspecialchars($email); ?></p>

            <label for="position">Position:</label>
            <p><?php echo htmlspecialchars($position); ?></p>

            <label for="position">Deine To-Do Farbe:</label>
            <p style="color: <?php echo htmlspecialchars($color); ?>; font-size: 40px ; margin: 0px;">●</p>
        </div>


        <div class="updateform-container box">
            <form action="profile.php" method="post">
                <h2>Kontodaten ändern</h2>

                <div class="dropdown-position">
                    <label for="newPosition">Position im Projekt:</label>
                    <select rype="text" name="newPosition" id="rollen">
                        <option value="Projektleiter">Projektleiter</option>
                        <option value="Teilprojektleiter">Teilprojektleiter</option>
                        <option value="Projektmitarbeiter">Projektmitarbeiter</option>
                    </select>
                </div>
                <div class="dropdown-color">
                    <label for="newColor">To-Do Farbe:</label>
                    <select rype="text" name="newColor" id="to-do-color">
                        <option value="#FF5733" style="background-color: #FF5733;">--color-1</option>
                        <option value="#FFD700" style="background-color: #FFD700;">--color-2</option>
                        <option value="#7FFF00" style="background-color: #7FFF00;">--color-3</option>
                        <option value="#40E0D0" style="background-color: #40E0D0;">--color-4</option>
                        <option value="#9370DB" style="background-color: #9370DB;">--color-5</option>
                        <option value="#FFA07A" style="background-color: #FFA07A;">--color-6</option>
                        <option value="#00FA9A" style="background-color: #00FA9A;">--color-7</option>
                        <option value="#FF6347" style="background-color: #FF6347;">--color-8</option>
                        <option value="#20B2AA" style="background-color: #20B2AA;">--color-9</option>
                        <option value="#87CEEB" style="background-color: #87CEEB;">--color-10</option>
                    </select>
                </div>

                <!-- Allow the user to change their name -->
                <label for="newName">neuer Name:</label>
                <input type="text" id="newName" name="newName">

                <!-- Allow the user to change their email -->
                <label for="newEmail">neue Email:</label>
                <input type="email" id="newEmail" name="newEmail"> <br>

                <input type="submit" value="Account Speichern" class="green-btn" style="float: right;">
            </form>
        </div>
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var submitDeleteAcc = document.getElementById('deleteAccountBtn');

        submitDeleteAcc.addEventListener('click', function() {
            if (confirm('Are you sure you want to delete your account?')) {
                deleteAccount();
            }
            // Define your deleteAccount function here
            function deleteAccount() {
                // Make an AJAX request to the server to delete the account
                $.ajax({
                    url: 'delete_account.php',
                    type: 'POST',
                    success: function(response) {
                        // Handle success, e.g., redirect to a login page
                        window.location.href = 'login.php';
                    },
                    error: function(error) {
                        // Handle the error response
                        console.error('Error deleting account');
                        console.error(error);
                    }
                });
            }
        });
    });
    </script>
</body>

</html>
</body>

</html>