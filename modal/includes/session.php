<?php
session_start();
include_once('db.php');

if(isset($_SESSION["User"]) && $_SESSION["User"]["employee_id"] != ""){
    // user logged in
    $sql = "SELECT * FROM employees WHERE employee_id LIKE '".$_SESSION["User"]["employee_id"]."' "; // Adjust the SQL query as needed
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
       $user = $result->fetch_assoc();
       $_SESSION["User"] = $user;
    }
    //echo $_SESSION["User"]["first_name"];
    //echo '<script>window.location.href = "index.php" </script>';
}else{
    // redirect to login
    //echo "redirect to login";
    echo '<script>window.location.href = "login.php" </script>';
}
