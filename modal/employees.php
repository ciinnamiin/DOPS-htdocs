<?php
include_once('includes/session.php');
$page_name="employees";
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
        $page= 'employees';
    ?>
    <?php require('includes/header.php');?>
    <div class="container" style="padding-top: 80px;">
    <?php require('includes/pwd_check.php');?>
    
        
        <div class="container">
            <div class="card mb-3">
                <div class="card-body">
                        <button data-bs-toggle="collapse" data-bs-target="#addnewForm" class="btn btn-primary">Add New</button><div></div>
                    <div id="addnewForm" class="collapse">
                    <form method="post" action="employee_add.php" id="employeeForm" onsubmit="submitForm()">
                            <div class="row mb-2">
                                <div class="col"><br>
                                    <label for="first_name">First Name</label>
                                    <input type="text" placeholder="First Name" class="form-control" name="first_name" id="first_name" />
                                </div>
                                <div class="col"><br>
                                    <label for="last_name">Last Name</label>
                                    <input type="text" placeholder="Last Name" class="form-control" name="last_name" id="last_name" />
                                </div>
                            </div>
                            <div class="row ">
                                <div class="col mb-2">
                                <label for="position_id">Position</label>
                                    <select name="position_id" class="" id="position_id">
                                        <option value="">Select Position</option>
                                        <?php 
                                            $sql = "SELECT * FROM positions ORDER BY position ASC"; // Adjust the SQL query as needed
                                                        $result = $conn->query($sql);
                                        
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {?>
                                            <option value="<?= $row["position_id"] ?>"><?= $row["position"]; ?></option>
                                            <?php 
                                                    }
                                                }
                                            ?>
                                        </select>
                                </div>
                                <div class="col">
                                    <label for="email">Email</label>
                                    <input type="text" placeholder="Email" class="form-control" id="email" name="email" autocomplete="off"/>
                                </div>    
                                     
                            </div>
                            <div class="row mb-2">
                                <div class="col">
                                    <label for="password">Password</label>
                                    <input type="password" placeholder="Password" class="form-control" name="password" id="password" autocomplete="off"/>
                                </div>
                                <div class="col">
                                    <label for="confirm_password">Confirm Password</label>
                                    <input type="password" placeholder="Confirm Password" class="form-control" name="confirm_password" id="confirm_password" />
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col"><br>
                                    <label for="is_admin">Is Admin</label>
                                    <input type="checkbox" name="is_admin" id="is_admin"/>
                                </div>
                              
                            <!-- Dropdown for selecting project -->
                                   <!-- <div class="col mb-2">
                                        <label for="project_name">Area</label> </br>
                                            <select name="project_id" class="" id="project_name">
                                                 <option value="">Select Area</option>
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
                            </div> -->
                            <input type="hidden" name="user_id" value="<?= $_SESSION["User"]["employee_id"]; ?>" />
                       
                            <div class="row mt-2">
                                <div class="col">
                                    <button type="submit" class="btn btn-primary form-control">Submit </button>
                                </div>                                
                            </div>
                        </form>
                    </div>
                </div>
            </div>
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
            <div class="card">
                <div class="card-header">
                    <h2>List of Health Workers</h2>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <!-- <th>ID</th> -->
                                <th>Name</th>
                                <th>Position</th>
                                <th>Email</th>
                                <th>Is Admin</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="activeTableBody">
                            <?php

                                $sql = "SELECT * FROM employees 
                                left join positions ON positions.position_id = employees.position_id ORDER BY `first_name`"; 
                                $result = $conn->query($sql);
                                
                                $data = array();
                                
                                if ($result->num_rows > 0) {
                                    $i = 0;
                                    while ($row = $result->fetch_assoc()) {
                                        $i ++;
                                        ?>
                                        <tr>
                                            <!-- <td><?= $i; ?></td> -->
                                            <td><?= $row["first_name"]. ' '.$row["last_name"]; ?></td>
                                            <td><?= $row["position"]; ?></td>
                                            <td><?= $row["email"]; ?></td>
                                            <td><?= ($row["is_admin"])? ' <i class="fa fa-circle-check text-primary"></i>' : ' <i class="fa fa-circle text-default"></i>'; ?></td>
                                            <td>
                                                <a href="employee_edit.php?id=<?= $row["employee_id"];?>" class="btn btn-sm btn-primary">Edit</a>
                                                <a href="employee_delete.php?id=<?= $row["employee_id"];?>" class="btn btn-sm btn-danger">Delete</a>
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
    </div>
    <?php require('includes/footer.php');?>
    <script>
    function submitForm() {
        // Add any form validation here if needed

        // Redirect to the desired page (in this case, 'assign.php')
        window.location.href = 'assign.php';
    }

    var select_box_element = document.querySelector('#position_id');
    dselect(select_box_element, {
        search: true
    });
    var select_box_element = document.querySelector('#project_name');
        dselect(select_box_element, {
          search:true
        });
</script>

</body>
</html>
