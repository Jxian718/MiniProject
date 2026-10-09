<?php

session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Admin Page</title>
</head>

<body>

    <h1>Bank System</h1>

    <h2>
        Welcome, <?php echo htmlspecialchars($_SESSION["name"]); ?>!
    </h2>

    <p>Welcome to the Admin Page.</p>

    <hr>
    <a href="logout.php">Logout</a>

</body>

</html>
