<?php
// grade_update_process.php

// Database connection
require_once('../mysqli_connect.php');
require_once('../log.php');
include("../header.html");

// Check if the form was submitted
if (isset($_POST['submit'])) {
    // Get the submitted form data
    $GradeID = $_POST['GradeID'];
    $GradeValue = $_POST['GradeValue'];
    $StudentID = $_POST['StudentID'];
    $OfferingID = $_POST['OfferingID'];

    // Update the record in the database
    $sql = "UPDATE Grade SET GradeValue = ?, StudentID = ?, OfferingID = ? WHERE GradeID = ?";
    $stmt = $dbc->prepare($sql);
    $stmt->bind_param("siii", $GradeValue, $StudentID, $OfferingID, $GradeID);
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
