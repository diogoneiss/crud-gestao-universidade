<?php
include "header.html";
require_once "log.php";
require_once "mysqli_connect.php";

// because I have 9 tables, I have to add 9 different cases
if (isset($_POST["submitted"])) {
    $table = mysqli_real_escape_string($dbc, $_POST["table"]);

    // constructing the SQL query based on the selected table; no ID fields since they are AI
    console_log($_POST);

    switch ($table) {
        case "AcademicCredits":
            //bug: offering id is not being received from the form

            $offeringID = mysqli_real_escape_string(
                $dbc,
                $_POST["OfferingID_ac"]
            );
            $credits = mysqli_real_escape_string($dbc, $_POST["Credits_ac"]);


            $query = "INSERT INTO AcademicCredits (OfferingID, Credits) VALUES ('$offeringID', $credits)";

            break;
        case "Classroom":
            $building = mysqli_real_escape_string(
                $dbc,
                $_POST["Building_classroom"]
            );
            $roomNum = mysqli_real_escape_string(
                $dbc,
                $_POST["RoomNum_classroom"]
            );
            $capacity = mysqli_real_escape_string(
                $dbc,
                $_POST["Capacity_classroom"]
            );
            $query = "INSERT INTO Classroom (Building, RoomNum, Capacity) VALUES ('$building', $roomNum, $capacity)";
            break;
        case "Course":
            $courseName = mysqli_real_escape_string(
                $dbc,
                $_POST["CourseName_course"]
            );
            $departmentID = mysqli_real_escape_string(
                $dbc,
                $_POST["DepartmentID_course"]
            );

            $query = "INSERT INTO Course (CourseName, DepartmentID) VALUES ('$courseName', $departmentID)";
            
            break;
        case "CourseOfferings":
            $courseID = mysqli_real_escape_string($dbc, $_POST["CourseID_co"]);
            $instructorID = mysqli_real_escape_string(
                $dbc,
                $_POST["InstructorID_co"]
            );
            $classroomID = mysqli_real_escape_string(
                $dbc,
                $_POST["ClassroomID_co"]
            );
            $semester = mysqli_real_escape_string($dbc, $_POST["Semester_co"]);
            $year = mysqli_real_escape_string($dbc, $_POST["Year_co"]);

            $query = "INSERT INTO CourseOfferings (CourseID, InstructorID, ClassroomID, Semester, Year) VALUES ($courseID, $instructorID, $classroomID, '$semester', $year)";
            
            break;
        case "Department":
            $departmentName = mysqli_real_escape_string(
                $dbc,
                $_POST["DepartmentName_d"]
            );
            $query = "INSERT INTO Department (DepartmentName) VALUES ('$departmentName')";
            break;
        case "Grade":
            $gradevalue = mysqli_real_escape_string(
                $dbc,
                $_POST["GradeValue_g"]
            );
            $studentID = $_POST["StudentID"];
            $offeringID = mysqli_real_escape_string(
                $dbc,
                $_POST["OfferingID_g"]
            );

            $query = "INSERT INTO Grade (GradeValue, StudentID, OfferingID) VALUES ('$gradevalue', $studentID, $offeringID)";
            
            break;
        case "Instructor":
            $departmentID = mysqli_real_escape_string(
                $dbc,
                $_POST["DepartmentID_i"]
            );
            $email = mysqli_real_escape_string($dbc, $_POST["Email_i"]);
            $firstName = mysqli_real_escape_string($dbc, $_POST["FirstName_i"]);
            $lastName = mysqli_real_escape_string($dbc, $_POST["LastName_i"]);
            $query = "INSERT INTO Instructor (DepartmentID, Email, FirstName, LastName) VALUES ($departmentID, '$email', '$firstName', '$lastName')";
            
            break;
        case "Student":
            $email = mysqli_real_escape_string($dbc, $_POST["Email_s"]);
            $major = mysqli_real_escape_string($dbc, $_POST["Major_s"]);
            $year = mysqli_real_escape_string($dbc, $_POST["Year_s"]);
            $firstName = mysqli_real_escape_string($dbc, $_POST["FirstName_s"]);
            $lastName = mysqli_real_escape_string($dbc, $_POST["LastName_s"]);
            $query = "INSERT INTO Student (Email, Major, Year, FirstName, LastName) VALUES ('$email', '$major', $year, '$firstName', '$lastName')";
            break;
        case "Enrollments":
            $studentID = mysqli_real_escape_string($dbc, $_POST["StudentID_e"]);
            $offeringID = mysqli_real_escape_string($dbc, $_POST["Offering_e"]);
            $query = "INSERT INTO Enrollments (StudentID, OfferingID) VALUES ($studentID, $offeringID)";
            break;
        default:
            echo "<p>Invalid table selected.</p>";
            break;
    }

    error_reporting(E_ALL);
    ini_set("display_errors", 1);
    $result = mysqli_query($dbc, $query);

    if ($result) {
        echo "<div class='alert alert-success text-center' role='alert'>";
        echo "<p>A new record has been added to ". $table ."</p>";
        echo "<p><a href='index.php' class='alert-link'>Back to the main page.</a></p>";
        echo "</div>";
    } else {
        echo "<div class='alert alert-danger text-center' role='alert'>";
        echo "<p>The record could not be added due to a system error: " .
            mysqli_error($dbc) .
            "</p>";
        echo "</div>";
    }
    
}

