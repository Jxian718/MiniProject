<?php
session_start();


if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}


if (!isset($_SESSION["staff"])) {
    $_SESSION["staff"] = [
        ["id" => 1, "name" => "Edmond", "username" => "ED01", "status" => "Active"],
        ["id" => 2, "name" => "Oscar", "username" => "ED02", "status" => "Inactive"],
        ["id" => 3, "name" => "Desmond", "username" => "ED03", "status" => "Active"],
        ["id" => 4, "name" => "Jinxian", "username" => "ED04", "status" => "Inactive"]
    ];
}


if (empty($_SESSION["csrf_token"])) {
    $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
}

$message = $_SESSION["staff_message"] ?? "";
$messageType = $_SESSION["staff_message_type"] ?? "success";

unset($_SESSION["staff_message"], $_SESSION["staff_message_type"]);

function redirectManage($message, $type = "success") {
    $_SESSION["staff_message"] = $message;
    $_SESSION["staff_message_type"] = $type;
    header("Location: manage.php");
    exit();
}


if ($_SERVER["REQUEST_METHOD"] === "POST") {

   
    $token = $_POST["csrf_token"] ?? "";

    if (!hash_equals($_SESSION["csrf_token"], $token)) {
        redirectManage("Invalid request. Please try again.", "error");
    }

    $action = $_POST["action"] ?? "";
    $id = filter_var($_POST["id"] ?? null, FILTER_VALIDATE_INT);

    if ($action === "add") {

        $name = trim($_POST["name"] ?? "");
        $username = trim($_POST["username"] ?? "");
        $status = $_POST["status"] ?? "";

        if ($name === "" || $username === "") {
            redirectManage("Please enter the staff name and username.", "error");
        }

        if (
            strlen($name) > 100 ||
            strlen($username) > 50 ||
            !in_array($status, ["Active", "Inactive"], true)
        ) {
            redirectManage("Please enter valid staff details.", "error");
        }

        foreach ($_SESSION["staff"] as $member) {
            if (strcasecmp($member["username"], $username) === 0) {
                redirectManage("Username already exists!", "error");
            }
        }

        $ids = array_column($_SESSION["staff"], "id");
        $newId = empty($ids) ? 1 : max($ids) + 1;

        $_SESSION["staff"][] = [
            "id" => $newId,
            "name" => $name,
            "username" => $username,
            "status" => $status
        ];

        redirectManage("Staff added successfully!");
    }

    
    $index = null;

    foreach ($_SESSION["staff"] as $key => $member) {
        if ($id !== false && $id !== null && $member["id"] === $id) {
            $index = $key;
            break;
        }
    }

    if ($index === null) {
        redirectManage("Staff member not found.", "error");
    }

    
    if ($action === "edit") {

        $name = trim($_POST["name"] ?? "");
        $username = trim($_POST["username"] ?? "");

        if ($name === "" || $username === "") {
            redirectManage("Name and username are required.", "error");
        }

        if (strlen($name) > 100 || strlen($username) > 50) {
            redirectManage("Name or username is too long.", "error");
        }

        foreach ($_SESSION["staff"] as $member) {
            if (
                $member["id"] !== $id &&
                strcasecmp($member["username"], $username) === 0
            ) {
                redirectManage("Username already exists!", "error");
            }
        }

        $_SESSION["staff"][$index]["name"] = $name;
        $_SESSION["staff"][$index]["username"] = $username;

        redirectManage("Staff details updated successfully!");
    }

    
    if ($action === "toggle") {

        $_SESSION["staff"][$index]["status"] =
            $_SESSION["staff"][$index]["status"] === "Active"
                ? "Inactive"
                : "Active";

        redirectManage("Staff status changed successfully!");
    }

    
    if ($action === "delete") {

        array_splice($_SESSION["staff"], $index, 1);

        redirectManage("Staff deleted successfully!");
    }

    redirectManage("Unknown action.", "error");
}


$staff = $_SESSION["staff"];


$editId = filter_input(INPUT_GET, "edit", FILTER_VALIDATE_INT);
$editStaff = null;

if ($editId !== null && $editId !== false) {
    foreach ($staff as $member) {
        if ($member["id"] === $editId) {
            $editStaff = $member;
            break;
        }
    }
}

function h($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, "UTF-8");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Manage Staff - Bank System</title>

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
    background: #f5f7fb;
    color: #1e293b;
}

