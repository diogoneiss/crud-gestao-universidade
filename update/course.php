<?php
// course.php

include("../header.html");
require_once("../mysqli_connect.php");

$id = $_GET['id'];

$query = "SELECT * FROM Course WHERE CourseID = ?";
$stmt = $dbc->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$course = $result->fetch_assoc();

$query_departments = "SELECT * FROM Department";
$result_departments = mysqli_query($dbc, $query_departments);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Course</title>
</head>
<body>
    <div class="container">
        <h2 class="mt-5">Update Course</h2>
        <form action="course_update_process.php" method="post">
            <input type="hidden" name="CourseID" value="<?php echo $course['CourseID']; ?>">

            <div class="form-group">
                <label for="CourseName">Course Name:</label>
                <input type="text" class="form-control" id="CourseName" name="CourseName" value="<?php echo $course['CourseName']; ?>">
            </div>

            <div class="form-group">
                <label for="DepartmentID">Department:</label>
                <select class="form-control" id="DepartmentID" name="DepartmentID">
                    <?php while ($row = mysqli_fetch_assoc($result_departments)) { ?>
                        <option value="<?php echo $row['DepartmentID']; ?>" <?php if ($row['DepartmentID'] == $course['DepartmentID']) echo 'selected'; ?>>
                            <?php echo $row['DepartmentName']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <button type="submit" name="submit" class="btn btn-primary">Update Course</button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>
<?php
mysqli_free_result($result);
mysqli_free_result($result_departments);
$dbc->close();
?>
