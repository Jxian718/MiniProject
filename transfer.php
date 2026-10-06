<?php

session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$message = "";
$message_type = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $recipient = trim($_POST["recipient"] ?? "");
    $account_number = trim($_POST["account_number"] ?? "");
    $amount = trim($_POST["amount"] ?? "");
    $reference = trim($_POST["reference"] ?? "");

    if ($recipient === "" || $account_number === "" || $amount === "") {

        $message = "Please complete all required fields.";
        $message_type = "error";

    } elseif (!is_numeric($amount) || $amount <= 0) {

        $message = "Please enter a valid amount.";
        $message_type = "error";

    } else {

        $message = "Transfer submitted successfully.";
        $message_type = "success";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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

        /* ================= SIDEBAR ================= */

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

        /* ================= MAIN ================= */

        .main {
            margin-left: 220px;
            min-height: 100vh;
            padding: 35px;
        }

        /* ================= HEADER ================= */

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

        /* ================= TRANSFER AREA ================= */

        .transfer-wrapper {
            width: 100%;
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        /* ================= TOP TITLE ================= */

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

        /* ================= AMOUNT ================= */

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

        /* ================= BUTTON ================= */

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

        /* ================= INFORMATION PANEL ================= */

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

        /* ================= MESSAGE ================= */

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

        /* ================= RESPONSIVE ================= */

        @media (max-width: 900px) {

            .transfer-content {
                grid-template-columns: 1fr;
            }

            .form-section {
                border-right: none;
                border-bottom: 1px solid #e2e8f0;
            }

        }

        @media (max-width: 700px) {

            .sidebar {
                width: 180px;
            }

            .main {
                margin-left: 180px;
                padding: 20px;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .transfer-title,
            .form-section,
            .info-section {
                padding: 25px;
            }

            .message-area {
                padding: 0 25px;
            }

        }

    </style>

</head>

<body>


    <!-- SIDEBAR -->

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


    <!-- MAIN -->

    <div class="main">


        <!-- HEADER -->

        <div class="header">

            <h1>Transfer</h1>

            <p>
                Send money securely to another account.
            </p>

        </div>


        <!-- FULL WIDTH TRANSFER -->

        <div class="transfer-wrapper">


            <!-- TITLE -->

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


            <!-- CONTENT -->

            <div class="transfer-content">


                <!-- FORM -->

                <div class="form-section">

                    <h3>Transfer Details</h3>

                    <form method="POST" action="transfer.php">


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


                <!-- INFORMATION -->

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
