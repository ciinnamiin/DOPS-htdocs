<?php
session_start();
include_once('includes/db.php');
include_once('includes/session.php');
// require 'config.php'; // Include your database configuration

if (isset($_POST['reset-request-submit'])) {
    $email = $_POST['email'];

    // Check if the email exists in your database
    $sql = "SELECT * FROM employees WHERE email=?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        $_SESSION['message'] = "SQL error.";
        header("Location: password-reset.php?error=sqlerror");
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if ($row = mysqli_fetch_assoc($result)) {
            $token = bin2hex(random_bytes(32)); // Generate a random token
            // $url = "https://yourwebsite.com/reset-password.php?token=" . $token;
            $url = "https://localhost/modal/reset-password.php?token=" . $token;

            
            // You should send an email containing the reset link ($url) to the user here
            
            $_SESSION['message'] = "Password reset link sent! Check your email.";
            header("Location: password-reset.php?reset=success");
            exit();
        } else {
            $_SESSION['message'] = "No user found with that email address.";
            header("Location: password-reset.php?error=nouser");
            exit();
        }
    }
} else {
    header("Location: password-reset.php");
    exit();
}
