<?php
// update/student.php
include ("../header.html");
// Database connection
require_once('../mysqli_connect.php');
require_once('../log.php');
// Fetch the record with the given id
$id = $_GET['id'];
$sql = "SELECT * FROM Student WHERE StudentID = ?";
$stmt = $dbc->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$record = $result->fetch_assoc();

$stmt->close();

?>
<body>
  <div class="container">
    <h2 class="mt-4 mb-4">Update Student</h2>
    <form action="student_update_process.php" method="POST">
      <input type="hidden" name="StudentID" value="<?php echo $record['StudentID']; ?>">
      
      <div class="form-group">
        <label for="Email">Email:</label>
        <input type="email" class="form-control" name="Email" id="Email" value="<?php echo $record['Email']; ?>" required>
      </div>
      
      <div class="form-group">
        <label for="Major">Major:</label>
        <input type="text" class="form-control" name="Major" id="Major" value="<?php echo $record['Major']; ?>" required>
      </div>

      <div class="form-group">
        <label for="Year">Year:</label>
        <input type="number" class="form-control" name="Year" id="Year" min="1900" max="2099" step="1" value="<?php echo $record['Year']; ?>" required>
      </div>
      
      <div class="form-group">
        <label for="FirstName">First Name:</label>
        <input type="text" class="form-control" name="FirstName" id="FirstName" value="<?php echo $record['FirstName']; ?>" required>
      </div>
      
      <div class="form-group">
        <label for="LastName">Last Name:</label>
        <input type="text" class="form-control" name="LastName" id="LastName" value="<?php echo $record['LastName']; ?>" required>
</div>
<button type="submit" class="btn btn-primary" name="submit">Update Student</button>
</form>
</div>
</body>
</html>
<?php
$dbc->close();
?>