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
                <p class="balance">RM 967,489,334.00</p>

            </div>

            <div class="card">

                <h3>Account Number</h3>
                <p class="number">1234567890</p>

            </div>

            <div class="card">

                <h3>Account Status</h3>
                <p style="color: #16a34a ; font-size:25px; font-weight: bold;">•    Active</p>

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

                    <tr>
                        <td>05 Oct 2026</td>
                        <td class="transfer">Transfer</td>
                        <td>Transfer to Daniel</td>
                        <td class="amount">- RM 5,000.00</td>
                        <td class="success">Successful</td>
                    </tr>

                    <tr>
                        <td>03 Oct 2026</td>
                        <td class="transfer">Transfer</td>
                        <td>Transfer to Marcus</td>
                        <td class="amount">- RM 25,000.00</td>
                        <td class="success">Successful</td>
                    </tr>

                    <tr>
                        <td>01 Oct 2026</td>
                        <td class="received">Received</td>
                        <td>Received From Mohamad Ahmad</td>
                        <td class="amount">+ RM 20,000.00</td>
                        <td class="success">Successful</td>
                    </tr>

                    <tr>
                        <td>27 Sep 2026</td>
                        <td class="received">Received</td>
                        <td>Received From JX Supplies Sdn. Bhd.</td>
                        <td class="amount">+ RM 250,600.00</td>
                        <td class="success">Successful</td>
                    </tr>

                    <tr>
                        <td>20 Sep 2026</td>
                        <td class="transfer">Transfer</td>
                        <td>Transfer to Wilfred</td>
                        <td class="amount">- RM 7,500.00</td>
                        <td class="success">Successful</td>
                    </tr>

                    <tr>
                        <td>20 Sep 2026</td>
                        <td class="transfer">Transfer</td>
                        <td>Transfer to Car Sales Sdn. Bhd.</td>
                        <td class="amount">- RM 20,000.00</td>
                        <td class="success">Successful</td>
                    </tr>

                    <tr>
                        <td>20 Sep 2026</td>
                        <td class="received">Received</td>
                        <td>Received From JX Supplies Sdn. Bhd.</td>
                        <td class="amount">- RM 200,000.00</td>
                        <td class="success">Successful</td>
                    </tr>

                    


                </tbody>

            </table>

        </div>


    </div>


</body>

</html>
