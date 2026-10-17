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

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$userId = (int)$_SESSION["user_id"];

if (empty($_SESSION["csrf_token"])) {
    $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
}

// Show the message from the last transfer (then remove it)
$message = $_SESSION["transfer_message"] ?? "";
$message_type = $_SESSION["transfer_message_type"] ?? "success";

unset($_SESSION["transfer_message"], $_SESSION["transfer_message_type"]);

// Save the message and go back to transfer.php
// (this stops the transfer from being sent twice when the page is refreshed)
function redirectTransfer($message, $type = "success") {
    $_SESSION["transfer_message"] = $message;
    $_SESSION["transfer_message_type"] = $type;
    header("Location: transfer.php");
    exit();
}

// Add one row to the user_transactions table
function addTransaction($conn, $userId, $type, $description, $amount, $status) {
    $stmt = mysqli_prepare(
        $conn,
        "INSERT INTO user_transactions (user_id, type, description, amount, status)
         VALUES (?, ?, ?, CAST(? AS DECIMAL(14,2)), ?)"
    );
    mysqli_stmt_bind_param($stmt, "issss", $userId, $type, $description, $amount, $status);
    mysqli_stmt_execute($stmt);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $token = $_POST["csrf_token"] ?? "";

    if (!hash_equals($_SESSION["csrf_token"], $token)) {
        redirectTransfer("Invalid request. Please try again.", "error");
    }

    $recipient = trim($_POST["recipient"] ?? "");
    $account_number = trim($_POST["account_number"] ?? "");
    $amountInput = trim($_POST["amount"] ?? "");
    $reference = trim($_POST["reference"] ?? "");

    if ($recipient === "" || $account_number === "" || $amountInput === "") {
        redirectTransfer("Please complete all required fields.", "error");
    }

    if (!preg_match('/^\d+(\.\d{1,2})?$/', $amountInput) || (float)$amountInput <= 0) {
        redirectTransfer("Please enter a valid amount (maximum 2 decimal places).", "error");
    }

    if (mb_strlen($reference, "UTF-8") > 100) {
        redirectTransfer("Reference is too long (maximum 100 characters).", "error");
    }

    $amount = number_format((float)$amountInput, 2, ".", "");

    // Find the recipient in the customers table
    $stmt = mysqli_prepare(
        $conn,
        "SELECT id, user_id, name, status FROM customers WHERE account_number = ?"
    );
    mysqli_stmt_bind_param($stmt, "s", $account_number);
    mysqli_stmt_execute($stmt);
    $customer = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

    if (!$customer || strcasecmp($customer["name"], $recipient) !== 0) {
        redirectTransfer("Recipient not found. Please check the name and account number.", "error");
    }

    if ($customer["user_id"] !== null && (int)$customer["user_id"] === $userId) {
        redirectTransfer("You cannot transfer money to yourself.", "error");
    }

    $description = "Transfer to " . $customer["name"];

    if ($reference !== "") {
        $description .= " (" . $reference . ")";
    }

    $description = mb_substr($description, 0, 150, "UTF-8");

    $outcomeType = "error";
    $outcomeMessage = "Transfer failed. Please try again.";

    try {

        mysqli_begin_transaction($conn);

        // Take the money from the sender, only if the balance is enough
        $debit = mysqli_prepare(
            $conn,
            "UPDATE users
             SET balance = balance - CAST(? AS DECIMAL(14,2))
             WHERE id = ? AND balance >= CAST(? AS DECIMAL(14,2))"
        );
        mysqli_stmt_bind_param($debit, "sis", $amount, $userId, $amount);
        mysqli_stmt_execute($debit);

        if (mysqli_stmt_affected_rows($debit) !== 1) {

            // Not enough balance: nothing was changed, so save a Failed transaction
            mysqli_rollback($conn);

            addTransaction($conn, $userId, "Transfer", $description, $amount, "Failed");

            $outcomeMessage = "Insufficient balance. The transfer failed.";

        } else {

            // Give the money to the recipient if the recipient has a login account
            if ($customer["user_id"] !== null) {

                $recipientUserId = (int)$customer["user_id"];

                $credit = mysqli_prepare(
                    $conn,
                    "UPDATE users
                     SET balance = balance + CAST(? AS DECIMAL(14,2))
                     WHERE id = ?"
                );
                mysqli_stmt_bind_param($credit, "si", $amount, $recipientUserId);
                mysqli_stmt_execute($credit);

                addTransaction(
                    $conn,
                    $recipientUserId,
                    "Received",
                    "Received From " . $_SESSION["name"],
                    $amount,
                    "Successful"
                );
            }

            addTransaction($conn, $userId, "Transfer", $description, $amount, "Successful");

            mysqli_commit($conn);

            $outcomeType = "success";
            $outcomeMessage = "Transfer of RM " . number_format((float)$amount, 2)
                . " to " . $customer["name"] . " was successful.";
        }

    } catch (Throwable $e) {

        mysqli_rollback($conn);
    }

    redirectTransfer($outcomeMessage, $outcomeType);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transfer - Bank System</title>
<style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #f4f6f9;
            color: #1e293b;
        }

        

        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 220px;
            height: 100vh;
            background-color: #1e293b;
            color: white;
            padding: 20px;
        }

        .sidebar h2 {
            margin-bottom: 30px;
            text-align: center;
        }

        .sidebar ul {
            list-style: none;
        }

        .sidebar ul li {
            margin: 15px 0;
        }

        .sidebar ul li a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 12px;
            border-radius: 6px;
        }

        .sidebar ul li a:hover {
            background-color: #334155;
        }


        .main {
            margin-left: 220px;
            min-height: 100vh;
            padding: 35px;
        }

        
        .header {
            background-color: white;
            padding: 25px 30px;
            border-radius: 12px;
            margin-bottom: 25px;
        }

        .header h1 {
            margin-bottom: 8px;
            color: #1e293b;
        }

        .header p {
            color: #64748b;
        }

        
        .transfer-wrapper {
            width: 100%;
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        

        .transfer-title {
            padding: 30px 35px;
            border-bottom: 1px solid #e2e8f0;
        }

        .transfer-title h2 {
            font-size: 24px;
            margin-bottom: 7px;
        }

        .transfer-title p {
            color: #64748b;
        }

        /* ================= CONTENT ================= */

        .transfer-content {
            display: grid;
            grid-template-columns: 2fr 1fr;
            min-height: 500px;
        }

        /* ================= FORM ================= */

        .form-section {
            padding: 35px;
            border-right: 1px solid #e2e8f0;
        }

        .form-section h3 {
            margin-bottom: 25px;
            font-size: 20px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .form-group {
            margin-bottom: 22px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: bold;
            color: #475569;
            margin-bottom: 8px;
        }

        .form-group input {
            width: 100%;
            padding: 14px 15px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            font-size: 15px;
            color: #1e293b;
            background-color: #fff;
        }

        .form-group input:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.10);
        }

        

        .amount-box {
            position: relative;
        }

        .amount-box span {
            position: absolute;
            left: 15px;
            top: 14px;
            color: #64748b;
            font-weight: bold;
        }

        .amount-box input {
            padding-left: 48px;
        }

   

        .transfer-button {
            width: 100%;
            padding: 15px;
            background-color: #2563eb;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 5px;
        }

        .transfer-button:hover {
            background-color: #1d4ed8;
        }


        .info-section {
            background-color: #f8fafc;
            padding: 35px;
        }

        .info-section h3 {
            margin-bottom: 25px;
            font-size: 20px;
        }

        .info-box {
            background-color: white;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 15px;
        }

        .info-box .icon {
            width: 42px;
            height: 42px;
            background-color: #dbeafe;
            color: #2563eb;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-bottom: 12px;
        }

        .info-box h4 {
            margin-bottom: 6px;
        }

        .info-box p {
            color: #64748b;
            font-size: 14px;
            line-height: 1.5;
        }

      

        .message-area {
            padding: 0 35px;
        }

        .message {
            padding: 14px 16px;
            border-radius: 8px;
            margin-top: 25px;
        }

        .success {
            background-color: #dcfce7;
            border: 1px solid #bbf7d0;
            color: #166534;
        }

        .error {
            background-color: #fee2e2;
            border: 1px solid #fecaca;
            color: #991b1b;
        }

    </style>

