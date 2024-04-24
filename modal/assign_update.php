<?php
include_once('includes/session.php');
include_once('includes/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST["project_id"]) && $_POST["project_id"] != ''){
        $project_id = $_POST["project_id"]; 
        $employee_id = $_POST["employee_id"];
        $rate = $_POST["rate"];
        $assign_id = $_POST["assign_id"];
        $valid = 1; // validated initially
        $errorMsg = '';

        if ($valid == 1) {
            // Start a transaction
            $conn->begin_transaction();

            if(assigned($employee_id, $project_id))
            // {
            //     $_SESSION["error"] = "Employee already assigned to this project!";
            // }else
            {
                // Update the employee assignment
                $sql = "UPDATE project_users SET employee_id = ?, rate = ?, project_id = ? WHERE project_users.id = '$assign_id' ";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("iii", $employee_id, $rate, $project_id);
                if (!$stmt->execute()) {
                    $_SESSION["error"] = "Error updating employee assignment!";
                    $conn->rollback();
                    header('Location: assign_edit.php?id='.$project_id);
                    exit();
                }
                $stmt->close();
                $conn->commit();

                $_SESSION["success"] = "Updated successfully!";
               
            }
            header("Location: assign_edit.php?id=$project_id");
            exit();

            
            
            // Update the employee's rate for the project
            // $sql2 = "UPDATE employee_project_rate SET rate = ? WHERE employee_id = ? AND project_id = ?";
            // $stmt2 = $conn->prepare($sql2);
            // $stmt2->bind_param("dii",  $employee_id, $project_id);
            // if (!$stmt2->execute()) {
            //     $_SESSION["error"] = "Error updating employee rate!";
            //     $conn->rollback();
            //     header('Location: assign_edit.php?id='.$project_id);
            //     exit();
            // }
            // $stmt2->close();

            // Commit the transaction
           
        }
    }
}

// ... the rest of your code ...


// ... the rest of your code ...
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
?>

