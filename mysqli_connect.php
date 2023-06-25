<?php
// This file contains the database access information.
// This file also establishes a connection to MySQL,
// selects the database, and sets the encoding.


//Set the database access information as constants:
DEFINE('DB_USER', 'root');
DEFINE('DB_PASSWORD', '');
DEFINE('DB_HOST', 'localhost');
DEFINE('DB_NAME', 'crud_project');

// Make the connection:
$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// Check connection
if (!$dbc) {
    die("Connection error, you probably forgot to setup the MySQL database. Check the info in the README.md file." . mysqli_connect_error());
}


?>