.navbar 
{
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

.logo 
{
    font-size: 21px;
    font-weight: bold;
}

.nav-links 
{
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
}

.nav-links a 
{
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

.container {
    max-width: 1100px;
    margin: auto;
    padding: 40px 30px;
}

.welcome 
{
    margin-bottom: 25px;
}

.welcome h1 
{
    font-size: 28px;
    margin-bottom: 10px;
}

.welcome p 
{
    color: #64748b;
    font-size: 14px;
}

.panel 
{
    background: white;
    padding: 25px;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    box-shadow: 0 2px 7px rgba(0,0,0,0.05);
    margin-bottom: 25px;
}

.panel-header 
{
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 15px;
    margin-bottom: 25px;
    flex-wrap: wrap;
}

.panel-header h2 
{
    font-size: 21px;
}

input, select 
{
    width: 100%;
    padding: 11px;
    margin-top: 7px;
    margin-bottom: 15px;
    border: 1px solid #cbd5e1;
    border-radius: 5px;
    font-size: 14px;
}

label 
{
    font-size: 14px;
    font-weight: bold;
}

.button
 {
    display: inline-block;
    padding: 10px 15px;
    border: none;
    border-radius: 5px;
    color: white;
    text-decoration: none;
    cursor: pointer;
    font-size: 13px;
}

.add 
{
    background: #2563eb;
}

.edit 
{
    background: #16a34a;
}

.delete 
{
    background: #dc2626;
}

.status-button 
{
    background: #64748b;
}

.cancel 
{
    background: #64748b;
}

.message 
{
    padding: 12px 15px;
    border-radius: 5px;
    margin-bottom: 20px;
    font-size: 14px;
}

.message.success 
{
    background: #dcfce7;
    color: #166534;
}

.message.error 
{
    background: #fee2e2;
    color: #991b1b;
}

.table-wrap 
{
    overflow-x: auto;
}

table 
{
    width: 100%;
    border-collapse: collapse;
    min-width: 700px;
}

th 
{
    background: #f8fafc;
    color: #475569;
    text-align: left;
    padding: 16px;
    font-size: 14px;
}

td 
{
    padding: 16px;
    border-bottom: 1px solid #e2e8f0;
    color: #475569;
    font-size: 14px;
}

tbody tr:hover 
{
    background: #f8fafc;
}

.staff-id 
{
    color: #1e3a8a;
    font-weight: bold;
}

.status 
{
    display: inline-block;
    padding: 6px 12px;
    border-radius: 15px;
    font-size: 12px;
    font-weight: bold;
}

.active 
{
    background: #dcfce7;
    color: #15803d;
}

.inactive 
{
    background: #fee2e2;
    color: #b91c1c;
}

.actions 
{
    display: flex;
    gap: 6px;
    flex-wrap: wrap;
}

.actions form 
{
    display: inline;
}

</style>
</head>

<body>

<nav class="navbar">
    <div class="logo">Bank System</div>

    <div class="nav-links">
        <a href="admin.php">Dashboard</a>
        <a href="manage.php">Manage Staff</a>
        <a href="customers.php">Customers</a>
        <a href="logout.php" class="logout">Logout</a>
    </div>
</nav>

<div class="container">

    <div class="welcome">
        <h1>Manage Staff</h1>
        <p>Add, edit, and manage bank staff members.</p>
    </div>

    <?php if ($message !== ""): ?>
        <div class="message <?= h($messageType) ?>">
            <?= h($message) ?>
        </div>
    <?php endif; ?>

    <div class="panel">
        <div class="panel-header">
            <h2>Add New Staff</h2>
        </div>

        <form method="POST" action="manage.php">
            <input type="hidden" name="csrf_token"
                   value="<?= h($_SESSION["csrf_token"]) ?>">
            <input type="hidden" name="action" value="add">

            <label for="name">Staff Name</label>
            <input type="text" id="name" name="name"
                   placeholder="Enter staff name"
                   maxlength="100" required>

            <label for="username">Username</label>
            <input type="text" id="username" name="username"
                   placeholder="Enter username"
                   maxlength="50" required>

            <label for="status">Status</label>
            <select id="status" name="status" required>
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
            </select>

            <button type="submit" class="button add">
                Add Staff
            </button>
        </form>
    </div>

  
    <?php if ($editStaff !== null): ?>
        <div class="panel" id="edit-form">
            <div class="panel-header">
                <h2>Edit Staff #<?= h($editStaff["id"]) ?></h2>
            </div>

            <form method="POST" action="manage.php">
                <input type="hidden" name="csrf_token"
                       value="<?= h($_SESSION["csrf_token"]) ?>">
                <input type="hidden" name="action" value="edit">
                <input type="hidden" name="id"
                       value="<?= h($editStaff["id"]) ?>">

                <label for="edit-name">Staff Name</label>
                <input type="text" id="edit-name" name="name"
                       value="<?= h($editStaff["name"]) ?>"
                       maxlength="100" required>

                <label for="edit-username">Username</label>
                <input type="text" id="edit-username" name="username"
                       value="<?= h($editStaff["username"]) ?>"
                       maxlength="50" required>

                <button type="submit" class="button edit">
                    Save Changes
                </button>

                <a href="manage.php" class="button cancel">
                    Cancel
                </a>
            </form>
        </div>
    <?php elseif (isset($_GET["edit"])): ?>
        <div class="message error">Staff member not found.</div>
    <?php endif; ?>

    <div class="panel">
        <div class="panel-header">
            <h2>Staff List</h2>
            <span>Total Staff: <?= count($staff) ?></span>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Staff ID</th>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                <?php if (empty($staff)): ?>
                    <tr>
                        <td colspan="5">No staff members found.</td>
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

                            <td><?= h($member["name"]) ?></td>

                            <td><?= h($member["username"]) ?></td>

                            <td>
                                <span class="status <?= strtolower(
                                    h($member["status"])
                                ) ?>">
                                    <?= h($member["status"]) ?>
                                </span>
                            </td>

                            <td>
                                <div class="actions">

                                    
                                    <a class="button edit"
                                       href="manage.php?edit=<?= h($member["id"]) ?>#edit-form">
                                        Edit
                                    </a>

                                   
                                    <form method="POST" action="manage.php">
                                        <input type="hidden" name="csrf_token"
                                               value="<?= h($_SESSION["csrf_token"]) ?>">
                                        <input type="hidden" name="action"
                                               value="toggle">
                                        <input type="hidden" name="id"
                                               value="<?= h($member["id"]) ?>">

                                        <button type="submit"
                                                class="button status-button">
                                            Change Status
                                        </button>
                                    </form>

                                    
                                    <form method="POST" action="manage.php"
                                          onsubmit="return confirm('Are you sure you want to delete this staff member?');">
                                        <input type="hidden" name="csrf_token"
                                               value="<?= h($_SESSION["csrf_token"]) ?>">
                                        <input type="hidden" name="action"
                                               value="delete">
                                        <input type="hidden" name="id"
                                               value="<?= h($member["id"]) ?>">

                                        <button type="submit"
                                                class="button delete">
                                            Delete
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

</body>
</html>