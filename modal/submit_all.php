<?php

if ($_SERVER['REQUEST_METHOD'] === 'GET' && $_GET["submit"] == "all") {
    include_once('includes/session.php');

    $employee_id = $_SESSION["User"]["employee_id"];

    // Check if any active tasks have a non-zero value
    $check_sql = "SELECT COUNT(*) as count FROM timesheets WHERE employee_id = '$employee_id' AND active = 0";
    $result = $conn->query($check_sql);
    $row = $result->fetch_assoc();
    $activeTasksCount = $row['count'];

    if ($activeTasksCount > 0) {
        $_SESSION["success"] = "All tasks submitted!";
    } else {
        $_SESSION["error"] = "Please log in tasks to submit!";
    }

    // Update all tasks to active
    $update_sql = "UPDATE timesheets SET active = 1 WHERE employee_id = '$employee_id' AND active = 0";

    if ($conn->query($update_sql) === TRUE) {
        header("Location: tasks.php");
        exit();
    } else {
        $_SESSION["error"] = "Error submitting tasks!";
        header('Location: tasks.php');
        exit();
    }
}









?>