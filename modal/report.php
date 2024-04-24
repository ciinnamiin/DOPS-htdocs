<?php
include_once('includes/session.php');
include_once('includes/db.php');
if (isset($_GET['project_id'])){
    $id = $_GET['id'];

    $delete= mysqli_query($conn, "DELETE from `projects` where project_id = '$id'");
}

if (isset($_GET['export_csv'])) {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="report.csv"');

    $output = fopen('php://output', 'w');

    // Get the selected date range and group by category
    $fromDate = isset($_GET["start_date"]) ? $_GET["start_date"] : "";
    $toDate = isset($_GET["end_date"]) ? $_GET["end_date"] : "";
    $groupByCategory = isset($_GET["group_by"]) ? ucfirst($_GET["group_by"]) : "";
    // $select_name =  isset($_GET["group_by_name"]) ? $_GET["group_by_name"] : "";

    // CSV title row
    // $titleRow = array("Category: $groupByCategory", "From: $fromDate", "To: $toDate");
    $titleRow = array("From: ", $fromDate, " ","To: ", $toDate);
    $titleRow1 = array("Category: ", $groupByCategory);

    fputcsv($output, $titleRow);
    fputcsv($output, $titleRow1); // Add title row

    $header = array(
        'Date',
        'Health Worker',
        'Position',
        'Patient',
        'Area',
        'Patient Details',
       
    );

    fputcsv($output, $header);

    $q = ""; // Existing query conditions

    // Construct the query to fetch data
    $sql = "SELECT * FROM timesheets 
            LEFT JOIN tasks ON timesheets.task_id = tasks.task_id
            LEFT JOIN employees ON timesheets.employee_id = employees.employee_id
            LEFT JOIN projects ON tasks.project_id = projects.project_id
            LEFT JOIN clients ON projects.client_id = clients.client_id
            LEFT JOIN positions ON employees.position_id = positions.position_id
            WHERE timesheet_id > 0 $q ";

    $result = $conn->query($sql);

    while ($row = $result->fetch_assoc()) {
        $csv_row = array(
            $row["date"],
            $row["first_name"] . ' ' . $row["last_name"],
            $row["position"],
            $row["project_name"],
            $row["client_name"],
            $row["task_name"],
           
        );
        fputcsv($output, $csv_row);
    }

    fclose($output);
    exit();
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report</title>
    <link href="bootstrap.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/@jarstone/dselect/dist/js/dselect.js"></script>
    <link rel="stylesheet" href="styles.css">

    <!-- Bootstrap Core Css -->
    <!-- <link href="b2/plugins/bootstrap/css/bootstrap.css" rel="stylesheet"> -->
    <!-- Custom Css -->
    <link href="b2/css/style.css" rel="stylesheet">

    <!-- JQuery DataTable Css -->
    <link href="b2/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <!-- <link href="b2/css/themes/all-themes.css" rel="stylesheet" /> -->
</head>
<body>
    
<?php
        $page= 'report';
    ?>
    <?php require('includes/header.php');?>
    <div class="container" style="padding-top: 80px;">
    <?php require('includes/pwd_check.php');?>
           <div class="container">
            <div class="card mb-3">
                <div class="card-body">
                    <!-- <button data-bs-toggle="collapse" data-bs-target="#addnewForm" class="btn btn-primary">Get Report</button> -->
                    <div id="addnewForm" class="">
                        <form method="GET">
                                    <!-- <input type="hidde" name="project_id" value="<?= $project_id; ?>"/> -->
                                    <div class="row">
                                        <div class="col mb-2"><br>
                                        <label for="from_date">Select Date : From</label>
                                        <input type="date" value="<?= (isset($_GET["start_date"]))? $_GET["start_date"] : '' ?>" class="form-control" name="start_date" id="start"  placeholder="From"/>
                                        </div>
                                        <div class="col mb-2"><br>
                                        <label for="to_date">Select Date : To</label>
                                        <input type="date" value="<?= (isset($_GET["end_date"]))? $_GET["end_date"] : '' ?>" class="form-control" name="end_date" id="end" placeholder="To"/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col mb-2">
                                        <label for="client_name">Group By</label>
                                            <select class="form-control" name="group_by" id="group_by" required onchange="this.form.submit()">
                                                    <option value="">Select Category...</option>
                                                    <!-- <option value="client">Client</option> -->
                                                    <option value="project" <?= (isset($_GET["group_by"]) && $_GET["group_by"] == "project")? 'selected' : '' ?> >Patient</option>
                                                    <option value="employee" <?= (isset($_GET["group_by"]) && $_GET["group_by"] == "employee")? 'selected' : '' ?> >Health Worker</option>
                                                    <option value="client" <?= (isset($_GET["group_by"]) && $_GET["group_by"] == "client")? 'selected' : '' ?> >Area</option>
                                                    <option value="all_details" <?= (isset($_GET["group_by"]) && $_GET["group_by"] == "all_details")? 'selected' : '' ?> >All Details</option>
                                             </select>
                                        </div>
                                        <div class="col mb-2">
                                        <label for="group_by_name">Select Name</label>
                                            <select name="group_by_name" class="" id="group_by_name" onchange="this.form.submit()">
                                                <option value="">Select </option>
                                                <?php 
                                                    if(isset($_GET["group_by"])){
                                                        $group_by = $_GET["group_by"];
                                                        switch ($group_by){
                                                            case "employee":
                                                                $sql = "SELECT * FROM employees"; // Adjust the SQL query as needed
                                                            $result = $conn->query($sql);
                                                            
                                                            if ($result->num_rows > 0) {
                                                                while ($row = $result->fetch_assoc()) {?>
                                                                    <option value="<?= $row["employee_id"] ?>" <?= (isset($_GET["group_by_name"]) && $_GET["group_by_name"] == $row["employee_id"])? 'selected' : ''; ?> >
                                                                    <?= $row["first_name"] .' '.$row["last_name"]; ?>
                                                                </option>
                                                        <?php  }
                                                            }

                                                                break;
                                                            case "project":
                                                                $sql = "SELECT * FROM projects ORDER BY project_name ASC"; // Adjust the SQL query as needed
                                                                $result = $conn->query($sql);
                                                                if ($result->num_rows > 0) {
                                                                    while ($row = $result->fetch_assoc()) {?>
                                                                        <option value="<?= $row["project_id"] ?>" <?= (isset($_GET["group_by_name"]) && $_GET["group_by_name"] == $row["project_id"])? 'selected' : ''; ?>><?= $row["project_name"]; ?></option>
                                                            <?php  }
                                                                }
                                                                break;
                                                            case "client":
                                                                $sql = "SELECT * FROM clients ORDER BY client_name ASC";

                                                                $result = $conn->query($sql);
                                                                if ($result->num_rows > 0) {
                                                                    while ($row = $result->fetch_assoc()) {?>
                                                                        <option value="<?= $row["client_id"] ?>" <?= (isset($_GET["group_by_name"]) && $_GET["group_by_name"] == $row["client_id"])? 'selected' : ''; ?>><?= $row["client_name"]; ?></option>
                                                            <?php  }
                                                                }
                                                                    break;
                                                            default: 

                                                                                                                        
                                                        }
                                                    }
                                                    
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                        <!-- <div class="col">
                                            <label for="project">Project</label>
                                            <input type="text" class="form-control" id="project" name="project_name"  required>
                                        </div>
                                        
                                   
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="start">Start</label>
                                            <input type="date" class="form-control" name="start_date" id="start"/>
                                        </div>
                                        <div class="col">
                                            <label for="end">End</label>
                                            <input type="date" class="form-control" name="end_date" id="end"/>
                                        </div>
                                    </div> -->
                                    
                                    <!-- <div class="row">
                                        <div class="col">
                                        <textarea class="form-control" placeholder="Task Description" name="description" required></textarea>
                                        </div>
                                    </div> -->
                                    <div class="row mt-2">
                                        <div class="col">
                                            <button type="submit" class="btn btn-primary form-control" id="submitTasks">Generate Report</button>
                                        </div>
                                        <!-- <div class="col">
                                        <button type="submit" class="btn btn-primary form-control" id="submitTasks" name="export_csv">Export as CSV</button>
                                        </div> -->
                                        
                                    </div>
                               
                        </form>
                    </div>
                </div>
            </div>
        
            <div class="card">
            <div class="card-header">
                <h2>Reports</h2>
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
            </div>
            <div class="card-body table-responsive">
               <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Employee</th>
                        <th>Position</th>
                        <th>Area</th>
                        <th>Patient</th>
                        <th>Patient Details</th>
                        <!-- <th>Hours Worked</th> -->
                        <!-- <th>Rate</th>
                        <th>Cost</th> -->
                    </tr>
                </thead>
                <!-- <tfoot>
                    <th>Date</th>
                    <th>Employee</th>
                    <th>Position</th>
                    <th>Project</th>
                    <th>Client</th>
                    <th>Task Description</th>
                    <th>Hours Worked</th>
                    <th>Rate</th>
                </tfoot> -->
                <tbody>
                    <?php 
                        $q = "";

                        if(isset($_GET["group_by_name"]) && $_GET["group_by_name"] != ''){
                            $group_by = $_GET["group_by_name"];
                           
                            // echo 'group_name is set!';
                            switch($_GET["group_by"]){
                                case "employee":
                                    $q .= " AND timesheets.employee_id = '$group_by' ";
                                    // echo 'employee!';
                                    break;
                                case "client":
                                    $q .= " AND projects.client_id = '$group_by' ";
                                    break;
                                case "project":
                                    $q .= " AND tasks.project_id = '$group_by' ";
                                    break;
                                default: 
                            }                            
                        }



                        if(isset($_GET["start_date"]) && $_GET["start_date"] != ''){
                            $q .= " AND timesheets.date >=  DATE('".$_GET["start_date"]."')";
                        }
                        if(isset($_GET["end_date"]) && $_GET["end_date"] != ''){
                            $q .= " AND timesheets.date <=  DATE('".$_GET["end_date"]."')";
                        }

                        $sql = "SELECT *, 
                        (select rate from project_users where project_id = tasks.project_id  and employee_id = timesheets.employee_id) as rate FROM timesheets 
                        LEFT JOIN tasks ON timesheets.task_id = tasks.task_id
                        LEFT JOIN employees ON timesheets.employee_id = employees.employee_id
                        LEFT JOIN projects ON tasks.project_id = projects.project_id
                        LEFT JOIN clients ON projects.client_id = clients.client_id
                        LEFT JOIN positions ON employees.position_id = positions.position_id
                        WHERE timesheet_id > 0 and active = 1 $q"; // Adjust the SQL query as needed

                        // echo 'SQL: '. $sql;
                        $result = $conn->query($sql);
                        
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {?>
                            <tr>
                                <td><?= $row["date"];?></td>
                                <td><?= $row["first_name"].' '.$row["last_name"];?></td>
                                <td><?= $row["position"];?></td>
                                <td><?= $row["client_name"];?></td>
                                <td><?= $row["project_name"];?></td>
                                <td><?= $row["task_name"];?></td>
                                <!-- <td><?= $row["hours"];?></td>
                                <td>R <?= ($row["rate"] !== null) ? $row["rate"] : 850; ?></td>

                                <td>R<?= number_format($row["rate"] * $row["hours"], 2); ?></td> -->
                            </tr>
                            
                    <?php }
                        }else{ ?>
                        <tr>
                            <td colspan="8">Nothing found...</td>
                        </tr>
                    <?php }?>
                </tbody>
               </table>
            </div>
         </div>
    </div>
    <?php require('includes/footer.php');?>
    <!-- <script src="script.js"></script> -->
    <script>
        var select_box_element = document.querySelector('#group_by_name');
        dselect(select_box_element, {
          search:true
        });
    </script>

    <!-- Jquery Core Js -->
    <script src="b2/plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="b2/plugins/bootstrap/js/bootstrap.js"></script>

   <!-- Jquery DataTable Plugin Js -->
   <script src="b2/plugins/jquery-datatable/jquery.dataTables.js"></script>
    <script src="b2/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
    <script src="b2/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js"></script>
    <script src="b2/plugins/jquery-datatable/extensions/export/buttons.flash.min.js"></script>
    <script src="b2/plugins/jquery-datatable/extensions/export/jszip.min.js"></script>
    <script src="b2/plugins/jquery-datatable/extensions/export/pdfmake.min.js"></script>
    <script src="b2/plugins/jquery-datatable/extensions/export/vfs_fonts.js"></script>
    <script src="b2/plugins/jquery-datatable/extensions/export/buttons.html5.min.js"></script>
    <script src="b2/plugins/jquery-datatable/extensions/export/buttons.print.min.js"></script>

    <!-- Custom Js -->
    <!-- <script src="b2/js/admin.js"></script> -->
    <script src="b2/js/pages/tables/jquery-datatable.js"></script>

    <!-- Demo Js -->
    <!-- <script src="b2/js/demo.js"></script> -->
</body>
</html>
