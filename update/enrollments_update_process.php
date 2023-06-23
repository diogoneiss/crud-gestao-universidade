<?php
require_once('../mysqli_connect.php');
require_once('../log.php');
include("../header.html");

if (isset($_POST['submit'])) {
    $EnrollmentID = $_POST['EnrollmentID'];
    $StudentID = $_POST['StudentID'];
    $OfferingID = $_POST['OfferingID'];

    $sql = "UPDATE Enrollments SET StudentID = ?, OfferingID = ? WHERE EnrollmentID = ?";
    $stmt = $dbc->prepare($sql);
    $stmt->bind_param("iii", $StudentID, $OfferingID, $EnrollmentID);
    $result = $stmt->execute();

    echo "<body><div class='container'>";
    if ($result) {
        echo "<div class='alert alert-success mt-5' role='alert'>
                <h4 class='alert-heading'>Success!</h4>
                <p>Record updated successfully.</p>";
    } else {
        echo "<div class='alert alert-danger mt-5' role='alert'>
                <h4 class='alert-heading'>Error!</h4>
                Error updating record: " . $dbc->error . "";
    }
    echo "<hr><a href='../index.php' class='btn btn-primary'>Return to Home</a></div>";
    echo "</div></body></html>";

    $stmt->close();
}

$dbc->close();
?>
