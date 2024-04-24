<?php
session_start(); // Start a session if not already started

// Include your database connection file (replace 'includes/db.php' with the actual path)
include_once('includes/db.php');

// Check if the database connection is established successfully
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Update</title>
    <link href="bootstrap.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/@jarstone/dselect/dist/js/dselect.js"></script>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<?php
if (isset($_GET['email']) && isset($_GET['reset_token'])) {
    $token = $_GET['reset_token'];
    date_default_timezone_set('Africa/Johannesburg');
    $date = date("Y-m-d");
    $email = $_GET['email'];

    // Use prepared statements to avoid SQL injection
    $stmt = mysqli_prepare($conn, "SELECT * FROM `employees` WHERE `email` = ? AND `resettoken` = ? AND `resettokenexpired` = ?");
    mysqli_stmt_bind_param($stmt, "sss", $email, $token, $date);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 1) {
        if (isset($_POST['updatepassword'])) {
            $new_password = $_POST['new_password'];
            $confirm_password = $_POST['confirm_password'];

            if ($new_password === $confirm_password) {
                $pass = password_hash($new_password, PASSWORD_BCRYPT);
                $update = "UPDATE `employees` SET `password` = ?, `resettoken` = NULL, `resettokenexpired` = NULL WHERE `email` = ?";
                $stmt = mysqli_prepare($conn, $update);
                mysqli_stmt_bind_param($stmt, "ss", $pass, $email);

                if (mysqli_stmt_execute($stmt)) {
                    echo "
                        <script>
                        alert('Password Updated Successfully');
                        window.location.href='login.php';
                        </script>
                    ";
                } else {
                    echo "
                        <script>
                            alert('Server error. Please try again later.');
                            window.location.href='password-reset.php';
                        </script>
                    ";
                }
            } else {
                echo "
                    <script>
                        alert('Passwords do not match.');
                        window.location.href='password-reset.php?email=$email&reset_token=$token';
                    </script>
                ";
            }
        } else {
            echo '
            <div class="container" style="padding-top: 80px;">
                <br>
                <div class="container col-md-6">            
                    <div class="card mb-3">
                        <div class="card-header"> 
                            <center><h2>Change Password</h2></center>
                        </div>
                        <div class="card-body">
                            <form action="" method="POST"> 
                                <div class="row form-control">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="new_password">New Password</label>
                                            <br>
                                            <input type="hidden" name="token" value="' . htmlspecialchars($token) . '">
                                            <input type="password" placeholder="New Password" class="form-control" id="new_password" name="new_password" autocomplete="off" required />
                                        </div> 
                                    </div> 
                                    <br>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="confirm_password">Confirm Password</label>
                                            <br>
                                            <input type="password" placeholder="Confirm Password" class="form-control" id="confirm_password" name="confirm_password" autocomplete="off" required />
                                        </div> 
                                    </div>  
                                    <br>  
                                </div>
                                <div class="row mt-2">
                                    <div class="col">
                                        <br>
                                        <center><button type="submit" class="btn btn-primary" name="updatepassword">Update Password</button></center>
                                    </div>                                
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>';
        }
    } else {
        echo "
        <script>
            alert('Invalid or expired link');
            window.location.href='password-reset.php';
        </script>
        ";
    }
} else {
    echo "
    <script>
        alert('Invalid request');
        window.location.href='password-reset.php';
    </script>
    ";
}

// Close the database connection
mysqli_close($conn);
?>

</body>
</html>
