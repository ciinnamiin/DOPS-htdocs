<?php
include_once('includes/session.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $is_admin = (isset($_POST["is_admin"])) ? 1 : 0;

    // ... Your existing code for form data validation ...

    $valid = 1; // validated initially
    $errorMsg = '';

    if(isset($_POST["first_name"]) && $_POST["first_name"] != ''){
        $first_name = $_POST["first_name"];
    }else{
        $errorMsg .= "<li>First Name is required</li>";
        $valid = 0;
    }

    if(isset($_POST["last_name"]) && $_POST["last_name"] != ''){
        $last_name = $_POST["last_name"];
    }else{
        $errorMsg .= "<li>Last Name is required</li>";
        $valid = 0;
    }

    if(isset($_POST["email"]) && $_POST["email"] != '' && validateEmail($_POST["email"])){
        $email = $_POST["email"];
    }else{
        $errorMsg .= "<li>A Valid Email is required</li>";
        $valid = 0;
    }

    if(isset($_POST["position_id"]) && $_POST["position_id"] != ''){
        $position_id = $_POST["position_id"];
    }else{
        $errorMsg .= "<li>Position is required</li>";
        $valid = 0;
    }

    if(isset($_POST["password"]) && $_POST["password"] != '' && strlen($_POST["password"]) >= 6){
        $password = $_POST["password"];
    }else{
        $errorMsg .= "<li>Password is required (Minimum 6 characters)!</li>";
        $valid = 0;
    }
    if(isset($_POST["confirm_password"]) && $_POST["confirm_password"] != '' && strlen($_POST["confirm_password"]) >= 6){
        $confirm_password = $_POST["confirm_password"];
    }else{
        $errorMsg .= "<li>Confirm password field is required (Minimum 6 characters)</li>";
        $valid = 0;
    }

    // Ensure the validation was successful
    if ($valid == 1) {
        if (!emailExist($email)) {
            if ($password === $confirm_password) {
                $hashed = password_hash($password, PASSWORD_DEFAULT);

                // Insert the new employee into the database
                $sql = "INSERT INTO employees (first_name, last_name, position_id, `email`, `password`, is_admin) 
                        VALUES('$first_name','$last_name','$position_id','$email','$hashed', '$is_admin')";

                if ($conn->query($sql) === TRUE) {
                    $employee_id = $conn->insert_id;

                    // Assign the employee to the project
                    $project_id = $_POST['project_id'];
                    if (!empty($project_id)) {
                        $sql = "INSERT INTO project_users (employee_id, project_id) VALUES (?, ?)";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("ii", $employee_id, $project_id);
                        if ($stmt->execute()) {
                            // Employee added and project assigned successfully
                            $_SESSION["success"] = "Employee added and project assigned successfully!";
                        } else {
                            $_SESSION["error"] = "Error assigning the project.";
                        }
                    } else {
                        // No project selected
                        $_SESSION["error"] = "Please select a project to assign to the employee.";
                    }
                } else {
                    // Error adding the employee
                    $_SESSION["error"] = "Error adding the employee.";
                }
            } else {
                // Passwords do not match
                $_SESSION["error"] = "Passwords do not match!";
            }
        } else {
            // Email already exists
            $_SESSION["success"] = "Updated";
        }


            


        // Redirect back to the employee list page
        header("Location: employees.php");
        exit;
    }
}


?>
