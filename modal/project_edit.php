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
    <?php require('includes/header.php');?>
    <div class="container" style="padding-top: 80px;">
    <?php require('includes/pwd_check.php');?>
    
        <div class="container">
            
            <?php if(isset($_SESSION["error"]) && $_SESSION["error"] != ""){?>
                <div class="alert alert-danger">
                    <ul>
                        <?= $_SESSION["error"]; ?>
                    </ul>
                    
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
            <div class="card bg-light text-dark">
                <div class="card-header">
                    <a href="projects.php" class="btn btn-primary">Back</a>
                    <h2>Edit Patient</h2>
                </div>
                <div class="card-body">
                    <?php
                        $project = array();
                        $project_id = '';

                        if(isset($_GET["id"])){
                            $project_id = $_GET["id"];

                            $sql = "SELECT * FROM projects 
                            left join clients ON clients.client_id = projects.client_id
                            left join  employees ON employees.employee_id = projects.employee_id  WHERE project_id = '$project_id' " ; 
                            $result = $conn->query($sql);
                            
                            if ($result->num_rows > 0) {
                                $project = $result->fetch_assoc();
                            }


                        }else{
                            echo '<script>window.history.back();</script>';
                        }



                    ?>
                    <form method="post" action="project_update.php">
                        <input type="hidden" name="project_id" value="<?= $project_id; ?>"/>
                        <div class="row mb-2">
                            <div class="row">
                            <!-- <div class="col mb-2">
                             <label for="employee_id">Assign to</label>
                                <select name="employee_id" class="form-control" id="employee_id">
                                    <option value="">Select Employee</option>
                                    <?php 
                                        $sql = "SELECT * FROM employees "; // Adjust the SQL query as needed
                                                    $result = $conn->query($sql);
                                    
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {?>
                                        <option value="<?= $row["employee_id"];?>"<?= ($project["employee_id"] == $row["employee_id"])? 'selected' : '';  ?>><?= $row["first_name"].' '.$row["last_name"]; ?></option>
                                        <?php 
                                                }
                                            }
                                        ?>
                                    </select>
                            </div> -->
                            </div>
                            <div class="col">
                                <label for="project">Patient</label>
                                <input type="text" value="<?= $project["project_name"];?>" placeholder="Project Name" class="form-control" name="project_name" id="project_name" />
                            </div>
                            <!-- <div class="col">
                                <label for="rate">Project</label>
                                <input type="text" value="<?= $project["rate"];?>" placeholder="Rate" class="form-control" name="rate" id="rate" />
                            </div> -->
                            <!-- <div class="row "> -->
                            <div class="col mb-2">
                             <label for="client_id">Area</label>
                                <select name="client_id" class="form-control" id="client_id">
                                    <option value="">Select Area</option>
                                    <?php 
                                        $sql = "SELECT * FROM clients "; // Adjust the SQL query as needed
                                                    $result = $conn->query($sql);
                                    
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {?>
                                        <option value="<?= $row["client_id"];?>"<?= ($project["client_id"] == $row["client_id"])? 'selected' : '';  ?>><?= $row["client_name"]; ?></option>
                                        <?php 
                                                }
                                            }
                                        ?>
                                    </select>
                            </div>
                    <div class="row ">
                            <div class="col">
                                <label for="start_date">Start Date</label>
                                <input type="date"  value="<?= $project["start_date"];?>" placeholder="start date" class="form-control" name="start_date" id="start_date" />
                            </div>
                        <!-- </div> -->
                        
                        <div class="col">
                                <label for="end_date">End Date</label>
                                <input type="date"  value="<?= $project["end_date"];?>" placeholder="end date" class="form-control" name="end_date" id="end_date" />
                            </div>        
                        </div>
                        
                        <div class="col-md-6  mb-2">
                                        <label for="status">Status</label>
                                            <select name="status_id" class="form-control" id="status">
                                                <option value="">Status</option>
                                                <?php 
                                                    $sql = "SELECT * FROM `status` "; // Adjust the SQL query as needed
                                                    $result = $conn->query($sql);
                                                    
                                                    if ($result->num_rows > 0) {
                                                        while ($row = $result->fetch_assoc()) {?>
                                                        <option value="<?= $row["status_id"];?>"<?= ($project["status_id"] == $row["status_id"])? 'selected' : '';  ?>><?= $row["status"]; ?></option>
                                                        <?php 
                                                                }
                                                            }
                                                ?>
                                            </select>
                                        </div>
                        <div class="row mt-2">
                            <div class="col">
                                <button type="submit" class="btn btn-primary form-control">UPDATE </button>
                            </div>
                            
                    </div>
                        </div>
                    </form>
                </div>
            </div>
           
         </div>
    </div>
   
</body>
</html>