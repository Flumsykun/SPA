<?php
//make connection with database
$servername = "85942_database";
$username = "85942";
$password = "h*a2Pc346";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve student data from the AJAX request
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$rollNo = $_POST['rollNo'];

// Insert student data into the database
$sql = "INSERT INTO students (first_name, last_name, roll_no) VALUES ('$firstName', '$lastName', '$rollNo')";
if (mysqli_query($conn, $sql)) {
    echo "Student data added successfully";
} else {
    echo "Error adding student data: " . mysqli_error($conn);
}

mysqli_close($conn);
?>