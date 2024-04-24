<?php
// include_once('includes/session.php');
// $page_name="employees";
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Timesheet</title>
        <link href="bootstrap.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://unpkg.com/@jarstone/dselect/dist/js/dselect.js"></script>
        <link rel="stylesheet" href="styles.css">

    </head>
    <body>
        <?php
            // $page= 'employees';
        ?>
      
        <div class="container" style="padding-top: 80px;">
      
    
        <br>
        <div class="container col-md-6">            
            <div class="card mb-3">
                <div class="card-header">
                    <center><h2>Password Reset</h2></center>
                </div>
                <div class="card-body">
                        <!-- <button data-bs-toggle="collapse" data-bs-target="#addnewForm" class="btn btn-primary">Add New</button><div></div> -->
                    <!-- <div id="addnewForm" class="collapse"> -->
                        <form method="POST" action="forgotPassword.php" >
                            <div class="row ">
                                <div class="col-md-12">
                                    <label for="email">Email Address</label>
                                    <br>
                                    <input type="email" placeholder="Email" class="form-control" id="email_reset" name="email" autocomplete="off"/>
                                </div>    
                                     
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-12 text-center">
                                    <button type="submit" class="btn btn-primary " name="send-reset-link">Send Password Reset Link</button>
                                </div>                                
                            </div>
                        </form>
                    <!-- </div> -->
                </div>
            </div>
        </div>

    </body>
</html>


