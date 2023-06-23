<?php
// courseOfferings.php

include("../header.html");
require_once("../mysqli_connect.php");

$id = $_GET['id'];

// Query to get the Course Offering record by OfferingID
$query = "SELECT * FROM CourseOfferings WHERE OfferingID = ?";
$stmt = $dbc->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$offering = $result->fetch_assoc();

// Query to get all the courses
$query_courses = "SELECT * FROM Course";
$result_courses = mysqli_query($dbc, $query_courses);

// Query to get all the instructors
$query_instructors = "SELECT * FROM Instructor";
$result_instructors = mysqli_query($dbc, $query_instructors);

// Query to get all the classrooms
$query_classrooms = "SELECT * FROM Classroom";
$result_classrooms = mysqli_query($dbc, $query_classrooms);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Course Offering</title>
</head>
<body>
    <div class="container">
        <h2 class="mt-5">Update Course Offering</h2>
        <form action="courseOfferings_update_process.php" method="post">
            <input type="hidden" name="OfferingID" value="<?php echo $offering['OfferingID']; ?>">

            <div class="form-group">
                <label for="CourseID">Course:</label>
                <select class="form-control" id="CourseID" name="CourseID">
                    <?php while ($row = mysqli_fetch_assoc($result_courses)) { ?>
                        <option value="<?php echo $row['CourseID']; ?>" <?php if ($row['CourseID'] == $offering['CourseID']) echo 'selected'; ?>>
                            <?php echo $row['CourseName']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group">
                <label for="InstructorID">Instructor:</label>
                <select class="form-control" id="InstructorID" name="InstructorID">
                    <?php while ($row = mysqli_fetch_assoc($result_instructors)) { ?>
                        <option value="<?php echo $row['InstructorID']; ?>" <?php if ($row['InstructorID'] == $offering['InstructorID']) echo 'selected'; ?>>
                            <?php echo $row['FirstName'] . ' ' . $row['LastName']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group">
                <label for="ClassroomID">Classroom:</label>
                <select class="form-control" id="ClassroomID" name="ClassroomID">
                    <?php while ($row = mysqli_fetch_assoc($result_classrooms)) { ?>
                        <option value="<?php echo $row['ClassroomID']; ?>" <?php if ($row['ClassroomID'] == $offering['ClassroomID']) echo 'selected'; ?>>
                            <?php echo $row['Building'] . ' ' . $row['RoomNum']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group">
                <label for="Semester">Semester:</label>
                <input type="text" class="form-control" id="Semester" name="Semester" value="<?php echo $offering['Semester']; ?>">
            </div>

            <div class="form-group">
                <label for="Year">Year:</label>
                <input type="number" class="form-control" id="Year" name="Year" value="<?php echo $offering['Year']; ?>">
            </div>

            <button type="submit" name="submit" class="btn btn-primary">Update Course Offering</button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>
<?php
mysqli_free_result($result);
mysqli_free_result($result_courses);
mysqli_free_result($result_instructors);
mysqli_free_result($result_classrooms);
$dbc->close();
?>
