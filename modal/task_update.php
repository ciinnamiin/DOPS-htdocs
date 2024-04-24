<?php
include_once('includes/session.php');
include_once('includes/db.php');



if ($_SERVER["REQUEST_METHOD"] == "POST") {
   // Get the client_id from the form
    
    if(isset($_POST["task_id"]) && $_POST["task_id"] != ''){
        $task_id = $_POST["task_id"];
        $task_name = $_POST["task_name"];
        $project_id = $_POST["project_id"];
        $disease_id = $_POST["disease_id"];
        $date = $_POST["date"];
        $start = $_POST["start"];
        $end = $_POST["end"];
        $hours = timeToDecimal($end) - timeToDecimal($start);
        
        $valid = 1; // validated initially
        $errorMsg = '';

        //if ($valid == 1) {            
            $sql = "UPDATE tasks SET task_name = '$task_name', project_id = '$project_id', disease_id = '$disease_id'
            WHERE task_id = '$task_id' ";
            
            $sql2 = "UPDATE timesheets SET `start` = '$start', `end` = '$end', `date` = '$date', `hours` = '$hours' 
            WHERE active = '1' AND task_id = '$task_id' ";

            if ($conn->query($sql) === TRUE && $conn->query($sql2) === TRUE) {
                $_SESSION["success"] = "Task Updated successfully!";
                header("Location: task_edit.php?id=$task_id"); // Use PHP header for redirection
                exit();
            } else {
                $_SESSION["error"] = "Error updating project!";
                header('Location: task_edit.php?id='.$task_id);
                exit();
            }   
        // } else {
        //     $_SESSION["error"] = $errorMsg;
        //     header('Location: position_edit.php?id='.$project_id);
        //     exit();
        // }
    }
}

function get_project($project){
    global $conn;

    $sql = "SELECT * FROM projects where project_name LIKE '$project' "; // Adjust the SQL query as needed
    $result = $conn->query($sql);
    $project = array();

    if ($result->num_rows > 0) {
        $project = $result->fetch_assoc();
        
    }
    return $project["project_id"];
}
function get_disease($disease){
    global $conn;

    $sql = "SELECT * FROM diseases where disease_name LIKE '$disease' "; // Adjust the SQL query as needed
    $result = $conn->query($sql);
    $disease = array();

    if ($result->num_rows > 0) {
        $disease = $result->fetch_assoc();
        
    }
    return $disease["disease_id"];
}

function timeToDecimal($time) {
    list($hours, $minutes) = explode(':', $time);
    return $hours + ($minutes / 60);
}
?>

