<?php

session_start();

include "database.php";

$message = "";

if (isset($_POST["register"])) {

    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    $check = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $check);

    if (mysqli_num_rows($result) > 0) {

        $message = "Email already exists!";

    } else {

        $role = "user";

        $sql = "INSERT INTO users (name, email, password, role)
                VALUES ('$name', '$email', '$password', '$role')";

        if (mysqli_query($conn, $sql)) {

            $user_id = mysqli_insert_id($conn);

            $_SESSION["user_id"] = $user_id;
            $_SESSION["name"] = $name;
            $_SESSION["role"] = $role;

            header("Location: user.php");
            exit();

        } else {

            $message = "Registration failed!";

        }
    }
}

?>


<!DOCTYPE html>
<html>

<head>
    <title>Register</title>
<style>
   * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    margin: 0;
    min-height: 100vh;
    background-image: url("../images/city.jpg");
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    display: flex;
    justify-content: center;
    align-items: center;
}


.register-box {

    width: 420px;
    max-width: 90%;
    padding: 40px;
    background: rgba(255, 255, 255, 0.96);
    border-radius: 20px;
    box-shadow:0 20px 50px rgba(0, 0, 0, 0.35);
    text-align: center;
    animation: fadeIn 0.8s ease;
}

.register-box h2 {

    color: #0b5ed7;
    font-size: 30px;
    margin-bottom: 8px;
    font-weight: 700;
}

.register-box h3 {

    color: #555;
    font-size: 18px;
    margin-bottom: 28px;
    font-weight: normal;
}

/* Error message */

.error {

    background: #ffe5e5;
    color: #d8000c;
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
    background: linear-gradient(135deg, #0b5ed7, #063b91);
    color: white;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
    transition: 0.3s;
    margin-top: 5px;
}

button:hover {

    

    box-shadow:
        0 8px 20px rgba(11, 94, 215, 0.3);
}

.register-box p:last-child 
{

    margin-top: 22px;
    color: #666;
    font-size: 14px;
}

.register-box a
{
    color: #0b5ed7;
    text-decoration: none;
    font-weight: bold;
}

.register-box a:hover 
{
   text-decoration: underline;
}



</style>
    
</head>

<body>

<div class="register-box">

    <h2>Bank System</h2>

    <h3>Register</h3>

    <?php

    if ($message != "") {
        echo "<p>$message</p>";
    }

    ?>

    <form method="POST">

        <label>Name</label>
        <input type="text" name="name" required>

        <br><br>

        <label>Email</label>
        <input type="email" name="email" required>

        <br><br>

        <label>Password</label>
        <input type="password" name="password" required>

        <br><br>

        <button type="submit" name="register">Register</button>

    </form>

    <br>

    <p>
    Already have an account?
    <a href="login.php">Login</a>
    </p>


</div>

</body>

</html>

