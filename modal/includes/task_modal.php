<script src="https://unpkg.com/@jarstone/dselect/dist/js/dselect.js"></script>
<!-- Include Bootstrap CDN -->
<!-- <link href=
"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
        rel="stylesheet"> -->
    <!-- <link  rel="stylesheet" href="includes/styles.css"> -->
    <!-- <script src=
"https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js">
    </script>
    <script src=
"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js">
    </script> -->
 
    <!-- Include Moment.js CDN -->
    <!-- <script type="text/javascript" src=
"https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js">
    </script> -->
 
    <!-- Include Bootstrap DateTimePicker CDN -->
    <!-- <link
        href=
"https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css"
        rel="stylesheet"> -->
 
    <!-- <script src=
"https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js">
        </script> -->

<!-- Include jQuery library -->

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<div id="myModal" class="modal">
            
            <div class="modal-content table-responsive">
                <div class="modal-header">
                    <h3 class="modal-title">Add New Patient Details</h3>
                    <div class="float-end"><span class="close">&times;</span></div>
                   
                </div>
                 <div id="alertMsg">
                    
                 </div>
                
                <table class="table table-hover" style="overflow: auto;">
                    <thead>
                        <tr>
                            <th>Details</th>
                            <th>Patient</th>
                            <th>Date</th>
                            <th>Start</th>
                            <th>End</th>
                            <th>Hours</th>
                            <th>Actions</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        <!-- Existing or dynamically populated table rows will go here -->
                    </tbody>
                </table>
                <fieldset>
                    <legend>Total Hours: <span id="totalHours"></span></legend>
                    <form id="insertForm" method="post" action="submit_all.php">
                        <input type="hidden" name="user_id" value="<?= $_SESSION["User"]["employee_id"]; ?>"/>
                        <div class="row">
                            <div class="col mb-2">
                            <label for="project_id">Patient</label>
                                <select name="project_id" class="" id="project_id">
                                    <option value="" selected>Select Patient</option>
                                    <?php 
                                        $sql = "SELECT * FROM projects where project_id IN (SELECT project_id FROM project_users WHERE employee_id = '".$_SESSION["User"]["employee_id"]."' ) "; // Adjust the SQL query as needed
                                        $result = $conn->query($sql);
                                        
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {?>
                                            <option value="<?= $row["project_id"] ?>"><?= $row["project_name"]; ?></option>
                                    <?php 
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                           

                            <div class="col">
                                <label for="date">Date</label>
                                <input type="date" class="form-control" id="date" name="date"/>
                            </div>
                            
                        </div>
                        <div class="row mb-2">
                            <div class="col">
                                <label for="start">Start</label>
                                <input type="time" class="form-control" name="start" id="time_start"/>
                            </div>
                            <div class="col">
                                <label for="end">End</label>
                                <input type="time" class="form-control" name="end" id="time_end"/>
                                
                            </div>
                            
                        </div>
                        
                        
                        <div class="row">
                            <div class="col">
                              <textarea class="form-control" placeholder="Task Description" name="description" required></textarea>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col">
                                <button type="button" class="btn btn-primary form-control" id="submitForm">Add Details </button>
                            </div>
                            <div class="col">
                                <a href="submit_all.php?submit=all" class="btn btn-primary form-control" >Submit All</a>
                            </div>
                            
                        </div>
                    </form>
                </fieldset>
                
            </div>
        </div>
        <?php
        function get_hours(){
            global $conn;
            // $zero = 0;
            if($_SESSION["User"]["is_admin"]){
                $sql = "SELECT SUM(`hours`) as `hours` FROM timesheets
                    WHERE timesheets.active = 0 ";
            }else{
                $sql = "SELECT SUM(`hours`) as `hours` FROM timesheets
                    WHERE employee_id = '".$_SESSION["User"]["employee_id"]."' AND timesheets.active = 0  "; 
            }
            
            $result = $conn->query($sql);
                                
            if($result->num_rows > 0){
                $row = $result->fetch_assoc();
                return $row["hours"];
            }else{
                return 0;
               
            }
        }
        
        ?>

<script>
        var select_box_element = document.querySelector('#project_id');
        dselect(select_box_element, {
          search:true
        });
    </script>


<script>
    
    // Function to refresh the page
    function refreshPage() {
        location.reload();
    }

    // Attach the function to the "Add Time" button
    // document.getElementById("submitForm").addEventListener("click", handleAddTimeButtonClick);
</script>
    
        <!-- <script>
 
 Below code sets format to the
 datetimepicker having id as
 datetime
 $('#datetime').datetimepicker({
     format: 'hh:mm:ss a'
 });


 
</script> -->
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





<!-- 
    <script>
        var firstOpen = true;
        var time;

        $('#timePicker').datetimepicker({
            useCurrent: false,
            format: "hh:mm A"
        }).on('dp.show', function() {
            if(firstOpen) {
                time = moment().startOf('day');
                firstOpen = false;
            } else {
                time = "01:00 PM"
            }        
            $(this).data('DateTimePicker').date(time);
        });
    </script>     -->

<script>
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


