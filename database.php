<?php

$conn = mysqli_connect(
    "localhost",
    "root",
    "root",
    "bank_system",
    3306
);

if (!$conn) {
    die("Database connection failed");
}

?>
