<?php
// academicCredits.php

include("../header.html");
require_once("../mysqli_connect.php");

$id = $_GET['id'];

// Query to get the Academic Credit record by CreditID
$query = "SELECT * FROM AcademicCredits WHERE CreditID = ?";
$stmt = $dbc->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$credit = $result->fetch_assoc();

// Query to get all the course offerings view
$query_offerings = "SELECT * FROM CourseOfferingsView";
$result_offerings = mysqli_query($dbc, $query_offerings);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Academic Credit</title>
</head>
<body>
    <div class="container">
        <h2 class="mt-5">Update Academic Credit</h2>
        <form action="academicCredits_update_process.php" method="post">
            <input type="hidden" name="CreditID" value="<?php echo $credit['CreditID']; ?>">

            <div class="form-group">
                <label for="Credits">Credits:</label>
                <input type="number" class="form-control" id="Credits" name="Credits" value="<?php echo $credit['Credits']; ?>" required>
            </div>

            <div class="form-group">
                <label for="OfferingID">Course Offering:</label>
                <select class="form-control" id="OfferingID" name="OfferingID">
                    <?php while ($row = mysqli_fetch_assoc($result_offerings)) { ?>
                        <option value="<?php echo $row['OfferingID']; ?>" <?php if ($row['OfferingID'] == $credit['OfferingID']) echo 'selected'; ?>>
                            <?php echo $row['CourseName'] . ' / ' . $row['InstructorName']. ', semester ' . $row['Semester'] . ' of ' . $row['Year']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <button type="submit" name="submit" class="btn btn-primary">Atualizar Créditos Acadêmicos</button>
            <a href="index.php" class="btn btn-secondary">Cancela</a>
        </form>
    </div>
</body>
</html>
<?php
mysqli_free_result($result);
mysqli_free_result($result_offerings);
$dbc->close();
?>
