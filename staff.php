<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php

session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

?>
</body>
</html>


<head>
    <title>Staff Page</title>
</head>

<body>

    <h1>Bank System</h1>

    <h2>
        Welcome, <?php echo htmlspecialchars($_SESSION["name"]); ?>!
    </h2>

    <p>Welcome to the Staff Page.</p>

    <hr>
    <a href="logout.php">Logout</a>

</body>

</html>
