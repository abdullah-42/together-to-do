<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="js/jquery.js"></script>
    <script src="fullcalendar/index.global.js"></script>
    <script src="fullcalendar/index.global.min.js"></script>
    <script src="js/script.js"></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
    <!-- <script defer src='https://static.cloudflareinsights.com/beacon.min.js'
        data-cf-beacon='{"token": "dc4641f860664c6e824b093274f50291"}'></script> -->

    <link rel="stylesheet" href="css/dashboard.css">

    <title>index</title>
</head>

<body>
    <?php
            session_start();

            // Check if the user is logged in
            if (!isset($_SESSION['user_id'])) {
                // Redirect to the login page if not logged in
                header("Location: login.php");
                exit();
            }

            // Access user information from the session
            $userID = $_SESSION['user_id'];
            $username = $_SESSION['username'];
            $email = $_SESSION['email'];
            $password = $_SESSION['password'];
            $color = $_SESSION['color'];
        ?>
    <?php include_once 'navbar.php'; echo PHP_EOL; ?>
    <?php include_once 'sidebar.php'; echo PHP_EOL; ?>
    <div id="calendar"></div>
    <?php include_once 'pop_up.php'; echo PHP_EOL; ?>


</body>

</html>