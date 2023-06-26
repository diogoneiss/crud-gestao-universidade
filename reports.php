<?php
require_once('mysqli_connect.php');
$id = $_GET['id'];
$query = "SELECT * FROM bookmark WHERE id=$id";
$result = @mysqli_query($dbc, $query);
$num = mysqli_num_rows($result);

while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
?>
 <form action ="update_bookmark.php" method="POST">
    <p>Title: <input type="text" name="title" size="50" value="<?php echo $row['title'];?>"></p><br>
    <p>URL: <input type="text" name="url" size="50" value="<?php echo $row['url'];?>"></p><br>
    <p>Comment:<br>
    <textarea name="comment" rows="5" cols="100"><?php echo $row['comment'];?></textarea></p>
    <br>
    <input type="submit" value="Update">
    <input type="reset" value="reset">
    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
</form>
<?php
}

mysqli_close($dbc);
?>