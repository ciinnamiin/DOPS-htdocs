<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    include_once('includes/session.php');

    $user_id = $_SESSION["User"]["employee_id"];
    //$user_id = $_POST["User"];
    $description = mysqli_real_escape_string($conn, $_POST["description"]);
    $proj_id = $_POST["project_id"];
    $project = POSTProject($proj_id);
    $date = $_POST["date"];
    $start = $_POST["start"];
    $end = $_POST["end"];
    $hours = number_format(timeToDecimal($end) - timeToDecimal($start), 2);
    // $hours = 1;
    $start_date = get_start($proj_id);
    $end_date = get_end($proj_id);
    
    if($date >= $start_date && $date <= $end_date){
        $sql = "INSERT INTO tasks (`task_name`, `project_id`) VALUES('$description', '$proj_id')";
        if ($conn->query($sql) === TRUE) {
            $task_id = $conn->insert_id;

            $sql2 = "INSERT INTO timesheets (`employee_id`, `task_id`, `start`, `end`, `date`, `hours`) 
                VALUES ('$user_id', '$task_id', '$start', '$end', '$date', '$hours')";
            if ($conn->query($sql2) === TRUE) {
                $timesheet_id = $conn->insert_id; // POST the ID of the newly inserted row
                $total = get_total($user_id);
                $response = array(
                    "id" => $timesheet_id,
                    "description" => $description,
                    "project" => $project,
                    "date" => $date,
                    "start" => $start,
                    "end" => $end,
                    "hours" => $hours,
                    "total"=> $total
                );
                
                header('Content-Type: application/json');
                echo json_encode($response);
                // that was why
                // header("Location: ".$_SERVER['PHP_SELF']."?message=".urlencode($successMessage));
            }else{
                header('Content-Type: application/json');
                echo json_encode(array("error"=>"Error inserting timesheet!"));
            }

        }else{
            header('Content-Type: application/json');
            echo json_encode(array("error"=> "Error inserting task!"));
        }   
    }else{
        header('Content-Type: application/json');
        echo json_encode(array("error"=> "Task date must be between '$start_date' and '$end_date' !"));
    }
   
}
function get_total($user_id){
    global $conn;

    $sql = "SELECT SUM(`hours`) as total 
    FROM timesheets
    where employee_id = '$user_id' AND active = 0 "; // Adjust the SQL query as needed
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
       $row = $result->fetch_assoc();

       return $row["total"];
    }else{
        return 0;
    }
}

function POSTProject($proj_id){
    global $conn;

    $sql = "SELECT projects.project_name 
    FROM projects
    where project_id = '$proj_id' "; // Adjust the SQL query as needed
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
       $row = $result->fetch_assoc();

       return $row["project_name"];
    }else{
        return "";
    }
}
function get_start($proj_id){
    global $conn;

    $sql = "SELECT `start_date` 
    FROM projects
    where project_id = '$proj_id' "; // Adjust the SQL query as needed
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
       $row = $result->fetch_assoc();

       return $row["start_date"];
    }else{
        return "";
    }
}

function get_end($proj_id){
    global $conn;

    $sql = "SELECT `end_date` 
    FROM projects
    where project_id = '$proj_id' "; // Adjust the SQL query as needed
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
       $row = $result->fetch_assoc();

       return $row["end_date"];
    }else{
        return "";
    }
}

function timeToDecimal($time) {
    list($hours, $minutes) = explode(':', $time);
    return $hours + ($minutes / 60);
}
?>