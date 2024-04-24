<?php
// Establish database connection
include('includes/db.php'); // Include your database connection script
include('includes/session.php');

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $employee_id = $_GET['id'];
    
    // Prepare and execute SQL DELETE query
    $sql = "DELETE FROM employees WHERE employee_id = $employee_id";
    if ($conn->query($sql) === TRUE) {
        $_SESSION["success"] = "Employee deleted successfully.";
    } else {
        $_SESSION["error"] = "Error deleting employee: " . $conn->error;
    }
    
    // Redirect back to the list of projects
    header("Location: employees.php"); // Change 'index.php' to the appropriate URL
    exit();
} else {
    $_SESSION["error"] = "Invalid project ID.";
    header("Location: employees.php"); // Change 'index.php' to the appropriate URL
    exit();
}
?>
