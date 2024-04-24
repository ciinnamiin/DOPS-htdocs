<?php 
include_once('includes/session.php');
        if(!$_SESSION["User"]["pwd_updated"]){?>
        <div class="container">
            <div class="alert alert-warning">
                Please update your password! <a href="profile.php" class="btn btn-primary">Go to profile</a>
            </div>
        </div>
<?php
        }
 ?>