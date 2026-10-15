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

    <title>Staff Dashboard - Bank System</title>

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
            background-color: #f5f7fb;
            color: #1e293b;
        }

        .navbar 
        {
            height: 65px;
            background-color: #1e3a8a;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 45px;
            color: white;
        }

        .logo 
        {
            font-size: 21px;
            font-weight: bold;
        }

        .nav-links 
        {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .nav-links a 
        {
            color: white;
            text-decoration: none;
            font-size: 15px;
            padding: 8px 12px;
            border-radius: 5px;
        }

        .nav-links a:hover 
        {
            background-color: #2563eb;
        }

        .logout 
        {
            background-color: #dc2626;
        }

        .logout:hover 
        {
            background-color: #b91c1c !important;
        }

        .container 
        {
            max-width: 1250px;
            margin: auto;
            padding: 35px 45px;
        }

        .welcome 
        {
            margin-bottom: 25px;
        }

        .welcome h1 
        {
            font-size: 27px;
            margin-bottom: 7px;
        }

        .welcome p 
        {
            color: #64748b;
            font-size: 15px;
        }

        .cards 
        {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 18px;
            margin-bottom: 25px;
        }

        .card 
        {
            background-color: white;
            padding: 22px;
            min-height: 120px;
            border-radius: 9px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 2px 7px rgba(0, 0, 0, 0.05);
        }

        .card h3 
        {
            color: #64748b;
            font-size: 14px;
            margin-bottom: 12px;
        }

        .number 
        {
            font-size: 28px;
            font-weight: bold;
        }

        .total 
        {
            color: #2563eb;
        }

        .success 
        {
            color: #16a34a;
        }

        .failed 
        {
            color: #dc2626;
        }

        .transaction-box 
        {
            background-color: white;
            border: 1px solid #e2e8f0;
            border-radius: 9px;
            padding: 25px;
            box-shadow: 0 2px 7px rgba(0, 0, 0, 0.05);
        }

        .transaction-header 
        {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .transaction-header h2 
        {
            font-size: 21px;
        }

        .view-all 
        {
            color: #2563eb;
            text-decoration: none;
            font-size: 14px;
        }

        .view-all:hover 
        {
            text-decoration: underline;
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
            font-size: 14px;
            text-align: left;
            padding: 15px;
        }

        td 
        {
            padding: 17px 15px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 15px;
            color: #475569;
        }

        tr:last-child td 
        {
            border-bottom: none;
        }

        tr:hover 
        {
            background-color: #f8fafc;
        }

        .status 
        {
            display: inline-block;
            padding: 6px 11px;
            border-radius: 15px;
            font-size: 13px;
            font-weight: bold;
        }

        .status-success 
        {
            background-color: #dcfce7;
            color: #15803d;
        }

        .status-failed 
        {
            background-color: #fee2e2;
            color: #b91c1c;
        }

    </style>

</head>


<body>

    <nav class="navbar">

        <div class="logo">
             Bank System
        </div>


        <div class="nav-links">

            <a href="staff.php">Dashboard</a>
            <a href="customers.php">Customers</a>
            <a href="logout.php" class="logout">Logout</a>

        </div>

    </nav>

    <div class="container">

        <div class="welcome">

            <h1>Staff Dashboard</h1>
            <p>Welcome,<?php echo htmlspecialchars($_SESSION["name"]); ?>!</p>

        </div>


        <div class="cards">

            <div class="card">

                <h3>TOTAL TRANSACTIONS</h3>
                <p class="number total">150</p>

            </div>


            <div class="card">

                <h3>SUCCESSFUL</h3>
                <p class="number success">135</p>

            </div>


            <div class="card">

                <h3>FAILED</h3>
                <p class="number failed">15</p>

            </div>
        </div>


        <div class="transaction-box">

            <div class="transaction-header">

                <h2>Recent Transactions</h2>
                <p class="view-all">View All</p>

            </div>


            <table>
                <thead>

                    <tr>
                        <th>ID</th>
                        <th>Date</th>
                        <th>Customer</th>
                        <th>Amount</th>
                        <th>Status</th>
                    </tr>

                </thead>


                <tbody>

                    <tr>
                        <td> #1001</td>
                        <td>08 Oct 2026</td>
                        <td>Daniel</td>
                        <td>RM 5,000.00</td>
                        <td><span class="status status-success">Successful</span></td>
                    </tr>

                    <tr>
                        <td> #1002</td>
                        <td>08 Oct 2026</td>
                        <td>Marcus</td>
                        <td>RM 2,500.00</td>
                        <td><span class="status status-success">Successful</span></td>
                    </tr>

                    <tr>
                        <td> #1003</td>
                        <td>08 Oct 2026</td>
                        <td>Wilfred</td>
                        <td>RM 8,000.00</td>
                        <td><span class="status status-failed">Failed</span></td>
                    </tr>

                    <tr>
                        <td> #1004</td>
                        <td>07 Oct 2026</td>
                        <td>Daniel</td>
                        <td>RM 1,200.00</td>
                        <td><span class="status status-success">Successful</span></td>
                    </tr>

                    <tr>
                        <td> #1005</td>
                        <td>07 Oct 2026</td>
                        <td>Joan</td>
                        <td>RM 3,500.00</td>
                        <td><span class="status status-success">Successful</span></td>
                    </tr>

                    <tr>
                        <td> #1005</td>
                        <td>07 Oct 2026</td>
                        <td>Joan</td>
                        <td>RM 3,500.00</td>
                        <td><span class="status status-success">Successful</span></td>
                    </tr>

                    <tr>
                        <td> #1005</td>
                        <td>07 Oct 2026</td>
                        <td>Bryan</td>
                        <td>RM 3,500.00</td>
                        <td><span class="status status-failed">Failed</span></td>
                    </tr>

                </tbody>

            </table>


        </div>


    </div>


</body>

</html>