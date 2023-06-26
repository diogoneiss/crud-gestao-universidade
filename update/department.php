<?php
// department.php

include("../header.html");
require_once("../mysqli_connect.php");

$id = $_GET['id'];

// Query to get the Department record by DepartmentID
$query = "SELECT * FROM Department WHERE DepartmentID = ?";
$stmt = $dbc->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$department = $result->fetch_assoc();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Department</title>
</head>
<body>
    <div class="container">
        <h2 class="mt-5">Update Department</h2>
        <form action="department_update_process.php" method="post">
            <input type="hidden" name="DepartmentID" value="<?php echo $department['DepartmentID']; ?>">

            <div class="form-group">
                <label for="DepartmentName">Department Name:</label>
                <input type="text" class="form-control" name="DepartmentName" id="DepartmentName" value="<?php echo $department['DepartmentName']; ?>" required>
            </div>

            <button type="submit" name="submit" class="btn btn-primary">Atualizar Departamento</button>
            <a href="index.php" class="btn btn-secondary">Cancela</a>
        </form>
    </div>
</body>
</html>
<?php
mysqli_free_result($result);
$dbc->close();
?>