</head>

<body>



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


  

    <div class="main">


     

        <div class="header">

            <h1>Transfer</h1>

            <p>
                Send money securely to another account.
            </p>

        </div>



        <div class="transfer-wrapper">


            

            <div class="transfer-title">

                <h2>Make a Transfer</h2>

                <p>
                    Enter the recipient details and amount below.
                </p>

            </div>


            <?php if ($message !== ""): ?>

                <div class="message-area">

                    <div class="message <?= $message_type ?>">

                        <?= htmlspecialchars($message) ?>

                    </div>

                </div>

            <?php endif; ?>



            <div class="transfer-content">


                <div class="form-section">

                    <h3>Transfer Details</h3>

                    <form method="POST" action="transfer.php">

                        <input type="hidden" name="csrf_token"
                               value="<?= htmlspecialchars($_SESSION["csrf_token"], ENT_QUOTES, "UTF-8") ?>">


                        <div class="form-row">


                            <div class="form-group">

                                <label for="recipient">
                                    Recipient Name
                                </label>

                                <input
                                    type="text"
                                    id="recipient"
                                    name="recipient"
                                    placeholder="Enter recipient name"
                                    required
                                >

                            </div>


                            <div class="form-group">

                                <label for="account_number">
                                    Account Number
                                </label>

                                <input
                                    type="text"
                                    id="account_number"
                                    name="account_number"
                                    placeholder="Enter account number"
                                    required
                                >

                            </div>


                        </div>


                        <div class="form-row">


                            <div class="form-group">

                                <label for="amount">
                                    Transfer Amount
                                </label>

                                <div class="amount-box">

                                    <span>RM</span>

                                    <input
                                        type="number"
                                        id="amount"
                                        name="amount"
                                        placeholder="0.00"
                                        min="0.01"
                                        step="0.01"
                                        required
                                    >

                                </div>

                            </div>


                            <div class="form-group">

                                <label for="reference">
                                    Reference
                                </label>

                                <input
                                    type="text"
                                    id="reference"
                                    name="reference"
                                    placeholder="Payment reference"
                                >

                            </div>


                        </div>


                        <button
                            type="submit"
                            class="transfer-button">

                            Transfer Money

                        </button>


                    </form>

                </div>


             

                <div class="info-section">

                    <h3>Transfer Guide</h3>


                    <div class="info-box">

                        <div class="icon">
                            01
                        </div>

                        <h4>Recipient</h4>

                        <p>
                            Enter the recipient's name and
                            account number carefully.
                        </p>

                    </div>


                    <div class="info-box">

                        <div class="icon">
                            02
                        </div>

                        <h4>Amount</h4>

                        <p>
                            Enter the amount you want to
                            transfer in Malaysian Ringgit.
                        </p>

                    </div>


                    <div class="info-box">

                        <div class="icon">
                            03
                        </div>

                        <h4>Check Details</h4>

                        <p>
                            Make sure all information is correct
                            before submitting the transfer.
                        </p>

                    </div>

                </div>


            </div>

        </div>

    </div>


</body>

</html>