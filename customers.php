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

    <title>Customers - Bank System</title>

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

        .page-header 
        {
            margin-bottom: 25px;
        }

        .page-header h1 
        {
            font-size: 27px;
            margin-bottom: 7px;
        }

        .page-header p 
        {
            color: #64748b;
            font-size: 15px;
        }

        .customer-box 
        {
            background-color: white;
            border: 1px solid #e2e8f0;
            border-radius: 9px;
            padding: 25px;
            box-shadow: 0 2px 7px rgba(0, 0, 0, 0.05);
        }

        .customer-top 
        {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .customer-top h2 
        {
            font-size: 21px;
        }

        .search-box 
        {
            display: flex;
            gap: 10px;
        }

        .search-box input 
        {
            width: 250px;
            padding: 10px 12px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            font-size: 14px;
            outline: none;
        }

        .search-box input:focus 
        {
            border-color: #2563eb;
        }

        .search-box button 
        {
            padding: 10px 18px;
            border: none;
            background-color: #2563eb;
            color: white;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
        }

        .search-box button:hover 
        {
            background-color: #1d4ed8;
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
            padding: 6px 12px;
            border-radius: 15px;
            font-size: 13px;
            font-weight: bold;
        }

        .active 
        {
            background-color: #dcfce7;
            color: #15803d;
        }

        .inactive 
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
            <a href="transactions.php">Transactions</a>
            <a href="logout.php" class="logout">Logout</a>

        </div>

    </nav>


    <div class="container">

        <div class="page-header">

            <h1>Customers</h1>
            <p>View customer information and account status.</p>

        </div>


        <div class="customer-box">

            <div class="customer-top">

                <h2>Customer List</h2>


                <div class="search-box">

                    <input
                        type="text"placeholder="Search customer...">

                    <button>
                        Search
                    </button>

                </div>

            </div>

            <table>

                <thead>

                    <tr>
                        <th>Customer ID</th>
                        <th>Name</th>
                        <th>Account Number</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Status</th>
                    </tr>

                </thead>


                <tbody>

                    <tr>
                        <td>C001</td>
                        <td>Jinxian</td>
                        <td>1234567890</td>
                        <td>jxian0718@gmail.com</td>
                        <td>010-7915138</td>
                        <td><span class="status active">Active</span></td>
                    </tr>

                    <tr>
                        <td>C002</td>
                        <td>Marcus Ng</td>
                        <td>3035297750</td>
                        <td>marcus@gmail.com</td>
                        <td>012-3975321</td>
                        <td><span class="status inactive">Inactive</span></td>
                    </tr>

                    <tr>
                        <td>C003</td>
                        <td>Daniel Tham</td>
                        <td>2024303952</td>
                        <td>daniel@gmail.com</td>
                        <td>012-3456789</td>
                        <td><span class="status inactive">Inactive</span></td>
                    </tr>

                     <tr>
                        <td>C004</td>
                        <td>Wilfred</td>
                        <td>3321509870</td>
                        <td>wilfred@gmail.com</td>
                        <td>010-7915138</td>
                        <td><span class="status active">Active</span></td>
                    </tr>

                    <tr>
                        <td>C005</td>
                        <td>Joan Lim</td>
                        <td>6677232490</td>
                        <td>joanlim@gmail.com</td>
                        <td>014-7934223</td>
                        <td><span class="status active">Active</span></td>
                    </tr>

                    <tr>
                        <td>C006</td>
                        <td>Julina</td>
                        <td>3234562190</td>
                        <td>julina@gmail.com</td>
                        <td>012-9036772</td>
                        <td><span class="status inactive">Inactive</span></td>
                    </tr>

                    <tr>
                        <td>C007</td>
                        <td>Bryan </td>
                        <td>2246334560</td>
                        <td>bryan@gmail.com</td>
                        <td>019-9435332</td>
                        <td><span class="status active">Active</span></td>
                    </tr>

                    <tr>
                        <td>C008</td>
                        <td>Queenie </td>
                        <td>1226334780</td>
                        <td>queenie@gmail.com</td>
                        <td>012-3734550</td>
                        <td><span class="status active">Active</span></td>
                    </tr>

                    <tr>
                        <td>C009</td>
                        <td>Christine </td>
                        <td>9006727346</td>
                        <td>christine@gmail.com</td>
                        <td>016-6245033</td>
                        <td><span class="status inactive">Inactive</span></td>
                    </tr>

                </tbody>

            </table>


        </div>

    </div>


</body>

</html>