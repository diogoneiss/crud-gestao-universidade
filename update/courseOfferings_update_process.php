<?php
// courseOfferings_update_process.php

// Database connection
require_once('../mysqli_connect.php');
require_once('../log.php');
include("../header.html");

// Check if the form was submitted
if (isset($_POST['submit'])) {
    // Get the submitted form data
    $OfferingID = $_POST['OfferingID'];
    $CourseID = $_POST['CourseID'];
    $InstructorID = $_POST['InstructorID'];
    $ClassroomID = $_POST['ClassroomID'];
    $Semester = $_POST['Semester'];
    $Year = $_POST['Year'];

    // Update the record in the database
    $sql = "UPDATE CourseOfferings SET CourseID = ?, InstructorID = ?, ClassroomID = ?, Semester = ?, Year = ? WHERE OfferingID = ?";
    $stmt = $dbc->prepare($sql);
    $stmt->bind_param("iiissi", $CourseID, $InstructorID, $ClassroomID, $Semester, $Year, $OfferingID);
    $result = $stmt->execute();

    echo "
    <body>
    <div class='container'>";
    if ($result) {
        // Success message and button to return to homepage
        echo "<div class='alert alert-success mt-5' role='alert'>
                <h4 class='alert-heading'>Success!</h4>
                <p>Record updated successfully.</p>
              ";
    } else {
        echo "<div class='alert alert-danger mt-5' role='alert'>
                <h4 class='alert-heading'>Error!</h4>
                Error updating record: " . $dbc->error . "
              ";
    }
    echo "
    <hr>
    <a href='../index.php' class='btn btn-primary'>Return to Home</a>
    </div>
    ";
    // End HTML output
    echo "</div></body></html>";

    $stmt->close();
}

$dbc->close();
?>
