<?php

session_start();
require_once "database.php";

// Only logged-in users with the right role can open this page
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$homePages = ["user" => "user.php", "staff" => "staff.php", "admin" => "admin.php"];

if (!in_array($_SESSION["role"] ?? "", ["user"], true)) {
    header("Location: " . ($homePages[$_SESSION["role"] ?? ""] ?? "login.php"));
    exit();
}

$userId = (int)$_SESSION["user_id"];

// All transactions of this user from user_transactions
$stmt = mysqli_prepare(
    $conn,
    "SELECT type, description, amount, status, created_at
     FROM user_transactions
     WHERE user_id = ?
     ORDER BY created_at DESC, id DESC"
);
mysqli_stmt_bind_param($stmt, "i", $userId);
mysqli_stmt_execute($stmt);
$transactions = mysqli_fetch_all(mysqli_stmt_get_result($stmt), MYSQLI_ASSOC);

// Help prevent XSS attacks and make output safer
function h($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, "UTF-8");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transactions - Bank System</title>
<style>

        * 
        {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body 
        {
            background-color: #f4f6f9;
            color: #1e293b;
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
            padding: 25px 30px;
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

        .transaction-wrapper 
        {
            width: 100%;
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .transaction-title 
        {
            padding: 30px 35px;
            border-bottom: 1px solid #e2e8f0;
        }

        .transaction-title h2 
        {
            font-size: 24px;
            margin-bottom: 7px;
        }

        .transaction-title p 
        {
            color: #64748b;
        }

        .table-area {
            padding: 35px;
        }

        table 
        {
            width: 100%;
            border-collapse: collapse;
        }

        th 
        {
            background-color: #f8fafc;
            color: #475569;
            text-align: left;
            padding: 16px;
            font-size: 14px;
            border-bottom: 2px solid #e2e8f0;
        }

        td 
        {
            padding: 18px 16px;
            border-bottom: 1px solid #e2e8f0;
            color: #475569;
        }

        tr:hover 
        {
            background-color: #f8fafc;
        }

        .success 
        {
            color:  #2563eb;
            font-weight: bold;
        }

        .failed 
        {
            color: red;
            font-weight: bold;
        }

        .amount 
        {
            font-weight: bold;
            color: #1e293b;
        }

        .transfer {
            color: #fd0000;
            font-weight: bold;
        }

        .received
        {
            color: #16a34a;
            font-weight: bold;
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
            <h1>Transactions</h1>
            <p>View your recent transaction history.</p>
        </div>


        <div class="transaction-wrapper">
            <div class="transaction-title">
                <h2>Transaction History</h2>
                <p>Here you can view your previous transactions.</p>
            </div>


        <div class="table-area">
            <table>
              <thead>
                    <tr>
                        <th>Date</th>
                        <th>Transaction</th>
                        <th>Description</th>
                        <th>Amount</th>
                        <th>Status</th>
                    </tr>
              </thead>


                    <tbody>

                        <?php if (empty($transactions)): ?>

                            <tr>
                                <td colspan="5">No transactions yet.</td>
                            </tr>

                        <?php else: ?>

                            <?php foreach ($transactions as $t): ?>

                            <tr>
                                <td><?= h(date("d M Y", strtotime($t["created_at"]))) ?></td>
                                <td class="<?= $t["type"] === "Transfer" ? "transfer" : "received" ?>"><?= h($t["type"]) ?></td>
                                <td><?= h($t["description"]) ?></td>
                                <td class="amount">RM <?= number_format((float)$t["amount"], 2) ?></td>
                                <td class="<?= $t["status"] === "Successful" ? "success" : "failed" ?>"><?= h($t["status"]) ?></td>
                            </tr>

                            <?php endforeach; ?>

                        <?php endif; ?>

                    </tbody>

             </table>
        </div>
        </div>

    </div>


</body>

</html>