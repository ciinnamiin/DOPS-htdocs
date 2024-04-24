<?php
// Establish database connection
include('includes/db.php'); // Include your database connection script
include('includes/session.php');

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    
    // Prepare and execute SQL DELETE query
    $sql = "DELETE FROM project_users WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        $_SESSION["success"] = "Deleted successfully.";
    } else {
        $_SESSION["error"] = "Error deleting : " . $conn->error;
    }
    
    // Redirect back to the list of projects
    header("Location: assign.php"); // Change 'index.php' to the appropriate URL
    exit();
} else {
    $_SESSION["error"] = "Invalid project ID.";
    header("Location: assign.php"); // Change 'index.php' to the appropriate URL
    exit();
}
?>
