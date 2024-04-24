<?php
include_once('includes/session.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DOPS</title>
    <link href="bootstrap.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="styles.css">

</head>
<body>
<?php
        $page= 'tasks';
    ?>
    <?php require('includes/header.php');?>
    <div class="container" style="padding-top: 80px;">
    <?php require('includes/pwd_check.php');?>
         
         
         <div class="container">
         <div class="card mb-3">
            <div class="card-body">
            <button id="openModal" class="btn btn-primary">Capture Patient</button>
        </div>
         </div>
            <div class="card  mt-3">
            <div class="card-header">
            <h2>List of Captured</h2>
            </div>
            <!-- </div> -->
            <!-- <div class="card"> -->
            <?php if(isset($_SESSION["error"]) && $_SESSION["error"] != ""){?>
                <div class="alert alert-danger">
                    <?= $_SESSION["error"]; ?>
                </div>
            <?php
                 $_SESSION["error"] = "";
            }?>
            <?php if(isset($_SESSION["success"]) && $_SESSION["success"] != ""){?>
                <div class="alert alert-success">
                    <?= $_SESSION["success"]; ?>
                </div>
            <?php
                 $_SESSION["success"] = "";
            }?>
            <div class="card-body table-responsive">
            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <!-- <th>ID</th> -->
                        <th>Area</th>
                        <th>Patient</th>
                        <th>Start</th>
                        <th>End</th>
                        <th style="width: 30%;">Patient Details</th>
                        <th>Capture Date</th>
                        <th>Start</th>
                        <th>End</th>
                        <th>Hours</th>
                        <th>Disease</th>
                        <!-- <th>Cost</th> -->
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="activeTableBody">
                    <?php
                        $employee_id = $_SESSION["User"]["employee_id"];
                        $sql = "SELECT *, (SELECT rate FROM project_users WHERE project_id = tasks.project_id AND employee_id = timesheets.employee_id) as rate FROM timesheets 
                        left join employees ON timesheets.employee_id = employees.employee_id
                        left join tasks ON timesheets.task_id = tasks.task_id
                        left join projects ON tasks.project_id = projects.project_id
                        left join diseases ON tasks.disease_id = diseases.disease_id
                        left join clients ON projects.client_id = clients.client_id
                        where timesheets.active = '1' AND timesheets.employee_id = '$employee_id'
                        GROUP BY timesheet_id"; // Adjust the SQL query as needed
                        $result = $conn->query($sql);
                        
                        $data = array();
                        
                        if ($result->num_rows > 0) {
                            $i = 0;
                            while ($row = $result->fetch_assoc()) {
                                $i ++;
                                ?>
                                <tr>
                                    <!-- <td><?= $i; ?></td> -->
                                    <td><?= $row["client_name"]; ?></td>
                                    <td><?= $row["project_name"]; ?></td>
                                    <td><?= $row["start_date"]; ?></td>
                                    <td><?= $row["end_date"]; ?></td>
                                    <td style="width: 30%;"><?= $row["task_name"]; ?></td>
                                    <td><?= $row["date"]; ?></td>
                                    <td><?= $row["start"]; ?></td>
                                    <td><?= $row["end"]; ?></td>
                                    <td><?= $row["hours"]; ?></td>
                                    <td><?= $row["disease_name"]; ?></td>
                                    <!-- <td>R<?= number_format($row["rate"] * $row["hours"], 2); ?></td> -->
                                    <td>
                                        <a href="task_edit.php?id=<?= $row["task_id"];?>" class="btn btn-sm btn-primary ">Edit</a>
                                        <a href="task_delete.php?id=<?= $row["task_id"];?>" class="btn btn-sm btn-danger ">Delete</a>
                                    </td>
                                </tr>
                    <?php
                            }
                        }else{
                            echo '<tr><td colspan="5">No data..</td></tr>';
                        }
                    ?>
                    <!-- Existing or dynamically populated table rows will go here -->
                </tbody>
            </table>
            </div>
        </div>
    </div>
         
    
        <?php include('includes/task_modal.php');?>
    </div>
    <?php require('includes/footer.php');?>
    <script src="script.js"></script>
    

</body>
</html>
