<?php
//error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Make connection with database
$dbname  = "85942_database";
$username = "85942";
$password = "h*a2Pc346";


// Query to fetch all students from the database
$query = "SELECT * FROM students";
$result = mysqli_query($connection, $query);

// Check if the query was successful
if ($result) {
    // Create an empty array to store the student data
    $students = array();

    // Fetch each row from the result set
    while ($row = mysqli_fetch_assoc($result)) {
        // Extract the relevant fields from the row
        $firstName = $row['firstName'];
        $lastName = $row['lastName'];
        $rollNo = $row['rollNo'];

        // Create an associative array representing a student
        $student = array(
            'firstName' => $firstName,
            'lastName' => $lastName,
            'rollNo' => $rollNo
        );

        // Add the student to the array
        $students[] = $student;
    }

    // Close the result set
    mysqli_free_result($result);

    // Convert the array to JSON format
    $jsonResponse = json_encode($students);

    // Set the response headers
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');

    // Send the JSON response back to the client
    echo $jsonResponse;
} else {
    // If the query failed, return an error message
    $error = mysqli_error($connection);
    echo "Error retrieving students: " . $error;
}

// Close the database connection
mysqli_close($connection);
?>