mysqli_close($dbc);
?>

<form action="add.php" method="POST" class="container mt-5">
    <div class="form-group">
        <label for="tableSelect">Select table:</label>
        <select name="table" class="form-control" id="tableSelect">
            <option selected value="AcademicCredits">Academic Credits</option>
            <option value="Classroom">Classroom</option>
            <option value="Course">Course</option>
            <option value="CourseOfferings">Course Offerings</option>
            <option value="Department">Department</option>
            <option value="Grade">Grade</option>
            <option value="Instructor">Instructor</option>
            <option value="Student">Student</option>
            <option value="Enrollments">Enrollments</option>
        </select>
    </div>

<!-- Fields for AcademicCredits table -->
<div id="AcademicCredits" class="table-fields">
    <p><strong>Table: Academic Credits</strong></p>
    <p>Please refer to the CourseOfferings table for the correct OfferingID.</p>
    <div class="form-group">
        <label for="OfferingID_ac">OfferingID:</label>
        <input type="text" class="form-control" name="OfferingID_ac" id="OfferingID_ac">
    </div>
    <div class="form-group">
        <label for="Credits_ac">Credits:</label>
        <input type="number" class="form-control" name="Credits_ac" id="Credits_ac">
    </div>
</div>

<!-- Fields for Classroom table -->
<div id="Classroom" class="table-fields">
    <p><strong>Table: Classroom</strong></p>
    <div class="form-group">
        <label for="Building_classroom">Building:</label>
        <input type="text" class="form-control" name="Building_classroom" id="Building_classroom">
    </div>
    <div class="form-group">
        <label for="RoomNum_classroom">RoomNum:</label>
        <input type="text" class="form-control" name="RoomNum_classroom" id="RoomNum_classroom">
    </div>
    <div class="form-group">
        <label for="Capacity_classroom">Capacity:</label>
        <input type="number" class="form-control" name="Capacity_classroom" id="Capacity_classroom">
    </div>
</div>

<!-- Fields for Course table -->
<div id="Course" class="table-fields">
    <p><strong>Table: Course</strong></p>
    <p>Please refer to the Department table for the correct DepartmentID.</p>
    <div class="form-group">
        <label for="CourseName_course">CourseName:</label>
        <input type="text" class="form-control" name="CourseName_course" id="CourseName_course">
    </div>
    <div class="form-group">
        <label for="DepartmentID_course">DepartmentID:</label>
        <input type="text" class="form-control" name="DepartmentID_course" id="DepartmentID_course">
    </div>
</div>


<!-- Fields for CourseOfferings table -->
<div id="CourseOfferings" class="table-fields">
    <p><strong>Table: Course Offerings</strong></p>
    <p>Please refer to the Course, Instructor, and Classroom tables for the correct CourseID, InstructorID, and ClassroomID.</p>
    <div class="form-group">
        <label for="CourseID_co">CourseID:</label>
        <input type="text" class="form-control" name="CourseID_co" id="CourseID_co">
    </div>
    <div class="form-group">
        <label for="InstructorID_co">InstructorID:</label>
        <input type="text" class="form-control" name="InstructorID_co" id="InstructorID_co">
    </div>
    <div class="form-group">
        <label for="ClassroomID_co">ClassroomID:</label>
        <input type="text" class="form-control" name="ClassroomID_co" id="ClassroomID_co">
    </div>
    <div class="form-group">
        <label for="Semester_co">Semester:</label>
        <input type="text" class="form-control" name="Semester_co" id="Semester_co">
    </div>
    <div class="form-group">
        <label for="Year_co">Year:</label>
        <input type="text" class="form-control" name="Year_co" id="Year_co">
    </div>
</div>
    <!-- Fields for Department table -->
<div id="Department" class="table-fields">
    <p><strong>Table: Department</strong></p>
    <div class="form-group">
        <label for="DepartmentName_d">DepartmentName:</label>
        <input type="text" class="form-control" name="DepartmentName_d" id="DepartmentName_d">
    </div>
