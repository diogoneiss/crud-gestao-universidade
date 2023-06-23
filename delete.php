<?php
include ("header.html");
require_once('./log.php');

// establishing connection
require_once ('mysqli_connect.php');

if (isset($_POST['id']) && isset($_POST['table'])) {
    $rowId = intval($_POST['id']);
    $table = mysqli_real_escape_string($dbc, $_POST['table']);

    // Prepare the delete query
    $query = "DELETE FROM $table WHERE " . mysqli_fetch_field(mysqli_query($dbc, "SELECT * FROM $table LIMIT 1"))->name . " = $rowId";

    $result = mysqli_query($dbc, $query);

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
