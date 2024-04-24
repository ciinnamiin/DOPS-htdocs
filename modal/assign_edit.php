<?php
include_once('includes/session.php');
include_once('includes/db.php'); // Include your database connection file

// Initialize variables to prevent potential undefined variable errors
$id = $project_id = $employee_id = $rate = '';

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $sql = "SELECT * FROM project_users 
            LEFT JOIN employee_project_rate ON project_users.employee_id = employee_project_rate.employee_id
            WHERE project_users.id = ?"; 

    // Use prepared statement to avoid SQL injection
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $assign = $result->fetch_assoc();
        $project_id = $assign['project_id'];
        $employee_id = $assign['employee_id'];
        $rate = $assign['rate'];
    } else {
        echo '<script>window.history.back();</script>';
        exit; // Terminate further execution
    }
}

// Close the prepared statement
$stmt->close();

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
    <?php require('includes/header.php'); ?>

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
                    <h2>Edit Assign</h2>
                </div>
                <div class="card-body">
                    <?php
                        $assign = array();
                        $id = '';

                        if(isset($_GET["id"])){
                            $id = $_GET["id"];

                            $sql = "SELECT *
                            FROM project_users 
                            where id = '$id'";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                $assign = $result->fetch_assoc();
                            }
                        } else {
                            echo '<script>window.history.back();</script>';
                        }
                    ?>
                    <!-- Your form and other HTML content remain the same -->

                    <form method="post" action="assign_update.php">
                        <input type="hidden" name="assign_id" value="<?= $id; ?>"/>
                        <div class="row">
                            <div class="col mb-2">
                                <label for="project_id">Area</label> 
                                <select name="project_id" class="form-control" id="project_name">
                                    <option value="">Select Area</option>
                                    <?php 
                                        $sql = "SELECT * FROM projects "; // Adjust the SQL query as needed
                                        $result = $conn->query($sql);

                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {?>
                                            <option 
                                                value="<?= $row["project_id"] ?>" 
                                                <?php echo ($row['project_id'] == $assign['project_id']) ? 'selected' : '';?> 
                                            >
                                            <?= $row["project_name"]; ?>
                                            </option>
                                    <?php 
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="col mb-2">
                                <label for="employee_name">Assigned Health Worker</label>
                                <select name="employee_id" class="form-control" id="employee_name">
                                    <option value="">Select Health Worker</option>
                                    <?php 
                                        $sql = "SELECT * FROM employees "; // Adjust the SQL query as needed
                                        $result = $conn->query($sql);

                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {?>
                                            <option 
                                                value="<?= $row["employee_id"] ?>"
                                                <?php echo ($row['employee_id'] == $assign['employee_id']) ? 'selected' : '';?> 
                                            ><?= $row["first_name"] .' '.$row['last_name']; ?></option>
                                    <?php 
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="col mb-2">
                                <label for="rate">Rate</label><br>
                                <input type="text" value="<?= $assign["rate"] ?? 850; ?>" placeholder="Rate" class="form-control" name="rate" id="rate" />
                            </div>
                            <div class="row mt-2">
                                <div class="col">
                                    <button type="submit" class="btn btn-primary form-control">UPDATE</button>
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
