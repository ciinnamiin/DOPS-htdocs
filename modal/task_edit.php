<?php
include_once('includes/session.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DOPS</title>
    <link href="bootstrap.css" rel="stylesheet">
    <script src="https://unpkg.com/@jarstone/dselect/dist/js/dselect.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">


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
                    <a href="tasks.php" class="btn btn-primary">Back</a>
                    <h2>Edit Details</h2>
                </div>
                <div class="card-body">
                    <?php
                        $task = array();
                        $task_id = '';

                        if(isset($_GET["id"])){
                            $task_id = $_GET["id"];

                            $sql = "SELECT * FROM timesheets 
                        left join employees ON timesheets.employee_id = employees.employee_id
                        left join tasks ON timesheets.task_id = tasks.task_id
                        left join projects ON tasks.project_id = projects.project_id
                        left join clients ON projects.client_id = clients.client_id
                        WHERE timesheets.task_id = '$task_id' " ; 
                            $result = $conn->query($sql);
                            
                            if ($result->num_rows > 0) {
                                $project = $result->fetch_assoc();
                                
                            }


                        }else{
                            echo '<script>window.history.back();</script>';
                        }

                    ?>
                     <form id="" method="post" action="task_update.php">
                        <input type="hidden" name="task_id" value="<?= $project["task_id"]; ?>"/>
                        <div class="row">
                            <div class="col mb-2">
                            <label for="project_id">Area</label>
                                <select name="project_id" class="" id="project_id">
                                    <option value="">Select Area</option>
                                    <?php 
                                        $sql = "SELECT * FROM projects where project_id IN (SELECT project_id FROM project_users WHERE employee_id = '".$_SESSION["User"]["employee_id"]."' ) "; // Adjust the SQL query as needed
                                        $result = $conn->query($sql);
                                        
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {?>
                                           <option value="<?= $row["project_id"];?>"<?= ($project["project_id"] == $row["project_id"])? 'selected' : '';  ?>><?= $row["project_name"]; ?></option>
                                    <?php 
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="col">
                                <label for="end_date">Date</label>
                                <input type="date"  value="<?= $project["end_date"];?>" placeholder="end date" class="form-control" name="date" id="end_date" />
                            </div> 
                            
                        </div>
                        <div class="row mb-2">
                            <div class="col">
                                <label for="start">Start</label>
                                <input type="time"  value="<?= $project["start"];?>" placeholder="end date" class="form-control" name="start" id="time_start" />
                            </div>
                            <div class="col">
                                <label for="end">End</label>
                                <input type="time"  value="<?= $project["end"];?>" placeholder="end" class="form-control" name="end" id="time_end" />
                            </div>
                        </div>
                        <div class="col-md-6  mb-2">
                                        <label for="disease">Disease</label>
                                            <select name="disease_id" class="form-control" id="disease_name">
                                                <option value="">Disease</option>
                                                <?php 
                                                    $sql = "SELECT * FROM `diseases` "; // Adjust the SQL query as needed
                                                    $result = $conn->query($sql);
                                                    
                                                    if ($result->num_rows > 0) {
                                                        while ($row = $result->fetch_assoc()) {?>
                                                        <option value="<?= $row["disease_id"];?>"<?= ($project["disease_id"] == $row["disease_id"])? 'selected' : '';  ?>><?= $row["disease_name"]; ?></option>
                                                        <?php 
                                                                }
                                                            }
                                                ?>
                                            </select>
                                        </div>
                        
                        <div class="row">
                            <div class="col">
                              <textarea class="form-control" placeholder="Task Description" name="task_name" required><?= $project["task_name"];?></textarea>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col">
                                <button type="submit" class="btn btn-primary form-control" id="submitForm">Update Details </button>
                            </div>
                            <!-- <div class="col">
                                <a href="submit_all.php?submit=all" class="btn btn-primary form-control" >Submit All</a>
                            </div> -->
                            
                        </div>
                    </form>
                </div>
            </div>
           
         </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

<script type="text/javascript">
  flatpickr('#date', {
    enableTime: false
  });

  flatpickr('#time_end', {
    enableTime: true,
    noCalendar: true,
    dateFormat: 'H:i',
  });

  flatpickr('#time_start', {
    enableTime: true,
    noCalendar: true,
    dateFormat: 'H:i',
  });

  function updateHoursAndDuration() {
  const startTimeInput = document.getElementById('time_start');
  const endTimeInput = document.getElementById('time_end');
  const durationCombined = document.getElementById('duration_combined');

  if (startTimeInput && endTimeInput && durationCombined) {
    const startTime = startTimeInput.value;
    const endTime = endTimeInput.value;

    if (startTime && endTime) {
      const startMoment = moment(startTime, 'HH:mm');
      const endMoment = moment(endTime, 'HH:mm');
      const durationMinutes = endMoment.diff(startMoment, 'minutes');

      // Convert durationMinutes to a decimal fraction of an hour
      const durationHours = durationMinutes / 60;

      // Round the decimal to two decimal places
      const formattedDuration = durationHours.toFixed(2);

      durationCombined.value = formattedDuration;
    } else {
      durationCombined.value = '0.00';
    }
  }
}


  document.getElementById('time_start').addEventListener('change', updateHoursAndDuration);
  document.getElementById('time_end').addEventListener('change', updateHoursAndDuration);
</script>


   
    <script>
        var select_box_element = document.querySelector('#project_id');
        dselect(select_box_element, {
          search:true
        });

        const startTimeInput = document.getElementById('time_start');
  const endTimeInput = document.getElementById('time_end');

  startTimeInput.addEventListener('input', function() {
    endTimeInput.min = startTimeInput.value;
    if (endTimeInput.value < startTimeInput.value) {
      endTimeInput.value = startTimeInput.value;
    }
  });

  endTimeInput.addEventListener('input', function() {
    if (endTimeInput.value < startTimeInput.value) {
      endTimeInput.value = startTimeInput.value;
    }
  });
    </script>
</body>
</html>