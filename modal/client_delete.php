<?php
// Establish database connection
include('includes/db.php'); // Include your database connection script
include('includes/session.php');

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $client_id = $_GET['id'];
    
    // Prepare and execute SQL DELETE query
    $sql = "DELETE FROM clients WHERE client_id = $client_id";
    if ($conn->query($sql) === TRUE) {
        $_SESSION["success"] = "Client deleted successfully.";
    } else {
        $_SESSION["error"] = "Error deleting client: " . $conn->error;
    }
    
    // Redirect back to the list of projects
    header("Location: clients.php"); // Change 'index.php' to the appropriate URL
    exit();
} else {
    $_SESSION["error"] = "Invalid project ID.";
    header("Location: clients.php"); // Change 'index.php' to the appropriate URL
    exit();
}
?>
