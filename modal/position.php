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
<?php
        $page= 'positions';
    ?>
    <?php require('includes/header.php');?>
    <div class="container" style="padding-top: 80px;">
    <?php require('includes/pwd_check.php');?>


<div class="container">
    <div class="card mb-3">
        <div class="card-body">    
            <button data-bs-toggle="collapse" data-bs-target="#addnewForm" class="btn btn-primary">Add New</button>
            <div id="addnewForm" class="collapse">
                    <form method="post" action="position_add.php">
                        <input type="hidden" name="user_id" value="<?= $_SESSION["User"]["employee_id"]; ?>"/>
                        <div class="row mb-2">
                            <div class="col"><br>
                                <label for="position">Position</label>
                                <input type="text" placeholder="Position" class="form-control" name="position" id="position" required/>
                            </div>
                        </div>
                            <div class="row mt-2">
                                <div class="col">
                                    <button type="submit" class="btn btn-primary form-control">Submit </button>
                                </div>                                
                            </div>
                    </form>
    </div>
            </div>
        </div>
        
        <div class="card">
                <div class="card-header">
            <h2>List of Positions</h2>
</div>
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
            <table class="table table-hover">
                <thead>
                    <tr>
                        <!-- <th>ID</th> -->
                        <th>Position</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="activeTableBody">
                    <?php

                        $sql = "SELECT * FROM positions ORDER BY `position`"; 
                        $result = $conn->query($sql);
                        
                        $data = array();
                        
                        if ($result->num_rows > 0) {
                            $i = 0;
                            while ($row = $result->fetch_assoc()) {
                                $i ++;
                                ?>
                                <tr>
                                    <!-- <td><?= $i; ?></td> -->
                                    <td><?= $row["position"]; ?></td>
                                    <td>
                                        <a href="position_edit.php?id=<?= $row["position_id"];?>" class="btn btn-sm btn-primary">Edit</a>
                                        <a href="position_delete.php?id=<?= $row["position_id"];?>" class="btn btn-sm btn-danger">Delete</a>
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
    <script src="script.js"></script>
</body>
</html>
