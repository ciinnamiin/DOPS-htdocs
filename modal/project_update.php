<?php
include_once('includes/session.php');
include_once('includes/db.php');



if ($_SERVER["REQUEST_METHOD"] == "POST") {
   // Get the client_id from the form
    
    if(isset($_POST["project_id"]) && $_POST["project_id"] != ''){
         $project_id = $_POST["project_id"]; 
        $employee_id = $_POST["employee_id"];
        $project_name = $_POST["project_name"];
        $start_date = $_POST["start_date"];
        // $rate = $_POST["rate"];
        $end_date = $_POST["end_date"];
        $client_id = $_POST["client_id"];
        $status_id = $_POST["status_id"];
        
        $valid = 1; // validated initially
        $errorMsg = '';

        //if ($valid == 1) {            
            
            
          
            $sql = "UPDATE projects SET project_name = '$project_name', `start_date` = '$start_date', `end_date` = '$end_date', client_id ='$client_id', employee_id = '$employee_id', status_id = '$status_id' WHERE project_id = '$project_id' ";

            if ($conn->query($sql) === TRUE) {
                $_SESSION["success"] = "Project Updated successfully!";
                header("Location: project_edit.php?id=$project_id"); // Use PHP header for redirection
                exit();
            } else {
                $_SESSION["error"] = "Error updating project!";
                header('Location: project_edit.php?id='.$project_id);
                exit();
            }   
        // } else {
        //     $_SESSION["error"] = $errorMsg;
        //     header('Location: position_edit.php?id='.$project_id);
        //     exit();
        // }
    }
}
?>

