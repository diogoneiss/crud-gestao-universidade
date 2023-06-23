<?php
// classroom.php

include("../header.html");
require_once("../mysqli_connect.php");

$id = $_GET['id'];

// Query to get the Classroom record by ClassroomID
$query = "SELECT * FROM Classroom WHERE ClassroomID = ?";
$stmt = $dbc->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$classroom = $result->fetch_assoc();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Classroom</title>
</head>
<body>
    <div class="container">
        <h2 class="mt-5">Update Classroom</h2>
        <form action="classroom_update_process.php" method="post">
            <input type="hidden" name="ClassroomID" value="<?php echo $classroom['ClassroomID']; ?>">

            <div class="form-group">
                <label for="Building">Building:</label>
                <input type="text" class="form-control" id="Building" name="Building" value="<?php echo $classroom['Building']; ?>">
            </div>

            <div class="form-group">
                <label for="RoomNum">Room Number:</label>
                <input type="number" class="form-control" id="RoomNum" name="RoomNum" value="<?php echo $classroom['RoomNum']; ?>">
            </div>

            <div class="form-group">
                <label for="Capacity">Capacity:</label>
                <input type="number" class="form-control" id="Capacity" name="Capacity" value="<?php echo $classroom['Capacity']; ?>">
            </div>

            <button type="submit" name="submit" class="btn btn-primary">Update Classroom</button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>
<?php
mysqli_free_result($result);
$dbc->close();
?>
