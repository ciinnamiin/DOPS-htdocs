<?php

include_once('includes/session.php');


$sql = "SELECT timesheets.*, tasks.task_name, (SELECT SUM(`hours`) FROM timesheets t WHERE t.employee_id = timesheets.employee_id AND t.active = 0) as `total`, projects.project_name FROM timesheets 
left join tasks ON timesheets.task_id = tasks.task_id
left join projects ON projects.project_id = tasks.project_id
where active = '0' 
"; // Adjust the SQL query as needed
$result = $conn->query($sql);

$data = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($data);

?>
