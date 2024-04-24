<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    include_once('includes/session.php');

    $client_name = $_POST["client_name"];
    

        $sql = "INSERT INTO clients (client_name) 
        VALUES('$client_name ')";

        if ($conn->query($sql) === TRUE) {
            $_SESSION["success"] = "Client added successfully!";
            echo '<script>window.location.href = "clients.php" </script>';
        }else{
            $_SESSION["error"] = "Error inserting Client!";
            echo '<script>window.history.back();</script>';
        }   
   
}
