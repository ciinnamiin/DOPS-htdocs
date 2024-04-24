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
                    <a href="position.php" class="btn btn-primary">Back</a>
                    <h2>Edit Position</h2>
                </div>
                <div class="card-body">
                    <?php
                        $positions = array();
                        $position_id = '';

                        if(isset($_GET["id"])){
                            $position_id = $_GET["id"];
                        
                            $sql = "SELECT * FROM positions WHERE position_id = '$position_id' "; 
                            $result = $conn->query($sql);
                            
                            if ($result->num_rows > 0) {
                                $positions = $result->fetch_assoc();
                            }
                        } else {
                            echo '<script>window.history.back();</script>';
                        }
                        

                    ?>
                    <form method="post" action="position_update.php">
                    <input type="hidden" name="position_id" value="<?= $position_id; ?>"/>
                        <div class="row mb-2">
                            <div class="col">
                                <label for="position">Position Name</label><br>
                                <input type="text" value="<?= $positions["position"];?>" placeholder="Position Name" class="form-control" name="position" id="position" />
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
