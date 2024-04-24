<?php
include_once('includes/db.php');

function sendMail($email, $reset_token)
{
    $to = $email;
    $subject = "Password reset from PGA Timesheet";
    $message = "Hello, <br>";
   
    // for testing online, uncomment the below line of code and comment out the other one

    // $message .= "<br> Click the link below to reset your password: <br> <a href='https://pgaarchitects.co.za/timesheet/password-change.php?email=$email&reset_token=$reset_token'>Reset Password</a>";
    $message .= "<br> Click the link below to reset your password: <br> <a href='http://localhost/modal/password-change.php?email=$email&reset_token=$reset_token'>Reset Password</a>";
    $message .= "<br> <br> Kind Regards, ";
    $message .= "<br> PGA Admin ";

    // Always set content-type when sending HTML email
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

    // More headers
    $headers .= 'From: PGA Timesheet <timesheet@pgaarchitects.co.za>' . "\r\n";
   
    if (mail($to, $subject, $message, $headers)) {
        return true; // Email sent successfully
    } else {
        return false; // Email sending failed
    }
}

if (isset($_POST['send-reset-link'])) {
    $email = $_POST['email'];
    
    // Validate the email address
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Use a procedural query to fetch the user
        $query = "SELECT * FROM employees WHERE email = '$email'";
        $result = mysqli_query($conn, $query);
        
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $reset_token = bin2hex(random_bytes(16));
            date_default_timezone_set('Africa/Johannesburg');
            $date = date("Y-m-d");
            
            // Use a procedural query to update the user's reset token and expiration date
            $update_query = "UPDATE `employees` SET `resettoken` = '$reset_token', `resettokenexpired` = '$date' WHERE `email` = '$email'";
            
            if (mysqli_query($conn, $update_query) && sendMail($email, $reset_token)) {
                echo "
                <script>
                    alert('Password Reset Link Sent to email');
                    window.location.href='login.php';
                </script>
                ";
            } else {
                echo "
                <script>
                    alert('Database error or email sending failed! Please try again later');
                    window.location.href='password-reset.php';
                </script>
                ";
            }
        } else {
            echo "
                <script>
                    alert('User not found!');
                    window.location.href='password-reset.php';
                </script>
                ";
        }
    } else {
        echo "
            <script>
                alert('Invalid email address');
                window.location.href='password-reset.php';
            </script>
            ";
    }
}
?>
