<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="container">
        <div class="log-container box">

            <?php 
            session_start();
            include("config.php");

            // Define an initial value for the error message
            $errorMessage = "";

            if(isset($_POST["submit"])) {
                $email = $_POST["Email"];
                $password = $_POST["Passwort"];

                // Check if email exists
                $checkQuery = "SELECT * FROM registrations WHERE email = ?";
                $checkStmt = $conn->prepare($checkQuery);
                $checkStmt->bind_param("s", $email);
                $checkStmt->execute();
                $result = $checkStmt->get_result();
                $user = $result->fetch_assoc();
                $checkStmt->close();

                if ($user) {
                    // Verify the hashed password
                    if (password_verify($password, $user['password'])) {
                        
                        // Regenerate session ID after successful login
                        session_regenerate_id(true);

                        // Store user information in the session
                        $_SESSION['user_id'] = $user['id'];
                        $_SESSION['username'] = $user['name'];
                        $_SESSION['email'] = $user['email'];
                        $_SESSION['password'] = $user['password'];
                        $_SESSION['position'] = isset($user['position']) ? $user['position'] : '/';
                        $_SESSION['color'] = $user['color'];
                        
                        header("Location:index.php");
                        die();
                    } else {
                        $errorMessage = "Login failed. Invalid password.";
                    }
                } else {
                    $errorMessage = "Login failed. Email not found.";
                }
            }
            ?>

            <form action="" method="post">
                <h2>Login</h2>
                <div class="input">
                    <input type="email" name="Email" required placeholder="Email">
                    <input type="password" name="Passwort" required placeholder="Passwort">
                    <!-- Display the error message-->
                    <p style="color: red;"><?php echo $errorMessage; ?></p>
                    <input type="submit" name="submit" value="Bestätigen" class="button">
                    <p>Noch kein Konto? <a href="register.php">Konto erstellen</a></p>
                </div>
            </form>
        </div>
    </div>
</body>

</html>