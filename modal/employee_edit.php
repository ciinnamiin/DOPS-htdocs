<?php
include_once('includes/session.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Timesheet</title>
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
                    <a href="employees.php" class="btn btn-primary">Back</a>
                    <h2>Edit Health Worker Details</h2>
                </div>
                <div class="card-body">
                    <?php
                        $employee = array();
                        $employee_id = '';

                        if(isset($_GET["id"])){
                            $employee_id = $_GET["id"];

                            $sql = "SELECT * FROM employees 
                            left join positions ON positions.position_id = employees.position_id 
                            WHERE employee_id = '$employee_id' "; 
                            $result = $conn->query($sql);
                            
                            if ($result->num_rows > 0) {
                                $employee = $result->fetch_assoc();
                            }


                        }else{
                            echo '<script>window.history.back();</script>';
                        }



                    ?>
                    <form method="post" action="employee_update.php" id="myForm">
                        <input type="hidden" name="user_id" value="<?= $employee_id; ?>"/>
                        <div class="row mb-2">
                            <div class="col">
                                <label for="first_name">First Name</label>
                                <input type="text" value="<?= $employee["first_name"];?>" placeholder="First Name" class="form-control" name="first_name" id="first_name" />
                            </div>
                            <div class="col">
                                <label for="last_name">Last Name</label>
                                <input type="text"  value="<?= $employee["last_name"];?>" placeholder="Last Name" class="form-control" name="last_name" id="last_name" />
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col mb-2">
                             <label for="position_id">Position</label>
                                <select name="position_id" class="form-control" id="position_id">
                                    <option value="">Select Position</option>
                                    <?php 
                                        $sql = "SELECT * FROM positions ORDER BY position ASC"; // Adjust the SQL query as needed
                                                    $result = $conn->query($sql);
                                    
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {?>
                                        <option value="<?= $row["position_id"];?>"<?= ($employee["position_id"] == $row["position_id"])? 'selected' : '';  ?>><?= $row["position"]; ?></option>
                                        <?php 
                                                }
                                            }
                                        ?>
                                    </select>
                            </div>
                            <div class="col">
                                <label for="email">Email</label>
                                <input type="text" value="<?= $employee["email"];?>" placeholder="Email" class="form-control" id="email" name="email" />
                            </div>           
                        </div>
                        <div class="row mb-2">
                            <div class="col">
                                <label for="password">Enter New Password</label>
                                <input type="password" placeholder="Password (Leave blank to remain unchanged)" class="form-control" name="password" id="password" />
                            </div>
                            <div class="col">
                                <label for="confirm_password">Confirm New Password</label>
                                <input type="password" placeholder="Confirm Password" class="form-control" name="confirm_password" id="confirm_password" />
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col">
                                <label for="is_admin">Is Admin</label>
                                <input type="checkbox" <?= ($employee["is_admin"] == 1)? 'checked' : '';  ?> name="is_admin" id="is_admin"/>
                            </div>
                            
                        </div>
                        <div class="row mt-2">
                            <div class="col">
                            <button type="submit" class="btn btn-primary form-control">UPDATE </button>
                            </div>
                            <div class="col">
                            <center><button type="button" id="submitButton" class="btn btn-primary">Resend Email</button></center>
                            </div>                                
                        </div>
                    </form>
                </div>
            </div>
           
         </div>
    </div>
   


    <script>
        document.getElementById('submitButton').addEventListener('click', function() {
            submitToPages();
        });

        function submitToPages() {
            document.getElementById('myForm').action = 'employee_update.php';
            document.getElementById('myForm').submit();

            document.getElementById('myForm').action = 'employee_add.php';
            document.getElementById('myForm').submit();
        }
    </script>

</body>
</html>
