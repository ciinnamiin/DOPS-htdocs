<?php 
if (session_status() != PHP_SESSION_ACTIVE) {
    session_start();
}

?>
<script src="https://kit.fontawesome.com/323b260474.js" crossorigin="anonymous"></script>
<script>
//   $(document).ready(function() {
//     $(".nav-link").click(function() {
//       $(".nav-link").removeClass("active"); // Remove active class from all links
//       $(this).addClass("active"); // Add active class to clicked link
//     });
//   });
</script>
<nav class="navbar navbar-expand-sm bg-dark navbar-dark mb-4 fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="dashboard.php"><img src="images/dopslogo.png" width=80px></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mynavbar">
                <?php if(isset($_SESSION["User"])){ ?>
                <ul class="navbar-nav me-auto ">
                    <li class="nav-item">
                        <a class="nav-link <?= ($page === "dashboard")? 'active' : ''; ?>" href="dashboard.php">Dashboard</a>
                    </li>
                    <?php 
                    if(!$_SESSION["User"]["is_admin"]){?>
                    <li class="nav-item">
                        <a class="nav-link <?= ($page === "tasks")? 'active' : ''; ?>" href="tasks.php">Capture Patient</a>
                    </li>
                    
                    
                <?php 
                    }
                
                if($_SESSION["User"]["is_admin"]){?>
                    
                   
                    <li class="nav-item">
                        <a class="nav-link <?= ($page === "employees")? 'active' : ''; ?>" href="employees.php">Health Worker</a>
                    </li>
                    <li class="nav-item">
                    <!-- <a class="nav-link <?php echo ($_SERVER['PHP_SELF'] == '/clients.php') ? 'active' : ''; ?>" href="clients.php">Clients</a> -->
                        <a class="nav-link <?= ($page === "clients")? 'active' : ''; ?>" href="clients.php">Areas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($page === "positions")? 'active' : ''; ?>" href="position.php">Positions</a>
                    </li>
                    <li class="nav-item">
                    <!-- <a class="nav-link <?php echo ($_SERVER['PHP_SELF'] == '/projects.php') ? 'active' : ''; ?>" href="projects.php">Projects</a> -->
                        <a class="nav-link <?= ($page === "projects")? 'active' : ''; ?>" href="projects.php">Patients</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($page === "tasks")? 'active' : ''; ?>" href="tasks.php">Capture Patient</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($page === "report")? 'active' : ''; ?>" href="report.php">Report</a>
                    </li>
                    
                    <?php }?>
                    <li class="nav-item">
                        <!-- <a class="nav-link" href="logout.php"><i class="fa fa-sign-out"></i> Logout</a> -->
                    </li>
                </ul>
                <?php }?>
            <div class="d-flex text-white">
                <?php if(isset($_SESSION["User"])){ ?>
                    <!-- <a href="profile.php" class="text-white"><span></span></a> -->
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                        <a class="nav-link <?= ($page === "profile")? 'active' : ''; ?> dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"><?= $_SESSION["User"]["first_name"].' '.$_SESSION["User"]["last_name"]; ?></a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="dashboard.php">Dashboard</a></li>
                            <li><a class="dropdown-item" href="profile.php">Profile</a></li>
                            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                        </ul>
                        </li>
                    </ul>
                
                    <?php }?>
            </div>
            </div>
        </div>
    </nav>
