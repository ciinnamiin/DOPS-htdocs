<?php
if ($_SERVER["REQUEST_METHOD"] == "GET") {
   
    include_once('includes/session.php');

   $task_id = $_GET["task_id"];

    $sql = "DELETE FROM timesheets WHERE timesheet_id = '$task_id' ";
    if ($conn->query($sql) === TRUE) {
        // $_SESSION["success"] = "Deleted Successfully!";
        header('Content-Type: application/json');
        echo json_encode(array("success"=>"Deleted!"));
    }else{
        header('Content-Type: application/json');
        echo json_encode(array("error"=>"Failed to delete!"));
        // $_SESSION["error"] = "Failed to submit!";
    }
}
?>
