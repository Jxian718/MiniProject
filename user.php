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

// Balance from users, account number and status from customers
$stmt = mysqli_prepare(
    $conn,
    "SELECT u.balance, c.account_number, c.status
     FROM users u
     LEFT JOIN customers c ON c.user_id = u.id
     WHERE u.id = ?"
);
mysqli_stmt_bind_param($stmt, "i", $userId);
mysqli_stmt_execute($stmt);
$account = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if (!$account) {
    header("Location: logout.php");
    exit();
}

$balance = (float)$account["balance"];
$accountNumber = $account["account_number"] ?? "Not assigned";
$accountStatus = $account["status"] ?? "Not assigned";

// Latest 7 transactions of this user from user_transactions
$stmt = mysqli_prepare(
    $conn,
    "SELECT type, description, amount, status, created_at
     FROM user_transactions
     WHERE user_id = ?
     ORDER BY created_at DESC, id DESC
     LIMIT 7"
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

    <title>User Page - Bank System</title>

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
            padding: 30px;
            min-height: 100vh;
        }

        .header 
        {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 25px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .header h1 
        {
            margin-bottom: 10px;
        }

        .header p 
        {
            color: #64748b;
        }

        .cards 
        {
            display: flex;
            gap: 20px;
            margin-bottom: 25px;
        }

        .card 
        {
            background-color: white;
            padding: 25px;
            border-radius: 10px;
            flex: 1;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .number
        {
            font-size: 25px;
            color: black;
            font-weight: bold;
        }

        .card h3 
        {
            color: #64748b;
            margin-bottom: 10px;
            font-size: 16px;
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
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            font-size:50px;
            min-height: 600px;
        }

        .transactions h2
        {
            margin-bottom: 25px;
            font-size: 22px;
            color: #1e293b;
            font-size:25px;
        }

        table
        {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        table th,table td 
        {
            padding: 25px 15px;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
            
        }

        table th 
        {
            background-color: #f8fafc;
            color: #475569;
            font-size: 14px;
            font-weight: bold;
        }

        table td 
        {
            color: #475569;
            font-size: 17px;
        }

        table tr:hover 
        {
            background-color: #f8fafc;
        }

        table tr:last-child td 
        {
            border-bottom: none;
        }

        table th:nth-child(1),table td:nth-child(1) 
        {
            width: 16%;
        }

        table th:nth-child(2),table td:nth-child(2) 
        {
            width: 15%;
        }

        table th:nth-child(3),table td:nth-child(3) 
        {
            width: 32%;
        }

        table th:nth-child(4),table td:nth-child(4) 
        {
            width: 22%;
        }

        table th:nth-child(5),table td:nth-child(5) 
        {
            width: 15%;
        }

        .transfer 
        {
            color: #dc2626;
            font-weight: bold;
        }

        .received 
        {
            color: #16a34a;
            font-weight: bold;
        }

        .amount
        {
            font-weight: bold;
            color: #334155;
        }

        .success 
        {
            color:  #2563eb;
            font-weight: bold;
        }
        .failed
        {
            color: #dc2626;
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
            <h1>Welcome,<?php echo htmlspecialchars($_SESSION["name"]); ?>!</h1>
            <p>You are logged in as a user. </p>
        </div>


        <div class="cards">
            <div class="card">

                <h3>Account Balance</h3>
                <p class="balance">RM <?= number_format($balance, 2) ?></p>

            </div>

            <div class="card">

                <h3>Account Number</h3>
                <p class="number"><?= h($accountNumber) ?></p>

            </div>

            <div class="card">

                <h3>Account Status</h3>
                <p style="color: <?= $accountStatus === "Active" ? "#16a34a" : "#dc2626" ?>; font-size:25px; font-weight: bold;">• <?= h($accountStatus) ?></p>

            </div>

        </div>

        <div class="transactions">

            <h2>Recent Transactions</h2>

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
                        <td class="amount"><?= $t["type"] === "Transfer" ? "-" : "+" ?> RM <?= number_format((float)$t["amount"], 2) ?></td>
                        <td class="<?= $t["status"] === "Successful" ? "success" : "failed" ?>"><?= h($t["status"]) ?></td>
                    </tr>

                    <?php endforeach; ?>

                <?php endif; ?>

                </tbody>

            </table>

        </div>


    </div>


</body>

</html>