<?php
// student_update_process.php

// Database connection
require_once('../mysqli_connect.php');
require_once('../log.php');
include("../header.html");
// Check if the form was submitted
if (isset($_POST['submit'])) {
  // Get the submitted form data
  console_log($_POST);

  $StudentID = $_POST['StudentID'];
  $Email = $_POST['Email'];
  $Major = $_POST['Major'];
  $Year = $_POST['Year'];
  $FirstName = $_POST['FirstName'];
  $LastName = $_POST['LastName'];
  $cpf = str_replace(['.', '-'], '', $_POST["Cpf"]);
  //convert to int
  $cpf = (int)$cpf;

  //First, check if the email was updated. If it was, update the email table for the student EmailId
  $checkEmailSql = "SELECT * FROM Student JOIN Emails on Emails.EmailID = Student.EmailID WHERE StudentID = ?";

  $stmt = $dbc->prepare($checkEmailSql);
  $stmt->bind_param("i", $StudentID);
  $stmt->execute();
  $result = $stmt->get_result();
  $row = $result->fetch_assoc();

  $emailID = $row['EmailID'];
  $oldEmail = $row['EmailAddress'];

  if ($oldEmail !== $Email) {
    console_log("Email was updated. Email was ". $oldEmail . " and is now " . $Email);
    // If it was, update the Emails table for the student EmailID.
    $updateEmailSql = "UPDATE Emails SET EmailAddress = ? WHERE EmailID = ?";
    $stmt = $dbc->prepare($updateEmailSql);
    $stmt->bind_param("si", $Email, $emailID);
    $stmt->execute();
  }



  // Update the record in the database
  $sql = "UPDATE Student SET CPF = ?,  Major = ?, Year = ?, FirstName = ?, LastName = ? WHERE StudentID = ?";
  console_log("Update sql is " . $sql);
  $stmt = $dbc->prepare($sql);
  $stmt->bind_param("isissi", $cpf, $Major, $Year, $FirstName, $LastName, $StudentID);
  $result = $stmt->execute();

  echo "
  <body>
  <div class='container'>";
  if ($result) {
    // Success message and button to return to homepage
    echo "<div class='alert alert-success mt-5' role='alert'>
            <h4 class='alert-heading'>Success!</h4>
            <p>Record updated successfully.</p>
            
          ";
  } else {
    echo "<div class='alert alert-danger mt-5' role='alert'>
    <h4 class='alert-heading'>Error!</h4>
            Error updating record: " . $dbc->error . "
          ";
  }
  echo "
  <hr>
  <a href='../index.php' class='btn btn-primary'>Return to Home</a>
  </div>
  ";
  // End HTML output
  echo "</div></body></html>";

  $stmt->close();
}

$dbc->close();
?>