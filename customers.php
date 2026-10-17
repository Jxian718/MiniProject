<?php

session_start();
require_once "database.php";

// Only logged-in users with the right role can open this page
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$homePages = ["user" => "user.php", "staff" => "staff.php", "admin" => "admin.php"];

if (!in_array($_SESSION["role"] ?? "", ["staff", "admin"], true)) {
    header("Location: " . ($homePages[$_SESSION["role"] ?? ""] ?? "login.php"));
    exit();
}

// Search (optional): ?search=...
$search = trim($_GET["search"] ?? "");

if ($search !== "") {

    $like = "%" . $search . "%";

    $stmt = mysqli_prepare(
        $conn,
        "SELECT id, name, account_number, email, phone, status
         FROM customers
         WHERE name LIKE ? OR account_number LIKE ? OR email LIKE ?
         ORDER BY id"
    );
    mysqli_stmt_bind_param($stmt, "sss", $like, $like, $like);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

} else {

    $result = mysqli_query(
        $conn,
        "SELECT id, name, account_number, email, phone, status
         FROM customers
         ORDER BY id"
    );
}

$customers = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Dashboard link depends on the role
$dashboardLink = ($_SESSION["role"] === "admin") ? "admin.php" : "staff.php";

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

            <a href="<?= h($dashboardLink) ?>">Dashboard</a>
            <?php if ($_SESSION["role"] === "admin"): ?>
            <a href="manage.php">Manage Staff</a>
            <?php endif; ?>
            <a href="customers.php">Customers</a>
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


                <form method="GET" action="customers.php" class="search-box">

                    <input
                        type="text"
                        name="search"
                        placeholder="Search customer..."
                        value="<?= h($search) ?>">

                    <button type="submit">
                        Search
                    </button>

                </form>

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

                <?php if (empty($customers)): ?>

                    <tr>
                        <td colspan="6">No customers found.</td>
                    </tr>

                <?php else: ?>

                    <?php foreach ($customers as $c): ?>

                    <tr>
                        <td>C<?= str_pad((string)$c["id"], 3, "0", STR_PAD_LEFT) ?></td>
                        <td><?= h($c["name"]) ?></td>
                        <td><?= h($c["account_number"]) ?></td>
                        <td><?= h($c["email"]) ?></td>
                        <td><?= h($c["phone"]) ?></td>
                        <td><span class="status <?= h(strtolower($c["status"])) ?>"><?= h($c["status"]) ?></span></td>
                    </tr>

                    <?php endforeach; ?>

                <?php endif; ?>

                </tbody>

            </table>


        </div>

    </div>


</body>

</html>