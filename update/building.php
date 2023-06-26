<?php
// Building.php

include("../header.html");
require_once("../mysqli_connect.php");

$id = $_GET['id'];

// Query to get the Building record by BuildingID
$query = "SELECT * FROM Building WHERE BuildingID = ?";
$stmt = $dbc->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$Building = $result->fetch_assoc();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Building</title>
</head>
<body>
    <div class="container">
        <h2 class="mt-5">Update Building</h2>
        <form action="building_update_process.php" method="post">
            <input type="hidden" name="BuildingID" value="<?php echo $Building['BuildingID']; ?>">

            <div class="form-group">
                <label for="BuildingName">Building Name:</label>
                <input type="text" class="form-control" name="BuildingName" id="BuildingName" value="<?php echo $Building['BuildingName']; ?>" required>
            </div>

            <button type="submit" name="submit" class="btn btn-primary">Update Building</button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>
<?php
mysqli_free_result($result);
$dbc->close();
?>
