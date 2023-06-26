<?php
    include("header.html");
?>
<div class="container">
    <h1 class="text-center mt-4">Enrolled Credits</h1>
    <form method="post" class="form-inline d-flex justify-content-center mt-4">
        <div class="form-group mb-2">
            <label for="StudentID" class="sr-only">StudentID:</label>
            <input type="text" id="StudentID" name="StudentID" class="form-control" placeholder="StudentID" required>
        </div>
        <button type="submit" class="btn btn-primary mb-2 ml-2">Submit</button>
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

            $result = mysqli_query($dbc, $query);
                // check if the query was successful
                if ($result) {
                    // check if any rows were returned
                    if (mysqli_num_rows($result) > 0) {
                        // fetch the result row as an associative array
                        $row = mysqli_fetch_assoc($result);
                        
                        // display the enrolled credits
                        if(empty($row['EnrolledCredits'])){
                            echo "<div class='alert alert-warning text-center'>No credits found for student $student_id.</div>";
                        }else{
                            echo "<div class='alert alert-success text-center'>Enrolled credits for student $student_id: " . $row['EnrolledCredits'] . "</div>";
                        }
                    } else {
                        // display a message if no rows were returned
                        echo "<div class='alert alert-warning text-center'>No enrolled credits found for student $student_id.</div>";
                    }
                } else {
                    // display an error message if the query failed
                    echo "<div class='alert alert-danger text-center'>Error: " . mysqli_error($dbc) . "</div>";
                }
            
                // close the database connection
                mysqli_close($dbc);
            }
    ?> 
</div>
</body>
</html>
