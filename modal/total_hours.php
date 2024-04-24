<?php

include_once('includes/session.php');


 // Adjust the SQL query as needed

// Connect to your database (assuming you have a $conn variable)

// Perform your SQL query
$sql = "SELECT SUM(`hours`) as `hours` FROM timesheets WHERE active = 0
";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    
    // Convert the data to JSON and send it as the response
    echo json_encode($data);
} else {
    // No results found
    echo json_encode(array());
}

// Close the database connection
$conn->close();



?>
