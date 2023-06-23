<!DOCTYPE html>
<html>
<head>
	<title>Enrolled Credits</title>
</head>
<body>
	<h1>Enrolled Credits</h1>
	<form method="post">
		<label for="StudentID">StudentID:</label>
		<input type="text" id="StudentID" name="StudentID" required>
		<br><br>
		<button type="submit">Submit</button>
	</form>

<?php
    require_once('mysqli_connect.php');

	// check if the form was submitted
	if ($_SERVER["REQUEST_METHOD"] == "POST") {

		// retrieve the student_id from the form
		$student_id = $_POST["StudentID"];

		// prepare the SQL statement with a parameterized query
		$query = "SELECT SUM(ac.Credits) AS EnrolledCredits
				FROM AcademicCredits ac
				JOIN Enrollments e ON ac.OfferingID = e.OfferingID
				WHERE e.StudentID = $student_id";
        
        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        echo $query;
        
        $result = mysqli_query($dbc, $query);
		    // check if the query was successful
            if ($result) {
                // check if any rows were returned
                if (mysqli_num_rows($result) > 0) {
                    // fetch the result row as an associative array
                    $row = mysqli_fetch_assoc($result);
                    
                    // display the enrolled credits
                    echo "<p>Enrolled credits for student $student_id: " . $row['EnrolledCredits'] . "</p>";
                } else {
                    // display a message if no rows were returned
                    echo "<p>No enrolled credits found for student $student_id.</p>";
                }
            } else {
                // display an error message if the query failed
                echo "<p>Error: " . mysqli_error($dbc) . "</p>";
            }
        
            // close the database connection
            mysqli_close($dbc);
        }
?>    
</body>
</html>
