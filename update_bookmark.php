<?php
require_once('mysqli_connect.php');
$id = mysqli_real_escape_string($dbc, $_POST['id']);
$title = mysqli_real_escape_string($dbc, $_POST['title']);
$url = mysqli_real_escape_string($dbc, $_POST['url']);
$comment = mysqli_real_escape_string($dbc, $_POST['comment']);
$query = "UPDATE bookmark SET title='$title', url='$url', comment='$comment' WHERE id=$id";
$result = @mysqli_query($dbc, $query);
if ($result) {
    echo "<p><b>The selected record has been updated.</b></p>";
    echo "<a href=index.php>Home</a>";
} else {
    echo "<p>The record could not be updated due to a system error" . mysqli_error($dbc) . "</p>";
}
mysqli_close($dbc);
?>