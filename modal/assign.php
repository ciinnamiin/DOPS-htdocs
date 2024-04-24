<?php include_once('includes/session.php'); ?>
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
    <?php $page = 'assign'; ?>
    <?php require('includes/header.php'); ?>
    <div class="container" style="padding-top: 80px;">
        <?php require('includes/pwd_check.php'); ?>
        <div class="card mb-3">
            <div class="card-body">
                <button data-bs-toggle="collapse" data-bs-target="#addnewForm" class="btn btn-primary">
                    <i class="fa fa-plus"></i> New Patient Assign
                </button>
                <div id="addnewForm" class="collapse">
                    <form method="post" action="assign_add.php">
                        <input type="hidden" name="user_id" value="<?= $_SESSION["User"]["employee_id"]; ?>" />
                        <div class="row">
                            <!-- Dropdown for selecting project -->
                            <div class="col mb-2">
                                <label for="project_name">Patient</label>
                                <select name="project_id" class="" id="project_name">
                                    <option value="">Select Patient</option>
                                    <?php
                                    $sql = "SELECT * FROM projects  "; // Adjust the SQL query as needed
                                    $result = $conn->query($sql);

                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            ?>
                                            <option value="<?= $row["project_id"] ?>"><?= $row["project_name"]; ?></option>
                                        <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>

                            <!-- Dropdown for selecting Employee -->
                            <div class="col mb-2">
                                <label for="first_name">Health Worker</label>
                                <select name="employee_id[]" class="form-control" id="first_name" multiple>
                                    <!-- <option value="">Select Employee</option> -->
                                    <?php
                                    $sql = "SELECT * FROM employees "; // Adjust the SQL query as needed
                                    $result = $conn->query($sql);

                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            ?>
                                            <option value="<?= $row["employee_id"] ?>"><?= $row["first_name"]; ?></option>
                                        <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col">
                                <button type="submit" class="btn btn-primary form-control" id="submitTasks">Assign</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-2">
                        <a class="btn btn-primary" href="projects.php"><i class="fa fa-arrow-left"></i> Back to patients</a>
                    </div>
                    <div class="col-md-6">
                        <h2>Assigned Patients</h2>
                    </div>
                   
                </div>
            </div>
            <div class="card-body">
                <?php if (isset($_SESSION["error"]) && $_SESSION["error"] != "") { ?>
                    <div class="alert alert-danger">
                        <?= $_SESSION["error"]; ?>
                    </div>
                <?php
                    $_SESSION["error"] = "";
                } ?>
                <?php if (isset($_SESSION["success"]) && $_SESSION["success"] != "") { ?>
                    <div class="alert alert-success">
                        <?= $_SESSION["success"]; ?>
                    </div>
                <?php
                    $_SESSION["success"] = "";
                } ?>
                    <div class="card-body table-responsive">
                <input type="text" id="searchInput" class="form-control" onkeyup="searchProjects()" placeholder="Search Area Names">
                <br>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Area</th>
                            <th>Patients</th>
                            <th>Health Worker</th>
                            <!-- <th>Rate</th> -->
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="activeTableBody">
                        <?php

                        $sql = "SELECT * FROM project_users
                                LEFT JOIN projects ON project_users.project_id = projects.project_id
                                LEFT JOIN clients ON projects.client_id = clients.client_id
                                LEFT JOIN employees ON project_users.employee_id = employees.employee_id
                                LEFT JOIN employee_project_rate ON employee_project_rate.employee_id = employees.employee_id ORDER BY `client_name`
                                ";
                        $result = $conn->query($sql);

                        $data = array();

                        if ($result->num_rows > 0) {
                            $i = 0;
                            while ($row = $result->fetch_assoc()) {
                                $i++;
                                ?>
                                <tr>
                                    <td><?= $row["client_name"]; ?></td>
                                    <td><?= $row["project_name"]; ?></td>
                                    <td><?= $row["first_name"] . ' ' . $row['last_name']; ?></td>
                                    <!-- <td>R <?= ($row["rate"] !== null) ? $row["rate"] : '850'; ?></td> -->
                                    <td>
                                        <a href="assign_edit.php?id=<?= $row["id"]; ?>" class="btn btn-sm btn-primary">Edit</a>
                                        <a href="assign_delete.php?id=<?= $row["id"]; ?>" class="btn btn-sm btn-danger">Delete</a>
                                    </td>
                                </tr>
                        <?php
                            }
                        } else {
                            echo '<tr><td colspan="5">No data..</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php require('includes/footer.php'); ?>

    <!-- JavaScript function to perform the search -->
    <script>
        function searchProjects() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("searchInput");
            filter = input.value.toUpperCase();
            table = document.querySelector("table");
            tr = table.getElementsByTagName("tr");

            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[1]; // Adjust the column index to match the Project column
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
        
        var select_box_element = document.querySelector('#project_name');
        dselect(select_box_element, {
          search:true
        });

        
    </script>
</body>
</html>
