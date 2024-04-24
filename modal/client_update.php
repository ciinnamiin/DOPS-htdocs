<?php
include_once('includes/session.php');
include_once('includes/db.php');



if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["client"])) {
    $client_id = $_POST["client"]; // Get the client_id from the form
    
    if(isset($_POST["client_name"]) && $_POST["client_name"] != ''){
        $client_name = $_POST["client_name"];
        //$employee_id = $_POST["user_id"];
        $is_admin = (isset($_POST["is_admin"])) ? 1 : 0;
        $valid = 1; // validated initially
        $errorMsg = '';

        if ($valid == 1) {            
            $sql = "UPDATE clients SET client_name = '$client_name'  WHERE client_id = '$client_id'";

            if ($conn->query($sql) === TRUE) {
                $_SESSION["success"] = "Client Updated successfully!";
                header("Location: client_edit.php?id=$client_id"); // Use PHP header for redirection
                exit();
            } else {
                $_SESSION["error"] = "Error updating client!";
                header('Location: client_edit.php?id='.$client_id);
                exit();
            }   
        } else {
            $_SESSION["error"] = $errorMsg;
            header('Location: client_edit.php?id='.$client_id);
            exit();
        }
    }
}
?>

