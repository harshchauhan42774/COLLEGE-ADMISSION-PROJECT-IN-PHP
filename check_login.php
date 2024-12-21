<?php
session_start();
include 'conn.php'; // Adjust the path as needed

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php"); // Redirect to login page
    exit();
}

$loggedInUserEmail = $_SESSION['email'];
?>
