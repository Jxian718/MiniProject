<?php
session_start();

// Check whether admin is logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$staff = $_SESSION["staff"] ?? [];

$totalStaff = count($staff);
$activeStaff = 0;
$inactiveStaff = 0;

foreach ($staff as $member) {
    if ($member["status"] === "Active") {
        $activeStaff++;
    } else {
        $inactiveStaff++;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Admin Dashboard - Bank System</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: #f5f7fb;
            color: #1e293b;
        }

        /* Navigation bar */
        .navbar {
            min-height: 65px;
            background: #1e3a8a;
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px 45px;
            flex-wrap: wrap;
            gap: 15px;
        }

        .logo {
            font-size: 21px;
            font-weight: bold;
        }

        .nav-links {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            font-size: 15px;
            padding: 9px 12px;
            border-radius: 5px;
        }

        .nav-links a:hover {
            background: #2563eb;
        }

        .logout {
            background: #dc2626;
        }

        .logout:hover {
            background: #b91c1c;
        }

        /* Main container */
        .container {
            max-width: 1100px;
            margin: auto;
            padding: 40px 30px;
        }

        .welcome {
            margin-bottom: 30px;
        }

        .welcome h1 {
            font-size: 28px;
            margin-bottom: 10px;
        }

        .welcome p {
            color: #64748b;
            font-size: 14px;
        }

        /* Statistics cards */
        .stats {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            box-shadow: 0 2px 7px rgba(0, 0, 0, 0.05);
        }

        .stat-card h3 {
            color: #64748b;
            font-size: 14px;
            margin-bottom: 15px;
        }

        .stat-card p {
            font-size: 30px;
            font-weight: bold;
        }

        .total {
            color: #1e3a8a;
        }

        .active-number {
            color: #16a34a;
        }

        .inactive-number {
            color: #dc2626;
        }

        /* Staff table panel */
        .panel {
            background: white;
            padding: 25px;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            box-shadow: 0 2px 7px rgba(0, 0, 0, 0.05);
            margin-bottom: 25px;
        }

        .panel-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            margin-bottom: 25px;
            flex-wrap: wrap;
        }

        .panel-header h2 {
            font-size: 21px;
        }

        .button {
            display: inline-block;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            color: white;
            text-decoration: none;
            cursor: pointer;
            font-size: 13px;
        }

        .manage-button {
            background: #2563eb;
        }

        .manage-button:hover {
            background: #1d4ed8;
        }

        .table-wrap {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 550px;
        }

        th {
            background: #f8fafc;
            color: #475569;
            text-align: left;
            padding: 16px;
            font-size: 14px;
        }

        td {
            padding: 16px;
            border-bottom: 1px solid #e2e8f0;
            color: #475569;
            font-size: 14px;
        }

        tbody tr:hover {
            background: #f8fafc;
        }

        .staff-id {
            color: #1e3a8a;
            font-weight: bold;
        }

        .status {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: bold;
        }

        .active {
            background: #dcfce7;
            color: #15803d;
        }

        .inactive {
            background: #fee2e2;
            color: #b91c1c;
        }

        .empty-message {
            text-align: center;
            padding: 25px;
            color: #64748b;
        }

    </style>
</head>

<body>

    <!-- Navigation -->
    <nav class="navbar">
        <div class="logo">Bank System</div>

        <div class="nav-links">
            <a href="admin.php">Dashboard</a>
            <a href="manage.php">Manage Staff</a>
            <a href="customers.php">Customers</a>
            <a href="logout.php" class="logout">Logout</a>
        </div>
    </nav>

    <main class="container">

        <!-- Welcome section -->
        <section class="welcome">
            <h1>Admin Dashboard</h1>
            <p>Welcome to the Bank System administration panel.</p>
        </section>


        <section class="stats">

            <div class="stat-card">
                <h3>Total Staff</h3>
                <p class="total">
                    <?= $totalStaff ?>
                </p>
            </div>

            <div class="stat-card">
                <h3>Active Staff</h3>
                <p class="active-number">
                    <?= $activeStaff ?>
                </p>
            </div>

            <div class="stat-card">
                <h3>Inactive Staff</h3>
                <p class="inactive-number">
                    <?= $inactiveStaff ?>
                </p>
            </div>

        </section>

        <!-- Staff list -->
        <section class="panel">

            <div class="panel-header">
                <h2>Staff List</h2>
            </div>

            <div class="table-wrap">
                <table>

                    <thead>
                        <tr>
                            <th>Staff ID</th>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php if (empty($staff)): ?>

                            <tr>
                                <td colspan="4" class="empty-message">
                                    No staff members found.
                                    <a href="manage.php">Add staff here</a>.
                                </td>
                            </tr>

                        <?php else: ?>

                            <?php foreach ($staff as $member): ?>

                                <tr>
                                    <td class="staff-id">
                                        #<?= str_pad(
                                            (string)$member["id"],
                                            4,
                                            "0",
                                            STR_PAD_LEFT
                                        ) ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars(
                                            $member["name"],
                                            ENT_QUOTES,
                                            "UTF-8"
                                        ) ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars(
                                            $member["username"],
                                            ENT_QUOTES,
                                            "UTF-8"
                                        ) ?>
                                    </td>

                                    <td>
                                        <span class="status <?= strtolower(
                                            $member["status"]
                                        ) ?>">
                                            <?= htmlspecialchars(
                                                $member["status"],
                                                ENT_QUOTES,
                                                "UTF-8"
                                            ) ?>
                                        </span>
                                    </td>
                                </tr>

                            <?php endforeach; ?>

                        <?php endif; ?>

                    </tbody>

                </table>
            </div>

        </section>

    </main>

</body>
</html>