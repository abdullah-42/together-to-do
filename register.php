<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrierung</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="container">
        <div class="form-container box">

            <?php 
            include("config.php");
            include_once("functions.php");

            // Define an initial value for the error message
            $errorMessage = "";

            if(isset($_POST["submit"])) {
                $username = $_POST["Name"];
                $email = $_POST["Email"];
                $password = $_POST["Passwort"];
                $passwordrepeat = $_POST["PasswortRepeat"];

                if($passwordrepeat == $password){ 
                // Hash the password
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

                $count = emailCheck($email);

                if ($count > 0) {
                    // Update the error message
                    $errorMessage = "Email already exists. Please choose a different email address.";
                } else {
                    // Continue with the insert query
                    $insertQuery = "INSERT INTO registrations (name, email, password) VALUES (?, ?, ?)";
                    $insertStmt = $conn->prepare($insertQuery);
                    $insertStmt->bind_param("sss", $username, $email, $hashedPassword);

                    if ($insertStmt->execute()) {
                        $errorMessage = "Registration successful!";
                        header("Location:login.php");
                    } else {
                        $errorMessage = "Error: " . $insertStmt->error;
                    }

                    $insertStmt->close();
                }
                } else {
                    $errorMessage = "Password does not match";
                }

            }
        ?>

            <form action="" method="post">
                <h2>Registrierung</h2>
                <div class="input">
                    <input type="text" name="Name" required placeholder="Name">
                    <input type="email" name="Email" required placeholder="Email">
                    <input type="password" name="Passwort" required placeholder="Passwort">
                    <input type="password" name="PasswortRepeat" required placeholder="Passwort wiederholen">
                    <!-- Display the error message -->
                    <p style="color: red;"><?php echo $errorMessage; ?></p>
                    <input type="submit" name="submit" value="Bestätigen" class="button">
                </div>
                <p>Bereits registriert? <a href="login.php">Login</a></p>
            </form>
        </div>
    </div>
</body>

</html>