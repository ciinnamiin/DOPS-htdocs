<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    include_once('includes/session.php');

    $project_name = $_POST["project_name"];
    $start_date = $_POST["start_date"];
    $end_date = $_POST["end_date"];
    $client_id = $_POST["client_id"];
    $status_id = $_POST["status_id"];
    
  
        $sql = "INSERT INTO projects (project_name, `start_date`, `end_date`, client_id, status_id) 
        VALUES('$project_name','$start_date', '$end_date','$client_id',' $status_id')";

        if ($conn->query($sql) === TRUE) {
            $_SESSION["success"] = "Project added successfully!";
            echo '<script>window.location.href = "projects.php" </script>';
        }else{
            $_SESSION["error"] = "Error inserting project!";
            echo '<script>window.history.back();</script>';
        }   
    
}
