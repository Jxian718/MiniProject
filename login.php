<?php

session_start();

include "database.php";

$message = "";

/* Login */
if (isset($_POST["login"])) {

    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    /* Check user */
    $sql = "SELECT * FROM users
            WHERE name='$name'
            AND email='$email'
            AND password='$password'";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {

        $user = mysqli_fetch_assoc($result);

        /* Create session */
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["name"] = $user["name"];
        $_SESSION["role"] = $user["role"];

        /* Check role */
        if ($user["role"] == "user") {

            header("Location: user.php");
            exit();

        } elseif ($user["role"] == "staff") {

            header("Location: staff.php");
            exit();

        } elseif ($user["role"] == "admin") {

            header("Location: admin.php");
            exit();

        }

    } else {

        $message = "Invalid name, email or password.";

    }
}

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - Bank System</title>

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {

            min-height: 100vh;

            background-image: url("../images/city.jpg");

            background-size: cover;

            background-position: center;

            background-repeat: no-repeat;

            display: flex;

            justify-content: center;

            align-items: center;

            font-family: Arial, sans-serif;
        }

        .login-box {

            width: 420px;

            max-width: 90%;

            padding: 40px;

            background: rgba(255, 255, 255, 0.96);

            border-radius: 20px;

            box-shadow:
                0 20px 50px rgba(0, 0, 0, 0.35);

            text-align: center;
        }

        .login-box h2 {

            color: #0b5ed7;

            font-size: 30px;

            margin-bottom: 8px;

            font-weight: 700;
        }

        .login-box h3 {

            color: #555;

            font-size: 18px;

            margin-bottom: 28px;

            font-weight: normal;
        }

        .error {

            background: #ffe5e5;

            color: #d8000c;

            padding: 12px;

            border-radius: 8px;

            margin-bottom: 20px;

            font-size: 14px;
        }

        .success {

            background: #e0f7e9;

            color: #167a3e;

            padding: 12px;

            border-radius: 8px;

            margin-bottom: 20px;

            font-size: 14px;
        }

        form {

            text-align: left;
        }

        label {

            display: block;

            margin-bottom: 7px;

            color: #333;

            font-size: 14px;

            font-weight: 600;
        }

        input {

            width: 100%;

            padding: 13px 15px;

            margin-bottom: 18px;

            border: 1px solid #ddd;

            border-radius: 10px;

            outline: none;

            font-size: 15px;

            transition: 0.3s;
        }

        input:focus {

            border-color: #0b5ed7;

            box-shadow:
                0 0 0 3px rgba(11, 94, 215, 0.12);
        }

        button {

            width: 100%;

            padding: 14px;

            border: none;

            border-radius: 10px;

            background:
                linear-gradient(
                    135deg,
                    #0b5ed7,
                    #063b91
                );

            color: white;

            font-size: 16px;

            font-weight: bold;

            cursor: pointer;

            transition: 0.3s;

            margin-top: 5px;
        }

        button:hover {

            transform: translateY(-2px);

            box-shadow:
                0 8px 20px rgba(11, 94, 215, 0.3);
        }

        .register-text {

            margin-top: 22px;

            color: #666;

            font-size: 14px;
        }

        .register-text a {

            color: #0b5ed7;

            text-decoration: none;

            font-weight: bold;
        }

        .register-text a:hover {

            text-decoration: underline;
        }

    </style>

</head>

<body>

<div class="login-box">

    <h2>Bank System</h2>

    <h3>Login</h3>

    <?php if ($message != ""): ?>

        <div class="error">
            <?= htmlspecialchars($message) ?>
        </div>

    <?php endif; ?>


    <?php if (isset($_GET["registered"])): ?>

        <div class="success">
            Account created successfully! Please login.
        </div>

    <?php endif; ?>


    <form method="POST">

        <label>
            Name
        </label>

        <input
            type="text"
            name="name"
            placeholder="Enter your name"
            required
        >


        <label>
            Email
        </label>

        <input
            type="email"
            name="email"
            placeholder="Enter your email"
            required
        >


        <label>
            Password
        </label>

        <input
            type="password"
            name="password"
            placeholder="Enter your password"
            required
        >


        <button type="submit" name="login">
            Login
        </button>

    </form>


    <div class="register-text">

        Don't have an account?

        <a href="register.php">
            Register
        </a>

    </div>

</div>

</body>

</html>
