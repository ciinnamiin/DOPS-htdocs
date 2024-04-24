<?php 
//session_start();
//include_once('conn.php');
include_once('includes/session.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["user_id"])) {
    
    $employee_id = $_POST["user_id"];
    $is_admin = (isset($_POST["is_admin"]))? 1 : 0;
    
    //$headers = "Content-Type: text/html; charset=UTF-8";
    $valid = 1; // validated initially
    $errorMsg = '';

    if(isset($_POST["first_name"]) && $_POST["first_name"] != ''){
        $first_name = $_POST["first_name"];
    }else{
        $errorMsg .= "<li>First Name is required</li>";
        $valid = 0;
    }

    if(isset($_POST["last_name"]) && $_POST["last_name"] != ''){
        $last_name = $_POST["last_name"];
    }else{
        $errorMsg .= "<li>Last Name is required</li>";
        $valid = 0;
    }

    if(isset($_POST["email"]) && $_POST["email"] != '' && validateEmail($_POST["email"])){
        $email = $_POST["email"];
    }else{
        $errorMsg .= "<li>A Valid Email is required</li>";
        $valid = 0;
    }

   

    if(isset($_POST["position_id"]) && $_POST["position_id"] != ''){
        $position_id = $_POST["position_id"];
    }else{
        $errorMsg .= "<li>Position is required</li>";
        $valid = 0;
    }
    $p = '';
    
    if(isset($_POST["password"]) && $_POST["password"] != '' ){
        if(strlen($_POST["password"]) >= 6){
           
        }else{
            $errorMsg .= "<li>Password is required (Minimum 6 characters)!</li>";
            $valid = 0;
        }
        if(isset($_POST["confirm_password"]) && $_POST["confirm_password"] != '' && strlen($_POST["confirm_password"]) >= 6){
            $confirm_password = $_POST["confirm_password"];
        }else{
            $errorMsg .= "<li>Confirm password field is required (Minimum 6 characters)</li>";
            $valid = 0;
        }

        if($_POST["password"] === $_POST["confirm_password"]){
            // $hashed = password_hash($password, PASSWORD_DEFAULT);
             $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
            $p .= ", `password` = '$password'";
        }else{
            $valid = 0;
            $errorMsg .= "Passwords do not match!";
        }
    }
    
    


    if($valid == 1){
        //if(!emailExist($email, $employee_id)){
            
        $sql = "UPDATE employees SET first_name = '$first_name', last_name = '$last_name', position_id = '$position_id', `email` = '$email' $p, is_admin = '$is_admin' WHERE employee_id = '$employee_id' ";

        if ($conn->query($sql) === TRUE) {
            $_SESSION["success"] = "Updated successfully!";
            // echo '<script>window.location.href = "employee_edit.php?id="'.$employee_id.'" </script>';
            header('Location: employee_edit.php?id='.$employee_id);
        }else{
            $_SESSION["error"] = "Error inserting task!";
            echo '<script>window.history.back();</script>';
        }   
            
        //}else{
        //    $_SESSION["error"] = "Email already exists!";
        //    echo '<script>window.history.back();</script>';
        //}
        
    }else{
        $_SESSION["error"] = $errorMsg;
        echo '<script>window.history.back();</script>';
    }
    
}

    
function validateEmail($email) {
    // Regular expression pattern for basic email validation
    $pattern = '/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/';

    return preg_match($pattern, $email);
}

function emailExist($email, $id){
    global $conn;

    $sql = "SELECT * FROM employees WHERE `Email` = '$email' AND employee_id <> '$id' "; // Adjust the SQL query as needed
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        return true;
    }else{
        return false;
    }
}

?>

