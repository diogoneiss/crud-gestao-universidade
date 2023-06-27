<?php
include("header.html");
require_once('./log.php');

// establishing connection
require_once('mysqli_connect.php');

if (isset($_POST['id']) && isset($_POST['table'])) {
    $rowId = intval($_POST['id']);
    $table = mysqli_real_escape_string($dbc, $_POST['table']);

    // first delete the email, if the table is Instructor or Student
    if ($table === 'Instructor' || $table === 'Student') {
        $query = "SELECT * FROM $table WHERE " . mysqli_fetch_field(mysqli_query($dbc, "SELECT * FROM $table LIMIT 1"))->name . " = $rowId";
        console_log("Select query for row: " . $query);
        $result = mysqli_query($dbc, $query); // execute the query
        if ($result) {
            $row = mysqli_fetch_assoc($result);
            $emailId = $row['EmailID'];
            // delete the corresponding email
            $emailQuery = "DELETE FROM Emails WHERE EmailID = $emailId";
            mysqli_query($dbc, $emailQuery);
            console_log("Deleted email! Query for email: " . $emailQuery);
        }
    }


    // Prepare the delete query
    $query = "DELETE FROM $table WHERE " . mysqli_fetch_field(mysqli_query($dbc, "SELECT * FROM $table LIMIT 1"))->name . " = $rowId";

    $result = mysqli_query($dbc, $query);

    console_log("Delete query: " . $query);

    if ($result) {
        echo "<p class='alert alert-success'>Record with ID $rowId was successfully deleted from the $table table.</p>";
    } else {
        echo "<p class='alert alert-danger'>An error occurred while attempting to delete the record. Error: " . mysqli_error($dbc) . "</p>";
    }

} else {
    echo "<p class='alert alert-warning'>Invalid request. Please try again.</p>";
}

mysqli_close($dbc);
?>

<div class="container mt-3">
    <a href="index.php" class="btn btn-primary">Go back to the index page</a>
</div>