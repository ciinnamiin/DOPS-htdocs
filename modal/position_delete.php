<?php
// Establish database connection
include('includes/db.php'); // Include your database connection script
include('includes/session.php');

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $position_id = $_GET['id'];
    
    // Prepare and execute SQL DELETE query
    $sql = "DELETE FROM positions WHERE position_id = $position_id";
    if ($conn->query($sql) === TRUE) {
        $_SESSION["success"] = "Position deleted successfully.";
    } else {
        $_SESSION["error"] = "Error deleting position: " . $conn->error;
    }
    
    // Redirect back to the list of projects
    header("Location: position.php"); // Change 'index.php' to the appropriate URL
    exit();
} else {
    $_SESSION["error"] = "Invalid position.";
    header("Location: position.php"); // Change 'index.php' to the appropriate URL
    exit();
}
?>
