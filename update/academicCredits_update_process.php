<?php
// Database connection
require_once('../mysqli_connect.php');
require_once('../log.php');
include("../header.html");

// Check if the form was submitted
if (isset($_POST['submit'])) {

    $CreditID = $_POST['CreditID'];
    $OfferingID = $_POST['OfferingID'];
    $Credits = $_POST['Credits'];


    $sql = "UPDATE AcademicCredits SET OfferingID = ?, Credits = ? WHERE CreditID = ?";
    $stmt = $dbc->prepare($sql);
    $stmt->bind_param("iii", $OfferingID, $Credits, $CreditID);
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
   
    echo "</div></body></html>";

    $stmt->close();
}

$dbc->close();
?>
