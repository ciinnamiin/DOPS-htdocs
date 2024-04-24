<?php
include_once('includes/session.php');
include_once('includes/db.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modal</title> 
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
                    <a href="assign.php" class="btn btn-primary">Back</a>
                    <h2>Edit Rate</h2>
                </div>
                <div class="card-body">
                    <?php

                        $rate_id = $project_id = $employee_id = $rate = '';
                        
                        $rate = array();
                        $rate_id = '';

                        if(isset($_GET["id"])){
                            $rate_id = $_GET["id"];
                        
                            $sql = "SELECT * FROM project_users
                                LEFT JOIN projects ON project_users.project_id = projects.project_id
                                LEFT JOIN clients ON projects.client_id = clients.client_id
                                LEFT JOIN employees ON project_users.employee_id = employees.employee_id
                                LEFT JOIN employee_project_rate ON employee_project_rate.employee_id = employee_project_rate.rate_id
                                ";
                            $result = $conn->query($sql);
                            
                            if ($result->num_rows > 0) {
                                $rate = $result->fetch_assoc();
                            }
                        } else {
                            echo '<script>window.history.back();</script>';
                        }
                        

                    ?>
                    <form method="post" action="rate_update.php">
                    <input type="hidden" name="rate_id" value="<?= $rate_id; ?>"/>
                        <div class="row mb-2">
                            <div class="col">
                                <label for="rate">Rate</label><br>
                                <input type="text" value="<?= $rate["rate"];?>" placeholder="Rate" class="form-control" name="rate" id="rate" />
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col">
                                <button type="submit" class="btn btn-primary form-control">UPDATE </button>
                            </div>                                
                        </div>
                    </form>
                </div>
            </div>
           
         </div>
    </div>
   
</body>
</html>
