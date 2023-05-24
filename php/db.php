<?php
//make connection with database
$servername = "85942_database";
$username = "85942";
$password = "h*a2Pc346";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

?>