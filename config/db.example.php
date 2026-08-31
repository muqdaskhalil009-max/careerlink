<?php

$host = "localhost";
$username = "your_username";
$password = "your_password";
$database = "careerlink";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");

?>