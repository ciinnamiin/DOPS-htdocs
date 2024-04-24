<?php
// $servername = "sql57.jnb1.host-h.net";
// $dbname = "pgaarvtyag_db5";
// $username = "pgaarvtyag_5";
// $password = "cVTVnmJi9tkzv9PZF3y8";

$servername = "localhost";
$dbname = "timesheets";
$username = "root";
$password = "";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>