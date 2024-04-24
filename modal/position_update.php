<?php
include_once('includes/session.php');
include_once('includes/db.php');



if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["position"])) {
    $position_id = $_POST["position_id"]; // Get the position_id from the form
    
    if(isset($_POST["position"]) && $_POST["position"] != ''){
        $position = $_POST["position"];
        //$employee_id = $_POST["user_id"];
        $is_admin = (isset($_POST["is_admin"])) ? 1 : 0;
        $valid = 1; // validated initially
        $errorMsg = '';

        if ($valid == 1) {            
            $sql = "UPDATE positions SET position = '$position'  WHERE position_id = '$position_id'";

            if ($conn->query($sql) === TRUE) {
                $_SESSION["success"] = "Position Updated successfully!";
                header("Location: position_edit.php?id=$position_id"); // Use PHP header for redirection
                exit();
            } else {
                $_SESSION["error"] = "Error updating position!";
                header('Location: position_edit.php?id='.$position_id);
                exit();
            }   
        } else {
            $_SESSION["error"] = $errorMsg;
            header('Location: position_edit.php?id='.$position_id);
            exit();
        }
    }
}
?>

