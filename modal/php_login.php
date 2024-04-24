<?php
session_start();
include_once('includes/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    
    $username = $_POST["username"];
    $password = $_POST["password"];
    
    $sql = "SELECT * FROM employees WHERE email LIKE '$username' "; // Adjust the SQL query as needed
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
       $user = $result->fetch_assoc();

        if(password_verify($password, $user["password"])){
                $_SESSION["User"] = $user;
                // print_r($_SESSION["User"]);
                echo '<script>window.location.href = "dashboard.php" </script>';
           }else{
                $_SESSION['error'] = 'Credentials do not match our records!';
                // print_r($_SESSION["User"]);
                echo '<script>window.history.back();</script>';
           }
    
        }else{
            $_SESSION['error'] = 'Could not find employee!';
            // echo $_SESSION['error'];
            header('Location: login.php');
            // echo '<script>window.history.back();</script>';
        }
    
    $conn->close();
}
?>
