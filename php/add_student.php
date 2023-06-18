<?php
//error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Make connection with database
$dbname  = "85942_database";
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

// Check if the student already exists in the database
$sql = "SELECT * FROM Student WHERE roll_no = '$rollNo'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // Student already exists, perform an update
    $sql = "UPDATE students SET first_name = '$firstName', last_name = '$lastName' WHERE roll_no = '$rollNo'";
    if (mysqli_query($conn, $sql)) {
        echo "Student data updated successfully";
    } else {
        echo "Error updating student data: " . mysqli_error($conn);
    }
} else {
    // Student does not exist, perform an insert
    $sql = "INSERT INTO students (first_name, last_name, roll_no) VALUES ('$firstName', '$lastName', '$rollNo')";
    if (mysqli_query($conn, $sql)) {
        echo "Student data added successfully";
    } else {
        echo "Error adding student data: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
