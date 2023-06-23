<?php
// update_instructor.php
include ("../header.html");
// Database connection
require_once('../mysqli_connect.php');
require_once('../log.php');
// Fetch the record with the given id
$id = $_GET['id'];
$sql = "SELECT * FROM Instructor WHERE InstructorID = ?";
$stmt = $dbc->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$record = $result->fetch_assoc();

// Close the statement
$stmt->close();

// Fetch all departments for the dropdown
$sql_departments = "SELECT * FROM Department";
$departments = $dbc->query($sql_departments);

// Display the update form with the current values
?>
<body>
  <div class="container">
    <h2 class="mt-4 mb-4">Update Instructor</h2>
    <form action="instructor_update_process.php" method="POST">
      <input type="hidden" name="InstructorID" value="<?php echo $record['InstructorID']; ?>">
      
      <div class="form-group">
        <label for="DepartmentID">Department:</label>
        <select class="form-control" name="DepartmentID" id="DepartmentID" required>
          <?php while($department = $departments->fetch_assoc()) { ?>
            <option value="<?php echo $department['DepartmentID']; ?>" <?php if($record['DepartmentID'] == $department['DepartmentID']) echo 'selected'; ?>><?php echo $department['DepartmentName']; ?></option>
          <?php } ?>
        </select>
      </div>
      
      <div class="form-group">
        <label for="Email">Email:</label>
        <input type="email" class="form-control" name="Email" id="Email" value="<?php echo $record['Email']; ?>" required>
      </div>
      
      <div class="form-group">
        <label for="FirstName">First Name:</label>
        <input type="text" class="form-control" name="FirstName" id="FirstName" value="<?php echo $record['FirstName']; ?>" required>
      </div>
      
      <div class="form-group">
        <label for="LastName">Last Name:</label>
        <input type="text" class="form-control" name="LastName" id="LastName" value="<?php echo $record['LastName']; ?>" required>
      </div>

      <button type="submit" class="btn btn-primary" name="submit">Update Instructor</button>
    </form>
  </div>
</body>
</html>
<?php
// Close the database connection
$dbc->close();
?>
