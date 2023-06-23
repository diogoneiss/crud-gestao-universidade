<html>
<body>

<?php
include ("header.html");
require_once('./log.php');

require_once ('mysqli_connect.php');
?>
<div class="container mt-3">
    <div class='d-flex justify-content-center align-items-center'>
    <div>
<?php
if (isset($_GET['id']) && isset($_GET['table'])) {
    $rowId = intval($_GET['id']);
    $table = mysqli_real_escape_string($dbc, $_GET['table']);

   
    echo "<p>Are you sure you want to delete record with ID <strong>$rowId</strong> from the <strong>$table</strong> table?</p>";

    echo '<form action="delete.php" method="post">
            <input type="hidden" name="id" value="' . $rowId . '">
            <input type="hidden" name="table" value="' . $table . '">
            <input type="submit" value="Yes, delete" class="btn btn-danger mr-2">
          </form>';
    echo '<a href="index.php" class="btn btn-secondary">Cancel</a>';
} else {
    echo '<p>Invalid request. <a href="index.php">Go back to the index page</a>.</p>';
}
?>

    </div>
    </div>
</div>
</body>
</html>
