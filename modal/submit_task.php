<?php
if ($_SERVER["REQUEST_METHOD"] == "GET") {
   
    include_once('includes/session.php');

   $task_id = $_GET["task_id"];

    $sql = "UPDATE timesheets SET active = 1 WHERE timesheet_id = '$task_id' ";
    if ($conn->query($sql) === TRUE) {
        $_SESSION["success"] = "Submitted Successfully!";
    }else{
        $_SESSION["error"] = "Failed to submit!";
    }
}
echo '<script>window.location.href = "tasks.php" </script>';
