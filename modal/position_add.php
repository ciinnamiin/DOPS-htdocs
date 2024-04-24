<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    include_once('includes/session.php');

    $position = $_POST["position"];
    

        $sql = "INSERT INTO positions (position) 
        VALUES('$position ')";

        if ($conn->query($sql) === TRUE) {
            $_SESSION["success"] = "Position added successfully!";
            echo '<script>window.location.href = "position.php" </script>';
        }else{
            $_SESSION["error"] = "Error inserting Position!";
            echo '<script>window.history.back();</script>';
        }   
   
}
