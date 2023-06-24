<?php
// update/student.php
include("../header.html");
// Database connection
require_once('../mysqli_connect.php');
require_once('../log.php');
// Fetch the record with the given id
$id = $_GET['id'];
$id = mysqli_real_escape_string($dbc, $id);
$sql = "SELECT * FROM Student WHERE StudentID = ?";
$stmt = $dbc->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$record = $result->fetch_assoc();
$stmt->close();

//Fetch the email
$emailID = $record['EmailID'];
$emailID = mysqli_real_escape_string($dbc, $emailID);

$emailSql = "SELECT * FROM Emails WHERE EmailID = ?";
$stmt = $dbc->prepare($emailSql);
$stmt->bind_param("i", $emailID);
console_log("Email id for student " . $id . " is " . $emailID);

$stmt->execute();
$result = $stmt->get_result();
$email = $result->fetch_assoc();


$stmt->close();


?>

<body>
  <div class="container">
    <h2 class="mt-4 mb-4">Update Student</h2>
    <form action="student_update_process.php" method="POST">
      <input type="hidden" name="StudentID" value="<?php echo $record['StudentID']; ?>">

      <div class="form-group">
        <label for="Email">Email:</label>
        <input type="email" class="form-control" name="Email" id="Email" value="<?php echo $email['EmailAddress']; ?>"
          required>
      </div>
      <div class="form-group">
        <label for="Cpf">CPF:</label>
        <input type="text" class="form-control" value="<?php echo $record['Cpf']; ?>" name="Cpf" id="Cpf"
          maxlength="14">

      </div>
      <div class="form-group">
        <label for="Major">Major:</label>
        <input type="text" class="form-control" name="Major" id="Major" value="<?php echo $record['Major']; ?>"
          required>
      </div>

      <div class="form-group">
        <label for="Year">Year:</label>
        <input type="number" class="form-control" name="Year" id="Year" min="1900" max="2099" step="1"
          value="<?php echo $record['Year']; ?>" required>
      </div>

      <div class="form-group">
        <label for="FirstName">First Name:</label>
        <input type="text" class="form-control" name="FirstName" id="FirstName"
          value="<?php echo $record['FirstName']; ?>" required>
      </div>

      <div class="form-group">
        <label for="LastName">Last Name:</label>
        <input type="text" class="form-control" name="LastName" id="LastName" value="<?php echo $record['LastName']; ?>"
          required>
      </div>
      <button type="submit" class="btn btn-primary" name="submit">Update Student</button>
    </form>
  </div>
  <script>

    $(document).ready(function () {
      $('#Cpf').inputmask("999.999.999-99");
    });


  </script>

</body>

</html>
<?php
$dbc->close();
?>