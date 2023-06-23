<?php
// grade.php

include("../header.html");
require_once("../mysqli_connect.php");

$id = $_GET['id'];

// Query to get the Grade record by GradeID
$query = "SELECT * FROM Grade WHERE GradeID = ?";
$stmt = $dbc->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$grade = $result->fetch_assoc();

// Query to get all the students
$query_students = "SELECT * FROM Student";
$result_students = mysqli_query($dbc, $query_students);

// Query to get all the course offerings
$query_offerings = "SELECT * FROM CourseOfferings";
$result_offerings = mysqli_query($dbc, $query_offerings);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Grade</title>
</head>
<body>
    <div class="container">
        <h2 class="mt-5">Update Grade</h2>
        <form action="grade_update_process.php" method="post">
            <input type="hidden" name="GradeID" value="<?php echo $grade['GradeID']; ?>">

            <div class="form-group">
                <label for="GradeValue">Grade Value:</label>
                <input type="text" class="form-control" id="GradeValue" name="GradeValue" value="<?php echo $grade['GradeValue']; ?>" required>
            </div>

            <div class="form-group">
                <label for="StudentID">Student:</label>
                <select class="form-control" id="StudentID" name="StudentID">
                    <?php while ($row = mysqli_fetch_assoc($result_students)) { ?>
                        <option value="<?php echo $row['StudentID']; ?>" <?php if ($row['StudentID'] == $grade['StudentID']) echo 'selected'; ?>>
                            <?php echo $row['FirstName'] . ' ' . $row['LastName']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group">
                <label for="OfferingID">Course Offering:</label>
                <select class="form-control" id="OfferingID" name="OfferingID">
                    <?php while ($row = mysqli_fetch_assoc($result_offerings)) { ?>
                        <option value="<?php echo $row['OfferingID']; ?>" <?php if ($row['OfferingID'] == $grade['OfferingID']) echo 'selected'; ?>>
                            <?php echo $row['CourseID'] . ' ' . $row['Semester'] . ' ' . $row['Year']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <button type="submit" name="submit" class="btn btn-primary">Update Grade</button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>
<?php
mysqli_free_result($result);
mysqli_free_result($result_students);
mysqli_free_result($result_offerings);
$dbc->close();
?>
