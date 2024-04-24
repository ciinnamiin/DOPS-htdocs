<?php
include_once('includes/session.php');
$page_name = "clients";
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
    <?php
        $page = 'clients';
    ?>
    <?php require('includes/header.php'); ?>
    <div class="container" style="padding-top: 80px;">
    <?php require('includes/pwd_check.php');?>

    <div class="container">
        <div class="card mb-3">
            <div class="card-body">
                <button data-bs-toggle="collapse" data-bs-target="#addnewForm" class="btn btn-primary">Add New</button>
                <div id="addnewForm" class="collapse">
                    <form method="post" action="client_add.php">
                        <input type="hidden" name="user_id" value="<?= $_SESSION["User"]["employee_id"]; ?>"/>
                        <div class="row mb-2">
                            <div class="col"><br>
                                <label for="client_name">Area Name</label>
                                <input type="text" placeholder="Area Name" class="form-control" name="client_name" id="client_name" required/>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col">
                                <button type="submit" class="btn btn-primary form-control">Submit</button>
                            </div>                                
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                <h2>List of Areas</h2>
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
                <input type="text" id="clientSearch" class="form-control" placeholder="Search Area Names">
                <br>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Area Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="activeTableBody">
                        <?php
                            $sql = "SELECT * FROM clients ORDER BY `client_name`"; 
                            $result = $conn->query($sql);
                            $data = array();
                            if ($result->num_rows > 0) {
                                $i = 0;
                                while ($row = $result->fetch_assoc()) {
                                    $i ++;
                        ?>
                        <tr>
                            <td><?= $row["client_name"]; ?></td>
                            <td>
                                <a href="client_edit.php?id=<?= $row["client_id"];?>" class="btn btn-sm btn-primary">Edit</a>
                                <a href="client_delete.php?id=<?= $row["client_id"];?>" class="btn btn-sm btn-danger">Delete</a>
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
</div>

<script>
    document.getElementById('clientSearch').addEventListener('input', function() {
        const searchValue = this.value.toLowerCase();
        const tableRows = document.querySelectorAll('#activeTableBody tr');

        tableRows.forEach(function(row) {
            const clientName = row.querySelector('td:first-child').textContent.toLowerCase();
            if (clientName.includes(searchValue)) {
                row.style.display = 'table-row';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>

<?php require('includes/footer.php'); ?>
</body>
</html>
