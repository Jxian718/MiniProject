<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Page - Bank System</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            color: #333;
        }

        .navbar {
            background-color: #1e3a8a;
            color: white;
            padding: 18px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar h1 {
            font-size: 24px;
        }

        .logout {
            background-color: #dc2626;
            color: white;
            text-decoration: none;
            padding: 10px 18px;
            border-radius: 6px;
        }

        .logout:hover {
            background-color: #b91c1c;
        }

        .container {
            max-width: 1100px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .welcome {
            background-color: white;
            padding: 25px;
            border-radius: 10px;
            margin-bottom: 25px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        .welcome h2 {
            color: #1e3a8a;
            margin-bottom: 8px;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
        }

        .card {
            background-color: white;
            padding: 25px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        .card h3 {
            color: #1e3a8a;
            margin-bottom: 10px;
        }

        .card p {
            color: #666;
            margin-bottom: 20px;
        }

        .button {
            display: inline-block;
            background-color: #1e3a8a;
            color: white;
            text-decoration: none;
            padding: 10px 18px;
            border-radius: 6px;
        }

        .button:hover {
            background-color: #172554;
        }

        footer {
            text-align: center;
            margin-top: 50px;
            padding: 20px;
            color: #777;
        }
    </style>
</head>

<body>

    <div class="navbar">
        <h1>Bank System</h1>

        <a href="logout.php" class="logout">Logout</a>
    </div>

    <div class="container">

        <div class="welcome">
            <h2>
                Welcome,
                <?php echo htmlspecialchars($_SESSION["name"]); ?>!
            </h2>

            <p>Welcome to the Staff Page. Please select an option below.</p>
        </div>

        <div class="cards">

            <div class="card">
                <h3>Customer Management</h3>
                <p>View and manage customer accounts.</p>
                <a href="customers.php" class="button">View Customers</a>
            </div>

            <div class="card">
                <h3>Accounts</h3>
                <p>View and manage bank accounts.</p>
                <a href="accounts.php" class="button">View Accounts</a>
            </div>

            <div class="card">
                <h3>Transactions</h3>
                <p>View customer transactions.</p>
                <a href="transactions.php" class="button">Transactions</a>
            </div>

            <div class="card">
                <h3>Staff Profile</h3>
                <p>View your staff account information.</p>
                <a href="profile.php" class="button">My Profile</a>
            </div>

        </div>

    </div>

    <footer>
        <p>&copy; 2026 Bank System. All rights reserved.</p>
    </footer>

</body>
</html>
