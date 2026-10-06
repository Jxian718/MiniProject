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

    <title>Transactions - Bank System</title>

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

        /* ================= TRANSACTION ================= */

        .transaction-wrapper {
            width: 100%;
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .transaction-title {
            padding: 30px 35px;
            border-bottom: 1px solid #e2e8f0;
        }

        .transaction-title h2 {
            font-size: 24px;
            margin-bottom: 7px;
        }

        .transaction-title p {
            color: #64748b;
        }

        /* ================= TABLE ================= */

        .table-area {
            padding: 35px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background-color: #f8fafc;
            color: #475569;
            text-align: left;
            padding: 16px;
            font-size: 14px;
            border-bottom: 2px solid #e2e8f0;
        }

        td {
            padding: 18px 16px;
            border-bottom: 1px solid #e2e8f0;
            color: #475569;
        }

        tr:hover {
            background-color: #f8fafc;
        }

        /* ================= STATUS ================= */

        .success {
            color: #16a34a;
            font-weight: bold;
        }

        .failed {
            color: #dc2626;
            font-weight: bold;
        }

        /* ================= AMOUNT ================= */

        .amount {
            font-weight: bold;
            color: #1e293b;
        }

        .transfer {
            color: #2563eb;
            font-weight: bold;
        }

        /* ================= RESPONSIVE ================= */

        @media (max-width: 800px) {

            .sidebar {
                width: 180px;
            }

            .main {
                margin-left: 180px;
                padding: 20px;
            }

            .table-area {
                overflow-x: auto;
            }

            table {
                min-width: 700px;
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

            <h1>Transactions</h1>

            <p>
                View your recent transaction history.
            </p>

        </div>


        <!-- TRANSACTION AREA -->

        <div class="transaction-wrapper">


            <!-- TITLE -->

            <div class="transaction-title">

                <h2>Transaction History</h2>

                <p>
                    Here you can view your previous transactions.
                </p>

            </div>


            <!-- TABLE -->

            <div class="table-area">

                <table>

                    <thead>

                        <tr>

                            <th>
                                Date
                            </th>

                            <th>
                                Transaction
                            </th>

                            <th>
                                Description
                            </th>

                            <th>
                                Amount
                            </th>

                            <th>
                                Status
                            </th>

                        </tr>

                    </thead>


                    <tbody>


                        <!-- Example Transaction 1 -->

                        <tr>

                            <td>
                                05 Oct 2026
                            </td>

                            <td class="transfer">
                                Transfer
                            </td>

                            <td>
                                Transfer to Daniel
                            </td>

                            <td class="amount">
                                RM 100.00
                            </td>

                            <td class="success">
                                Successful
                            </td>

                        </tr>


                        <!-- Example Transaction 2 -->

                        <tr>

                            <td>
                                03 Oct 2026
                            </td>

                            <td class="transfer">
                                Transfer
                            </td>

                            <td>
                                Transfer to Marcus
                            </td>

                            <td class="amount">
                                RM 200.00
                            </td>

                            <td class="success">
                                Successful
                            </td>

                        </tr>


                        <!-- Example Transaction 3 -->

                        <tr>

                            <td>
                                01 Oct 2026
                            </td>

                            <td class="transfer">
                                Transfer
                            </td>

                            <td>
                                Transfer to Jinxian
                            </td>

                            <td class="amount">
                                RM 50.00
                            </td>

                            <td class="success">
                                Successful
                            </td>

                        </tr>


                    </tbody>

                </table>

            </div>


        </div>

    </div>


</body>

</html>
