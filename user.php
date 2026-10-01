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

    <title>User Page - Bank System</title>

    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: Arial, sans-serif;
    }

    body
    {
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
        padding: 30px;
    }

    .header
    {
        background-color: white;
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 25px;
    }

    .header h1 {
        margin-bottom: 10px;
        }

        
        .cards {
            display: flex;
            gap: 20px;
            margin-bottom: 25px;
        }

    .card {
            background-color: white;
            padding: 25px;
            border-radius: 10px;
            flex: 1;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

    .card h3 {
            color: #64748b;
            margin-bottom: 10px;
        }

    .balance 
    {
        font-size: 28px;
        font-weight: bold;
        color: #2563eb;
    }

        
    .transactions 
    {
        background-color: white;
        padding: 25px;
        border-radius: 10px;
    }

    .transactions h2 
    {
        margin-bottom: 15px;
    }

        table {
         width: 100%;
        、 border-collapse: collapse;
        }

        table th,
        table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #f8fafc;
        }

        .deposit {
            color: green;
        }

        .withdraw {
            color: red;
        }

        /* Mobile */
        @media (max-width: 700px) {

            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }

            .main {
                margin-left: 0;
            }

            .cards {
                flex-direction: column;
            }
        }
    </style>
</head>

<body>

    <!-- Sidebar -->
    <div class="sidebar">

        <h2>Bank System</h2>

        <ul>
            <li>
                <a href="user.php">Dashboard</a>
            </li>

            <li>
                <a href="profile.php">My Profile</a>
            </li>

            <li>
                <a href="transfer.php">Transfer</a>
            </li>

            <li>
                <a href="transactions.php">Transactions</a>
            </li>

            <li>
                <a href="logout.php">Logout</a>
            </li>
        </ul>

    </div>


    <!-- Main Content -->
    <div class="main">

        <!-- Welcome -->
        <div class="header">

            <h1>
                Welcome,
                <?php echo htmlspecialchars($_SESSION["name"]); ?>!
            </h1>

            <p>You are logged in as a user.</p>

        </div>


        <!-- Cards -->
        <div class="cards">

            <div class="card">

                <h3>Account Balance</h3>

                <p class="balance">
                    RM 5,000.00
                </p>

            </div>


            <div class="card">

                <h3>Account Number</h3>

                <p>
                    1234567890
                </p>

            </div>


            <div class="card">

                <h3>Account Status</h3>

                <p style="color: green;">
                    Active
                </p>

            </div>

        </div>


        <!-- Recent Transactions -->
        <div class="transactions">

            <h2>Recent Transactions</h2>

            <table>

                <tr>
                    <th>Date</th>
                    <th>Description</th>
                    <th>Amount</th>
                </tr>

                <tr>
                    <td>01/10/2026</td>
                    <td>Deposit</td>
                    <td class="deposit">+ RM 500.00</td>
                </tr>

                <tr>
                    <td>30/09/2026</td>
                    <td>Online Shopping</td>
                    <td class="withdraw">- RM 120.00</td>
                </tr>

                <tr>
                    <td>28/09/2026</td>
                    <td>Deposit</td>
                    <td class="deposit">+ RM 1,000.00</td>
                </tr>

            </table>

        </div>

    </div>

</body>

</html>
