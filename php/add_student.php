<?php
//make connection with database
$username = "85942";
$password = "h*a2Pc346";
$dbname = "85942_database";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve student data from the AJAX request
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$rollNo = $_POST['rollNo'];

// Prepare the SQL statement with placeholders
$sql = "INSERT INTO students (first_name, last_name, roll_no) VALUES (?, ?, ?)";

// Create a prepared statement
$stmt = mysqli_prepare($conn, $sql);

// Bind the values to the prepared statement
mysqli_stmt_bind_param($stmt, "sss", $firstName, $lastName, $rollNo);

// Execute the prepared statement
if (mysqli_stmt_execute($stmt)) {
    echo "Student data added successfully";
} else {
    echo "Error adding student data: " . mysqli_stmt_error($stmt);
}

// Close the prepared statement
mysqli_stmt_close($stmt);

?>