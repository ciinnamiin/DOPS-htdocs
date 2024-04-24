<?php
session_start();
include_once('includes/db.php');

function send_password_reset($email, $token)
{
    $to = $email;
    $subject = "PGA Timesheet - Password Reset";
    $message = "Hello, you are receiving this email because we received a password reset request for your account. Click the link below to reset your password:<br>";
    $message .= "<a href='http://localhost/modal/password-change.php?token=$token&email=$email'>Reset Password</a><br><br>";
    $message .= "Kind Regards,<br>PGA Admin";

    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= 'From: PGA Timesheet <timesheet@pgaarchitects.co.za>' . "\r\n";

    if (mail($to, $subject, $message, $headers)) {
        return true;
    } else {
        return false;
    }
}

if (isset($_POST['password_reset_link'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $token = md5(rand());

    $check_email = "SELECT email FROM employees WHERE email = '$email' LIMIT 1";
    $check_email_run = mysqli_query($conn, $check_email);

    if (mysqli_num_rows($check_email_run) > 0) {
        $row = mysqli_fetch_array($check_email_run);
        $get_email = $row['email'];

        $update_token = "UPDATE employees SET verify_token='$token' WHERE email='$get_email' LIMIT 1";
        $update_token_run = mysqli_query($conn, $update_token);

        if ($update_token_run) {
            if (send_password_reset($get_email, $token)) {
                $_SESSION['status'] = "We emailed you a password reset link";
                header("Location: password-reset.php");
                exit();
            } else {
                $_SESSION['error'] = "Failed to send the password reset email";
                header("Location: password-reset.php");
                exit();
            }
        } else {
            $_SESSION['error'] = "Something went wrong while updating the token";
            header("Location: password-reset.php");
            exit();
        }
    } else {
        $_SESSION['error'] = "No email found";
        header("Location: password-reset.php");
        exit();
    }
}

if (isset($_POST['password_update'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $new_password = mysqli_real_escape_string($conn, $_POST['new_password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);
    $token = mysqli_real_escape_string($conn, $_POST['password_token']);

    if (!empty($token)) {
        if (!empty($email) && !empty($new_password) && !empty($confirm_password)) {
            $check_token = "SELECT verify_token FROM employees WHERE verify_token='$token' LIMIT 1";
            $check_token_run = mysqli_query($conn, $check_token);

            if (mysqli_num_rows($check_token_run) > 0) {
                if ($new_password == $confirm_password) {
                    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                    $update_password = "UPDATE employees SET password='$hashed_password' WHERE verify_token='$token' LIMIT 1";
                    $update_password_run = mysqli_query($conn, $update_password);

                    if ($update_password_run) {
                        $_SESSION['status'] = "Your password has been successfully updated";
                        header("Location: login.php");
                        exit();
                    } else {
                        $_SESSION['error'] = "Something went wrong while updating the password";
                        header("Location: password-change.php?token=$token&email=$email");
                        exit();
                    }
                } else {
                    $_SESSION['error'] = "Password and confirm password do not match";
                    header("Location: password-change.php?token=$token&email=$email");
                    exit();
                }
            } else {
                $_SESSION['error'] = "Invalid or expired token";
                header("Location: password-change.php?token=$token&email=$email");
                exit();
            }
        } else {
            $_SESSION['error'] = "All fields are mandatory";
            header("Location: password-change.php?token=$token&email=$email");
            exit();
        }
    } else {
        $_SESSION['error'] = "No token available";
        header("Location: password-change.php");
        exit();
    }
}
?>
