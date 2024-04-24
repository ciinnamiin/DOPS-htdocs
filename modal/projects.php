<?php
include_once('includes/session.php');
include_once('includes/db.php');
if (isset($_GET['project_id'])){
    $id = $_GET['id'];

    $delete = mysqli_query($conn, "DELETE from `projects` where project_id = '$id'");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DOPS</title>
    <link href="bootstrap.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/@jarstone/dselect/dist/js/dselect.js"></script>
    <link rel="stylesheet" href="styles.css">

</head>
<body>
<?php
        $page= 'projects';
    ?>
    <?php require('includes/header.php');?>
    <div class="container" style="padding-top: 80px;">
    <?php require('includes/pwd_check.php');?>
    
        <div class="container">
            <div class="card mb-3">
                <div class="card-body">
                    <button data-bs-toggle="collapse" data-bs-target="#addnewForm" class="btn btn-primary">Add New</button>
                    <div id="addnewForm" class="collapse">
                        <form id="insertForm" method="post" action="project_add.php">
                                    <input type="hidden" name="project_id" value="<?= $project_id; ?>"/>
                                    <div class="row">
                                        <div class="col mb-2"><br>
                                        <label for="client_name">Area</label>
                                            <select name="client_id" class="" id="client_name">
                                                <option value="">Select Area</option>
                                                <?php 
                                                    $sql = "SELECT * FROM clients"; // Adjust the SQL query as needed
                                                    $result = $conn->query($sql);
                                                    
                                                    if ($result->num_rows > 0) {
                                                        while ($row = $result->fetch_assoc()) {?>
                                                        <option value="<?= $row["client_id"] ?>"><?= $row["client_name"]; ?></option>
                                                <?php 
                                                        }
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col"><br>
                                            <label for="project">Patient</label>
                                            <input type="text" class="form-control" id="project" name="project_name"  required>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="start">Start</label>
                                            <input type="date" class="form-control" name="start_date" id="start"/>
                                        </div>
                                        <div class="col">
                                            <label for="end">End</label>
                                            <input type="date" class "form-control" name="end_date" id="end"/>
                                        </div>
                                    </div>
                                    <div class="col-md-6  mb-2">
                                        <label for="status">Status</label>
                                            <select name="status_id" class="form-control" id="status">
                                                <option value="">Status</option>
                                                <?php 
                                                    $sql = "SELECT * FROM status"; // Adjust the SQL query as needed
                                                    $result = $conn->query($sql);
                                                    
                                                    if ($result->num_rows > 0) {
                                                        while ($row = $result->fetch_assoc()) {?>
                                                        <option value="<?= $row["status_id"] ?>"><?= $row["status"]; ?></option>
                                                <?php 
                                                        }
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    <div class="row mt-2">
                                        <div class="col">
                                            <button type="submit" class="btn btn-primary form-control" id="submitTasks">Submit</button>
                                        </div>
                                    </div>
                        </form>
                    </div>
                </div>
            </div>
        
            <div class="card">
            <div class="card-header">
                <h2 class="float-start">List of Patients</h2>
                <div class="float-end">
                    <a href="assign.php" class="btn btn-primary">Assign To Health Worker</a>
                </div>
                <?php if(isset($_SESSION["error"]) && $_SESSION["error"] != ""){?>
                    <div class="alert alert-danger">
                        <?= $_SESSION["error"]; ?>
                    </div>
                <?php
                    $_SESSION["error"] = "";
                }?>
                <?php if(isset($_SESSION["success"]) && $_SESSION["success"] != ""){?>
                    <div class="alert alert-success col-md-6">
                        <?= $_SESSION["success"]; ?>
                    </div>
                <?php
                    $_SESSION["success"] = "";
                }?>
            </div>
            <div class="card-body table-responsive">
                <input type="text" id="projectSearch" class="form-control" placeholder="Search Patients">
                <br>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Area</th>
                            <th>Patient</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Assigned To</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="activeTableBody">
                        <?php
                            $sql = "SELECT *, (SELECT COUNT(*) FROM project_users WHERE project_id = projects.project_id) as count FROM projects 
                            left join clients ON clients.client_id = projects.client_id
                            left join `status` ON projects.status_id = status.status_id
                            left join employees ON employees.employee_id = projects.employee_id ORDER BY `client_name`"; 
                            $result = $conn->query($sql);
                            
                            $data = array();
                            
                            if ($result->num_rows > 0) {
                                $i = 0;
                                while ($row = $result->fetch_assoc()) {
                                    $i ++;
                        ?>
                        <tr>
                            <td><?= $row["client_name"]; ?></td>
                            <td><?= $row["project_name"]; ?></td>
                            <td><?= date("Y-M-d", strtotime($row["start_date"])); ?></td>
                            <td><?= date("Y-M-d", strtotime($row["end_date"])); ?></td>
                            <td>
                                <button class="btn btn-default shadow" data-bs-toggle="collapse" data-bs-target="#demo<?= $i;?>">Assigned Employees (<?= $row["count"];?>)</button>

                                <div id="demo<?= $i;?>" class="collapse">
                                    <ul>
                                        <?php
                                            $sql2 = "SELECT * FROM project_users 
                                            LEFT JOIN employees ON project_users.employee_id = employees.employee_id
                                            WHERE project_id = '".$row["project_id"]."' "; 
                                            $result2 = $conn->query($sql2);
                                            if ($result2->num_rows > 0) {
                                                while ($assigned = $result2->fetch_assoc()) {
                                        ?>
                                        <li><?= $assigned["first_name"].' '. $assigned["last_name"]; ?></li>
                                        <?php 
                                                }
                                            }
                                        ?>
                                    </ul>
                                </div>
                            </td>
                            <td><?= $row["status"]; ?></td>
                            <td>
                                <a href="project_edit.php?id=<?= $row["project_id"];?>" class="btn btn-sm btn-primary">Edit</a>
                                <a href="project_delete.php?id=<?= $row["project_id"];?>" class="btn btn-sm btn-danger">Delete</a>
                            </td>
                        </tr>
                        <?php
                                }
                            } else {
                                echo '<tr><td colspan="5">No data..</td></tr>';
                            }
                        ?>
                        <!-- Existing or dynamically populated table rows will go here -->
                    </tbody>
                </table>
            </div>
         </div>
    </div>
    <?php require('includes/footer.php');?>
    <!-- <script src="script.js"></script> -->

    <script>
        var select_box_element = document.querySelector('#client_name');
        dselect(select_box_element, {
          search: true
        });
    </script>

    <script>
        document.getElementById('projectSearch').addEventListener('input', function() {
            const searchValue = this.value.toLowerCase();
            const tableRows = document.querySelectorAll('#activeTableBody tr');

            tableRows.forEach(function(row) {
                const projectTitle = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                if (projectTitle.includes(searchValue)) {
                    row.style.display = 'table-row';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>
