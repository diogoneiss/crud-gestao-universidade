<?php
// update.php

$id = $_GET['id'];
$table = $_GET['table'];

// Determine the appropriate update page based on the table name
if ($table == 'Student') {
  header("Location: update/student.php?id=$id");
} elseif ($table == 'Instructor') {
  header("Location: update/instructor.php?id=$id");
} elseif ($table == 'AcademicCredits') {
  header("Location: update/academicCredits.php?id=$id");
} elseif ($table == 'Building') {
  header("Location: update/building.php?id=$id");
}
elseif ($table == 'Classroom') {
  header("Location: update/classroom.php?id=$id");
} elseif ($table == 'Course') {
  header("Location: update/course.php?id=$id");
} elseif ($table == 'CourseOfferings') {
  header("Location: update/courseOfferings.php?id=$id");
} elseif ($table == 'Department') {
  header("Location: update/department.php?id=$id");
} elseif ($table == 'Enrollments') {
  header("Location: update/enrollments.php?id=$id");
} elseif ($table == 'Grade') {
  header("Location: update/grade.php?id=$id");
} else {
  // Handle other table names or invalid table names
  echo "Invalid table name.";
}
?>
