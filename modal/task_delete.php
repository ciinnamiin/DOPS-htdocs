<?php
// Establish database connection
include('includes/db.php'); // Include your database connection script
include('includes/session.php');

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $task_id = $_GET['id'];
    $_SESSION["success"] = "";
    $_SESSION["error"] = "";
    // Prepare and execute SQL DELETE query
    $delete_tasks_query = "DELETE FROM timesheets WHERE task_id = '$task_id'";
    if ($conn->query($delete_tasks_query)) {
        $_SESSION["success"] .= "Timesheet deleted successfully.";
    }else {
        $_SESSION["error"] .= "Error deleting task: " . $conn->error;
    }

    $sql = "DELETE FROM tasks WHERE task_id = $task_id";
    if ($conn->query($sql) === TRUE) {
        $_SESSION["success"] .= "<br>Task deleted successfully.";
    } else {
        $_SESSION["error"] .= "<br>Error deleting task: " . $conn->error;
    }
    // Redirect back to the list of projects
    header("Location: tasks.php"); // Change 'index.php' to the appropriate URL
    exit();
} else {
    $_SESSION["error"] = "Invalid task ID.";
    header("Location: tasks.php"); // Change 'index.php' to the appropriate URL
    exit();
}

?>