</div>

<!-- Fields for Grade table -->
<div id="Grade" class="table-fields">
    <p><strong>Table: Grade</strong></p>
    <p>Please refer to the Student and CourseOfferings tables for the correct StudentID and OfferingID.</p>
    <div class="form-group">
        <label for="GradeValue_g">GradeValue:</label>
        <input type="text" class="form-control" name="GradeValue_g" id="GradeValue_g">
    </div>
    <div class="form-group">
        <label for="StudentID_g">StudentID:</label>
        <input type="text" class="form-control" name="StudentID_g" id="StudentID_g">
    </div>
    <div class="form-group">
        <label for="Offering_g">OfferingID:</label>
        <input type="text" class="form-control" name="Offering_g" id="Offering_g">
    </div>
</div>

<!-- Fields for Instructor table -->
<div id="Instructor" class="table-fields">
    <p><strong>Table: Instructor</strong></p>
    <p>Please refer to the Department table for the correct DepartmentID.</p>
    <div class="form-group">
        <label for="DepartmentID_i">DepartmentID:</label>
        <input type="text" class="form-control" name="DepartmentID_i" id="DepartmentID_i">
    </div>
    <div class="form-group">
        <label for="Email_i">Email:</label>
        <input type="text" class="form-control" name="Email_i" id="Email_i">
    </div>
    <div class="form-group">
        <label for="FirstName_i">FirstName:</label>
        <input type="text" class="form-control" name="FirstName_i" id="FirstName_i">
    </div>
    <div class="form-group">
        <label for="LastName_i">LastName:</label>
        <input type="text" class="form-control" name="LastName_i" id="LastName_i">
    </div>
</div>
<!-- Fields for Student table -->
<div id="Student" class="table-fields">
    <p><strong>Table: Student</strong></p>
    <div class="form-group">
        <label for="Email_s">Email:</label>
        <input type="text" class="form-control" name="Email_s" id="Email_s">
    </div>
    <div class="form-group">
        <label for="Major_s">Major:</label>
        <input type="text" class="form-control" name="Major_s" id="Major_s">
    </div>
    <div class="form-group">
        <label for="Year_s">Year:</label>
        <input type="text" class="form-control" name="Year_s" id="Year_s">
    </div>
    <div class="form-group">
        <label for="FirstName_s">FirstName:</label>
        <input type="text" class="form-control" name="FirstName_s" id="FirstName_s">
    </div>
    <div class="form-group">
        <label for="LastName_s">LastName:</label>
        <input type="text" class="form-control" name="LastName_s" id="LastName_s">
    </div>
</div>

<!-- Fields for Enrollments table -->
<div id="Enrollments" class="table-fields">
    <p><strong>Table: Enrollments</strong></p>
    <p>Please refer to the Student and CourseOfferings tables for the correct StudentID and OfferingID.</p>
    <div class="form-group">
        <label for="StudentID_e">StudentID:</label>
        <input type="text" class="form-control" name="StudentID_e" id="StudentID_e">
    </div>
    <div class="form-group">
        <label for="Offering_e">OfferingID:</label>
        <input type="text" class="form-control" name="Offering_e" id="Offering_e">
    </div>
</div>

<div class="form-group">
    <button type="submit" name="submitted" class="btn btn-primary">Submit</button>
</div>

</form>

<script>

// hiding all table fields on page load -- had to google this, since its javascript
document.querySelectorAll('.table-fields').forEach(function(el) {
    el.style.display = 'none';
});

// showing table fields when the table is selected  -- had to google this, since its javascript
// without this part, all fields are shown at all times, which is not ideal
document.querySelector('select[name="table"]').addEventListener('change', function() {
    document.querySelectorAll('.table-fields').forEach(function(el) {
        el.style.display = 'none';
    });
   

    var table = this.value;
    let name = '#' + table;
    console.log("Showing table: " + this.value);
    document.querySelector("#"+table).style.display = 'block';
});


// setting the default value and showing corresponding table fields
var defaultTable = 'AcademicCredits'; 
document.querySelector('select[name="table"]').value = defaultTable;
document.querySelector('#' + defaultTable).style.display = 'block';

/*
const form = document.querySelector('form');

form.addEventListener('submit', (event) => {
  event.preventDefault(); // prevent default form submission behavior
  
  const formData = new FormData(form); // create a new FormData object from the form
  
  // log the form data to the console
  for (let [key, value] of formData.entries()) {
    console.log(`${key}: ${value}`);
  }
  
  // send the form data to the server using an AJAX request
  const xhr = new XMLHttpRequest();
  xhr.open('POST', './add.php');
  xhr.send(formData);
});
*/
</script>
