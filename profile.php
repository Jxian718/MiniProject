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

    <title>My Profile - Bank System</title>

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #f4f6f9;
        }

        .sidebar 
        {
            position: fixed;
            left: 0;
            top: 0;
            width: 220px;
            height: 100vh;
            background-color: #1e293b;
            color: white;
            padding: 20px;
        }

        .sidebar h2 
        {
            margin-bottom: 30px;
            text-align: center;
        }

        .sidebar ul 
        {
            list-style: none;
        }

        .sidebar ul li 
        {
            margin: 15px 0;
        }

        .sidebar ul li a 
        {
            display: block;
            color: white;
            text-decoration: none;
            padding: 12px;
            border-radius: 6px;
        }

        .sidebar ul li a:hover 
        {
            background-color: #334155;
        }

        .main 
        {
            margin-left: 220px;
            min-height: 100vh;
            padding: 35px;
        }

        .header 
        {
            background-color: white;
            padding: 25px;
            border-radius: 12px;
            margin-bottom: 25px;
        }

        .header h1 
        {
            margin-bottom: 8px;
            color: #1e293b;
        }

        .header p 
        {
            color: #64748b;
        }

        .profile-card 
        {
            background-color: white;
            border-radius: 15px;
            padding: 40px;
            width: 100%;
            min-height: 650px;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.08);
        }

        .profile-top 
        {
            text-align: center;
            padding-bottom: 30px;
            border-bottom: 1px solid #e2e8f0;
        }

        .profile-photo 
        {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
          
            margin-bottom: 20px;
        }

        .profile-top h2 
        {
            color: #1e293b;
            font-size: 28px;
            margin-bottom: 8px;
        }

        .profile-top p 
        {
            color: #64748b;
            font-size: 16px;
        }

        .profile-info 
        {
            margin-top: 35px;
        }

        .profile-info h3 
        {
            color: #1e293b;
            margin-bottom: 20px;
            font-size: 21px;
        }

        .info-grid 
        {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .info-box 
        {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 20px;
        }

        .info-box label 
        {
            display: block;
            color: #64748b;
            font-size: 14px;
            margin-bottom: 8px;
        }

        .info-box p 
        {
            color: #1e293b;
            font-size: 17px;
            font-weight: bold;
        }

        .account-number 
        {
            color: #2563eb !important;
        }

        .active 
        {
            color: #16a34a !important;
        }
    </style>

</head>


<body>



    <div class="sidebar">
        <h2>Bank System</h2>

        <ul>
            <li><a href="user.php">Dashboard</a></li>
            <li><a href="profile.php">My Profile</a></li>
            <li><a href="transfer.php">Transfer</a></li>
            <li><a href="transactions.php">Transactions</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>

    </div>

    <div class="main">
        <div class="header">
            <h1>My Profile</h1>
            <p>View your personal and bank account information.</p>
        </div>

    <div class="profile-card">

        <div class="profile-top">
                <img src="user.webp"alt="Profile Photo"class="profile-photo">
                <h2>Thai Jinxian</h2>
                <p>Bank System User</p>
            </div>

            <div class="profile-info">
                <h3>Account Information</h3>


                <div class="info-grid">

                    <div class="info-box">
                        <label>Full Name</label>
                        <p>Thai Jinxian</p>
                    </div>

                    <div class="info-box">
                        <label>Account Number</label>
                        <p class="account-number">1234567890</p>
                    </div>

                    <div class="info-box">
                        <label>Email Address</label>
                        <p>user@example.com</p>
                    </div>

                    <div class="info-box">
                        <label>Phone Number</label>
                        <p>012-3456789</p>
                    </div>

                    <div class="info-box">
                        <label>Account Status</label>
                        <p class="active">● Active</p>
                    </div>

                    <div class="info-box">
                        <label>Account Type</label>
                        <p>Savings Account</p>
                    </div>


                </div>

            </div>

        </div>
    </div>


</body>

</html>
