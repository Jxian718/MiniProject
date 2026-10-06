<?php

session_start();

include "database.php";

$message = "";

if (isset($_POST["register"])) {

    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

   
    $check = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $check);
    if (mysqli_num_rows($result) > 0) {
        $message = "Email already exists!";
    } else {

        $role = "user";
        $balance = 0.00;

        $sql = "INSERT INTO users
                (name, email, password, role, balance)
                VALUES
                ('$name', '$email', '$password', '$role', '$balance')";

        if (mysqli_query($conn, $sql)) {
            header("Location: login.php?registered=1");
            exit();

        } else {

            $message = "Registration failed!";

        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
    <style>

        * 
        {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body 
        {
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

        .register-box 
        {
            width: 420px;
            max-width: 90%;
            padding: 40px;
            background: rgba(255, 255, 255, 0.96);
            border-radius: 20px;
            box-shadow:0 20px 50px rgba(0, 0, 0, 0.35);
            text-align: center;
        }

        .register-box h2 
        {
            color: #0b5ed7;
            font-size: 30px;
            margin-bottom: 8px;
            font-weight: 700;
        }

        .register-box h3 
        {
            color: #555;
            font-size: 18px;
            margin-bottom: 28px;
            font-weight: normal;
        }

        .message 
        {
            background: #ffe5e5;
            color: #d8000c;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        form 
        {
            text-align: left;
        }

        label 
        {
            display: block;
            margin-bottom: 7px;
            color: #333;
            font-size: 14px;
            font-weight: 600;
        }

        input 
        {
            width: 100%;
            padding: 13px 15px;
            margin-bottom: 18px;
            border: 1px solid #ddd;
            border-radius: 10px;
            outline: none;
            font-size: 15px;
            transition: 0.3s;
        }

        input:focus 
        {
            border-color: #0b5ed7;
            box-shadow:0 0 0 3px rgba(11, 94, 215, 0.12);
        }

        button 
        {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 10px;
            background:linear-gradient(135deg,#0b5ed7, #063b91);
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 5px;
            transition: 0.3s;
        }

        button:hover 
        {
            transform: translateY(-2px);
            box-shadow:0 8px 20px rgba(11, 94, 215, 0.3);
        }

        .login-link 
        {
            margin-top: 22px;
            color: #666;
            font-size: 14px;
        }

        .login-link a 
        {
            color: #0b5ed7;
            text-decoration: none;
            font-weight: bold;
        }

        .login-link a:hover 
        {
            text-decoration: underline;
        }

    </style>
</head>

<body>

<div class="register-box">

    <h2>Bank System</h2>

    <h3>Create Your Account</h3>


    <?php if ($message != ""): ?>

        <div class="message">
            <?= htmlspecialchars($message) ?>
        </div>

    <?php endif; ?>


    <form method="POST">

        <label>
            Full Name
        </label>

        <input
            type="text"
            name="name"
            placeholder="Enter your full name"
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
            placeholder="Create a password"
            required
        >


        <button type="submit" name="register">
            Create Account
        </button>

    </form>


    <div class="login-link">

        Already have an account?

        <a href="login.php">
            Login
        </a>

    </div>

</div>

</body>

</html>
