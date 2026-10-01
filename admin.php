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
    <h2>Welcome, <?php echo htmlspecialchars($_SESSION["name"]); ?>!</h2>

    <?php if ($account): ?>
        <p>Account No: <?php echo htmlspecialchars($account["account_no"]); ?></p>
        <p>Balance: RM <?php echo number_format($account["balance"], 2); ?></p>

        <h3>Recent Transactions</h3>
        <table border="1" cellpadding="6">
            <tr><th>Date</th><th>Type</th><th>Amount (RM)</th></tr>
            <?php foreach ($transactions as $t): ?>
                <tr>
                    <td><?php echo htmlspecialchars($t["created_at"]); ?></td>
                    <td><?php echo htmlspecialchars($t["type"]); ?></td>
                    <td><?php echo number_format($t["amount"], 2); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>No account found.</p>
    <?php endif; ?>

    <hr>
    <a href="logout.php">Logout</a>
</body>

</html>
