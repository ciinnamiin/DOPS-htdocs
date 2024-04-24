<div id="myModal" class="modal">
            
            <div class="modal-content table-responsive">
                <div class="modal-header">
                    <h3 class="modal-title">Add New Task</h3>
                    <div class="float-end"><span class="close">&times;</span></div>
                </div>
                 
                
                <table class="table table-hover" style="overflow: auto;">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Task Description</th>
                            <th>Project</th>
                            <th>Date</th>
                            <th>Start</th>
                            <th>End</th>
                            <th>Hours</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        <!-- Existing or dynamically populated table rows will go here -->
                    </tbody>
                </table>
                <fieldset>
                    <legend>Form: </legend>
                    <form id="insertForm" method="post" action="insert.php">
                        <input type="hidden" name="user_id" value="<?= $_SESSION["User"]["employee_id"]; ?>"/>
                        <div class="row">
                            <div class="col mb-2">
                            <label for="project_id">Project</label>
                                <select name="project_id" class="form-control" id="project_id">
                                    <option value="">Select Project</option>
                                    <?php 
                                        $sql = "SELECT * FROM projects where employee_id = '".$_SESSION["User"]["employee_id"]."' "; // Adjust the SQL query as needed
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
                                <input type="time" class="form-control" name="start" id="start"/>
                            </div>
                            <div class="col">
                                <label for="end">End</label>
                                <input type="time" class="form-control" name="end" id="end"/>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col">
                              <textarea class="form-control" placeholder="Task Description" name="description" required></textarea>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col">
                                <button type="button" class="btn btn-success form-control" id="submitForm">Add Task </button>
                            </div>
                            <div class="col">
                                <button type="button" class="btn btn-primary form-control" id="submitTasks">Submit All</button>
                            </div>
                            
                        </div>
                    </form>
                </fieldset>
                
            </div>
        </div>