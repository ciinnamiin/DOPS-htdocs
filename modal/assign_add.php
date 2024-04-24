<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    include_once('includes/session.php');

    $project_id = $_POST["project_id"];
    $rate = $_POST["rate"];
    // $employee_id = $_POST["employee_id"];

    // echo json_encode($_POST);

    foreach($_POST["employee_id"] as $employee_id){
        // echo '<br>EmployeeID: '. $employee_id;
        if(!assigned($employee_id, $project_id)){
            $sql = "INSERT INTO project_users (project_id, employee_id) 
            VALUES('$project_id','$employee_id')";
             
            if ($conn->query($sql) === TRUE) {
                $_SESSION["success"] = " Assigned successfully!";
                echo '<script>window.location.href = "assign.php" </script>';
            }else{
                $_SESSION["error"] = "Error assigning employee to a project!";
                echo '<script>window.history.back();</script>';
            }   
        }else{
            $_SESSION["error"] = "Employee already assigned to project!";
            echo '<script>window.history.back();</script>';
        }
    }

    
        
    
}

function assigned($employee_id, $project_id){
    global $conn;

    $sql = "SELECT * FROM project_users WHERE employee_id = '$employee_id' AND project_id = '$project_id' ";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        return true;
    }else{
        return false;
    }
}
