<html>
<?php
    include("header.html");
?>
    <?php

    require_once('./log.php');
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // establishing connection
    require_once('mysqli_connect.php');


    function mapToView($table)
    {
        $exceptions = ['Department', 'Building'];
        if (in_array($table, $exceptions)) {
            // These tables do not have a view, so return just the table name
            return $table;
        } else {
            // All other tables have a corresponding view, so append "View" to the table name
            return $table . 'View';
        }
    }



    ?>
    <div class="container mt-3">
        <div class='d-flex justify-content-center align-items-center'>
            <!-- Wrap the form and the button inside another div -->
            <div>
                <!-- creating a form to search the database and adding a drop-down menu -->
                <form action="index.php" method="post" class="form-inline" id="searchForm">
                    <label for="query" class="mr-2">Search:</label>
                    <input name="query" size="50" class="form-control mr-2" id="query">
                    <select name="table" class="custom-select mr-2" id="table" onchange="submitForm()">
                        <option value="AcademicCredits" <?= ($_POST['table'] ?? '') === 'AcademicCredits' ? 'selected' : ''; ?>>Academic Credits</option>
                        <option value="Building" <?= ($_POST['table'] ?? '') === 'Building' ? 'selected' : ''; ?>>Building
                        </option>
                        <option value="Classroom" <?= ($_POST['table'] ?? '') === 'Classroom' ? 'selected' : ''; ?>>
                            Classroom</option>
                        <option value="Course" <?= ($_POST['table'] ?? '') === 'Course' ? 'selected' : ''; ?>>Course
                        </option>
                        <option value="CourseOfferings" <?= ($_POST['table'] ?? '') === 'CourseOfferings' ? 'selected' : ''; ?>>Course Offerings</option>
                        <option value="Department" <?= ($_POST['table'] ?? '') === 'Department' ? 'selected' : ''; ?>>
                            Department</option>
                        <option value="Enrollments" <?= ($_POST['table'] ?? '') === 'Enrollments' ? 'selected' : ''; ?>>
                            Enrollments</option>
                        <option value="Grade" <?= ($_POST['table'] ?? '') === 'Grade' ? 'selected' : ''; ?>>Grade</option>
                        <option value="Instructor" <?= ($_POST['table'] ?? '') === 'Instructor' ? 'selected' : ''; ?>>
                            Instructor</option>
                        <option value="Student" <?= ($_POST['table'] ?? '') === 'Student' ? 'selected' : ''; ?>>Student
                        </option>
                    </select>
                    <input type="submit" value="search" class="btn btn-primary">
                </form>

                <p><a href="add.php" class="btn btn-primary mt-3">Add a new record</a></p>
            </div>
        </div>
        <?php
        // different queries according to selection
        $query = null;

        if (empty($_POST['table'])) {
            return;
        }

        console_log($_POST['table']);

        $table = mysqli_real_escape_string($dbc, strip_tags($_POST['table']));

        $correctTable = mapToView($table);

        $query = "SELECT * FROM `crud_project`.`$correctTable`";

        if (!empty($_POST['query'])) {

            echo "<p>Search results for: <strong>" . $_POST['query'] . "</strong></p>";

            $search = mysqli_real_escape_string($dbc, strip_tags($_POST['query']));

            $fields = [
                'Department' => ['DepartmentID', 'DepartmentName'],
                'Building' => ['BuildingID', 'BuildingName'],
                'CourseOfferingsView' => ['OfferingID', 'Semester', 'Year', 'CourseName', 'InstructorName', 'ClassroomName', 'DepartmentName', 'BuildingName'],
                'StudentView' => ['StudentID', 'Cpf', 'EmailAddress', 'Major', 'Year', 'StudentName'],
                'CourseView' => ['CourseID', 'CourseName', 'DepartmentName'],
                'InstructorView' => ['InstructorID', 'InstructorName', 'EmailAddress', 'DepartmentName'],
                'ClassroomView' => ['ClassroomID', 'BuildingName', 'RoomNum', 'Capacity'],
                'GradeView' => ['GradeID', 'GradeValue', 'StudentID', 'StudentName', 'OfferingID', 'CourseName', 'InstructorName', 'DepartmentName'],
                'AcademicCreditsView' => ['CreditID', 'Credits', 'OfferingID', 'CourseName', 'InstructorName', 'DepartmentName'],
                'EnrollmentsView' => ['EnrollmentID', 'StudentName', 'StudentID', 'OfferingID', 'CourseName', 'InstructorName', 'DepartmentName', 'Semester', 'Year']
            ];

            if (array_key_exists($correctTable, $fields)) {
                $whereClauses = array_map(function ($field) use ($search) {
                    return "$field LIKE '%$search%'";
                }, $fields[$correctTable]);

                $query .= " WHERE " . implode(" OR ", $whereClauses);
            }

            console_log($query);
        }




        // executing the query and assigning it to $result
        $result = mysqli_query($dbc, $query);

        // check if the query was executed successfully
        if (!$result) {
            echo "Query was: $query";
            die('Query failed: ' . mysqli_error($dbc));
        }

        // check if $result is a mysqli_result object
        if (!($result instanceof mysqli_result)) {
            die('Invalid query result');
        }

        $num = mysqli_num_rows($result);

        // executing the query and assigning it to $result
        $result = mysqli_query($dbc, $query);
        echo "<p> Table: <strong>$table</strong> </p>";
        // counting num of rows and assigning it to $num
        $num = mysqli_num_rows($result);
        $column_names = [];
        while ($column = mysqli_fetch_field($result)) {
            $column_names[] = $column->name;
        }

        if ($num > 0) {
            echo "<p>There are <strong>$num</strong> records</p>";
            echo '<table class="table table-striped table-hover">
            <thead class="thead-dark">
                <tr>';
            foreach ($column_names as $column) {
                echo "<th>$column</th>";
            }
            echo '    <th><strong>Update</strong></th>
                <th><strong>Delete</strong></th>
            </tr>
        </thead>
        <tbody>';
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                foreach ($column_names as $column) {
                    echo "<td>{$row[$column]}</td>";
                }
                $rowId = array_values($row)[0];
                echo "<td><a href='update.php?id=$rowId&table=$table' class='btn btn-warning btn-sm'>Update</a></td>
        <td><a href='delete_confirm.php?id=$rowId&table=$table' class='btn btn-danger btn-sm'>Delete</a></td>
              
          </tr>";
            }
            echo '</tbody>
    </table>';
        } else {
            echo "<p>No records found</p>";
        }

        mysqli_free_result($result);
        mysqli_close($dbc);
        ?>

    </div>

    <script>
        function submitForm() {
            if(document.getElementById("query").value === "") {
                document.getElementById("searchForm").submit();
            }
        }
    </script>
</body>

</html>