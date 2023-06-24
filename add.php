<?php
include "header.html";
require_once "log.php";
require_once "mysqli_connect.php";

// because I have 9 tables, I have to add 9 different cases
if (isset($_POST["submitted"])) {
    $table = mysqli_real_escape_string($dbc, $_POST["table"]);

    // constructing the SQL query based on the selected table; no ID fields since they are AI
    console_log($_POST);

    $fields = [
        "AcademicCredits" => ["OfferingID_ac", "Credits_ac"],
        "Classroom" => ["BuildingID_classroom", "RoomNum_classroom", "Capacity_classroom"],
        "Building" => ["BuildingName_b"],
        "Course" => ["CourseName_course", "DepartmentID_course"],
        "CourseOfferings" => ["CourseID_co", "InstructorID_co", "ClassroomID_co", "Semester_co", "Year_co"],
        "Department" => ["DepartmentName_d"],
        "Grade" => ["GradeValue_g", "StudentID_g", "OfferingID_g"],
        "Instructor" => ["Email_i", "DepartmentID_i", "FirstName_i", "LastName_i"],
        "Student" => ["Email_s", "Cpf_s", "Major_s", "Year_s", "FirstName_s", "LastName_s"],
        "Enrollments" => ["StudentID_e", "Offering_e"],
    ];




    if (!array_key_exists($table, $fields)) {
        echo "<p>Invalid table selected.</p>";
        return;
    }
    // We need the columns for the given table to implement the insertion correctly
    $columnQuery = "SHOW COLUMNS FROM $table";
    $columnResult = mysqli_query($dbc, $columnQuery);
    $columns = [];

    while($row = mysqli_fetch_assoc($columnResult)) {
        if($row['Extra'] != 'auto_increment') {
            $columns[] = $row['Field'];
        }
    }

    $values = [];

    //remove dots and dashes from CPF
    if(isset($_POST["Cpf_s"])) {
        $cpf = str_replace(['.', '-'], '', $_POST["Cpf_s"]); 
        $_POST["Cpf_s"] = $cpf;
    }

    if ($table == "Instructor" || $table == "Student") {
        // strtolower(substr($table, 0, 1)) gives either "i" or "s" depending on the table
        $email = mysqli_real_escape_string($dbc, $_POST["Email_" . strtolower(substr($table, 0, 1))]);
        $emailQuery = "INSERT INTO Emails (EmailAddress) VALUES ('$email')";
        console_log("Email query is: ". $emailQuery);
        mysqli_query($dbc, $emailQuery);
        $emailID = mysqli_insert_id($dbc);
        console_log("Last added email is: ". $emailID);
        $values[] = $emailID;
    }

    foreach ($fields[$table] as $field) {
        // Skip Email field as we have already handled it
        if (($table == "Instructor" || $table == "Student") && $field == "Email_" . strtolower(substr($table, 0, 1))) {
            continue;
        }
        $value = mysqli_real_escape_string($dbc, $_POST[$field]);
        if (!is_numeric($value)) {
            $value = "'$value'"; // Enclose non-numeric values in quotes for the SQL query
        }
        $values[] = $value;
    }

    $query = "INSERT INTO $table (" . implode(", ", $columns) . ") VALUES (" . implode(", ", $values) . ")";

    console_log($query);

    error_reporting(E_ALL);
    ini_set("display_errors", 1);
    $result = mysqli_query($dbc, $query);

    if ($result) {
        echo "<div class='alert alert-success text-center' role='alert'>";
        echo "<p>A new record has been added to " . $table . "</p>";
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
            <label for="BuildingID_classroom">BuildingID:</label>
            <input type="text" class="form-control" name="BuildingID_classroom" id="BuildingID_classroom">
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
        <p>Please refer to the Course, Instructor, and Classroom tables for the correct CourseID, InstructorID, and
            ClassroomID.</p>
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
            <div class="form-group">

                <select class="form-control" id="Semester_co" name="Semester_co">
                    <option value="1">1</option>
                    <option value="2">2</option>
                </select>
            </div>
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
            <input type="text" class="form-control" name="OfferingID_g" id="OfferingID_g">
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
            <label for="Cpf_s">CPF:</label>
            <input type="text" class="form-control" name="Cpf_s" id="Cpf_s" maxlength="14">
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

$(document).ready(function () {
      $('#Cpf_s').inputmask("999.999.999-99");
      
    });

    // hiding all table fields on page load -- had to google this, since its javascript
    document.querySelectorAll('.table-fields').forEach(function (el) {
        el.style.display = 'none';
    });

    // showing table fields when the table is selected  -- had to google this, since its javascript
    // without this part, all fields are shown at all times, which is not ideal
    document.querySelector('select[name="table"]').addEventListener('change', function () {
        document.querySelectorAll('.table-fields').forEach(function (el) {
            el.style.display = 'none';
        });


        var table = this.value;
        let name = '#' + table;
        console.log("Showing table: " + this.value);
        document.querySelector("#" + table).style.display = 'block';
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