<html>

<body>

    <?php
    include("header.html");
    require_once('./log.php');
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    
    // establishing connection
    require_once('mysqli_connect.php');
    ?>
    <div class="container mt-3">
        <div class='d-flex justify-content-center align-items-center'>
            <!-- Wrap the form and the button inside another div -->
            <div>
                <!-- creating a form to search the database and adding a drop-down menu -->
                <form action="index.php" method="post" class="form-inline">
                    <label for="query" class="mr-2">Search:</label>
                    <input name="query" size="50" class="form-control mr-2">
                    <select name="table" class="custom-select mr-2">
                        <option value="AcademicCredits">Academic Credits</option>
                        <option value="Classroom">Classroom</option>
                        <option value="Course">Course</option>
                        <option value="CourseOfferings">Course Offerings</option>
                        <option value="Department">Department</option>
                        <option value="Enrollments">Enrollments</option>
                        <option value="Grade">Grade</option>
                        <option value="Instructor">Instructor</option>
                        <option value="Student">Student</option>
                    </select>
                    <input type="submit" value="search" class="btn btn-primary">
                </form>
                <p><a href="add.php" class="btn btn-primary mt-3">Add a new record</a></p>
            </div>
        </div>
        <?php
        // different queries according to selection
        $query = null;

        // todo: inverter esse if, para que o select base seja padrão para a consulta de dada tabela, mas se existir uma query, o where é adicionado no sql
        
        if (!empty($_POST['query'])) {
            echo "<p>Search results for: <strong>" . $_POST['query'] . "</strong></p>";
            

            $search = $_POST['query'];
            // input sanitization: avoid SQL injection
            $search = strip_tags($search); // remove html tags
            $search = mysqli_real_escape_string($dbc, $search); // remove special character
            
            $table = mysqli_real_escape_string($dbc, $_POST['table']);
            $table = strip_tags($table);

            switch ($table) {
                case 'AcademicCredits':
                    $query = "SELECT * FROM AcademicCredits WHERE CreditID LIKE '%$search%'
                      OR (OfferingID LIKE '%$search%')
                      OR (Credits LIKE '%$search%')";
                    break;
                case 'Classroom':
                    $query = "SELECT * FROM Classroom WHERE ClassroomID LIKE '%$search%'
                      OR (Building LIKE '%$search%')
                      OR (RoomNum LIKE '%$search%')
                      OR (Capacity LIKE '%$search%')";
                    break;
                case 'Course':
                    $query = "SELECT * FROM Course WHERE CourseID LIKE '%$search%'
                      OR (CourseName LIKE '%$search%')
                      OR (DepartmentID LIKE '%$search%')";
                    break;
                case 'CourseOfferings':
                    // TODO: colocar o building aqui quando for feito, e redefinir a view para tê-lo
                    $query = "
                    SELECT *
                    FROM CourseOfferingsView
                    WHERE CourseName LIKE '%$search%'
                    OR InstructorName LIKE '%$search%'
                    OR ClassroomName LIKE '%$search%'
                    ";
                    console_log($query);
                    break;
            
                case 'Department':
                    $query = "SELECT * FROM Department WHERE DepartmentID LIKE '%$search%'
                      OR (DepartmentName LIKE '%$search%')";
                    break;
                case 'Enrollments':
                    $query = "SELECT * FROM Enrollments WHERE EnrollmentID LIKE '%$search%'
                      OR (StudentID LIKE '%$search%')
                      OR (OfferingID LIKE '%$search%')";
                    break;
                case 'Grade':
                    $query = "SELECT * FROM Grade WHERE GradeID LIKE '%$search%'
                      OR (GradeValue LIKE '%$search%')
                      OR (StudentID LIKE '%$search%')
                      OR (OfferingID LIKE '%$search%')";
                    break;
                case 'Instructor':
                    $query = "SELECT * FROM Instructor WHERE InstructorID LIKE '%$search%'
                      OR (DepartmentID LIKE '%$search%')
                      OR (Email LIKE '%$search%')
                      OR (FirstName LIKE '%$search%')
                      OR (LastName LIKE '%$search%')";
                    break;
                case 'Student':
                    $query = "SELECT * FROM Student WHERE StudentID LIKE '%$search%'
                      OR (Email LIKE '%$search%')
                      OR (Major LIKE '%$search%')
                      OR (FirstName LIKE '%$search%')
                      OR (LastName LIKE '%$search%')
                      OR (Year LIKE '%$search%')";
                    break;
                default:
                    //echo "Table: $table";
                    echo "Doing default case";
                    $table = mysqli_real_escape_string($dbc, $_POST['table']);
                    $query = "SELECT * FROM $table";
                    break;
            }
        } else {

            // return if there was no requested table
            if (!isset($_POST['table'])) {
                return;
            }

            $table = mysqli_real_escape_string($dbc, $_POST['table']);
            //TODO: append the 'view' suffix, as all tables will have a view
            $query = "SELECT * FROM $table";
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
</body>

</html>