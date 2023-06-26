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

// Fetch all buildings for the dropdown
$sql_buildings = "SELECT * FROM Building";
$buildings_result = $dbc->query($sql_buildings);


?>
<body>
    <div class="container">
        <h2 class="mt-5">Update Classroom</h2>
        <form action="classroom_update_process.php" method="post">
            <input type="hidden" name="ClassroomID" value="<?php echo $classroom['ClassroomID']; ?>">

            <div class="form-group">
                <label for="Building">Building:</label>
                <select name="Building" id="Building" class="form-control">
                  <?php
                  while ($building = $buildings_result->fetch_assoc()) {
                    $selected = '';
                    if ($building['BuildingName'] == $classroom['Building']) {
                        $selected = 'selected';
                    }
                    echo "<option value='".$building['BuildingName']."' ".$selected.">".$building['BuildingName']."</option>";
                  }
                  ?>
                </select>
            </div>

            <div class="form-group">
                <label for="RoomNum">Room Number:</label>
                <input type="number" class="form-control" id="RoomNum" name="RoomNum" value="<?php echo $classroom['RoomNum']; ?>">
            </div>

            <div class="form-group">
                <label for="Capacity">Capacity:</label>
                <input type="number" class="form-control" id="Capacity" name="Capacity" value="<?php echo $classroom['Capacity']; ?>">
            </div>

            <button type="submit" name="submit" class="btn btn-primary">Atualizar Sala</button>
            <a href="index.php" class="btn btn-secondary">Cancela</a>
        </form>
    </div>
</body>
<?php
mysqli_free_result($result);
$dbc->close();
?>
