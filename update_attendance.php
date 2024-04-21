<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Establish database connection (replace these values with your actual database credentials)
$hostName = "sql312.infinityfree.com";
$dbUser = "if0_36313219";
$dbPassword = "zZZhkwieZwJhE0";
$dbName = "if0_36313219_loginform";

// Create connection
$conn = new mysqli($hostName, $dbUser, $dbPassword, $dbName);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_POST["attendance_text"])) {
    die("Attendance data not received.");
}

// Get attendance data from the client-side
$attendanceText = $_POST["attendance_text"];

// Split the attendance text into individual records
$records = explode("\n", $attendanceText);


// Prepare a statement to insert attendance records
$stmt = $conn->prepare("INSERT INTO daily_attendance (date, roll_number, attendance) VALUES (?, ?, ?)");

// Check if the statement was prepared successfully
if (!$stmt) {
    die("Error preparing statement: " . $conn->error);
}

// Check the format of the $records array
// var_dump($records);

foreach ($records as $record) {
    // Split the record into roll number and attendance
    list($rollNumber, $attendance) = explode(",", $record);

    // Trim whitespace from the values
    $rollNumber = trim($rollNumber);
    $attendance = trim($attendance);

    // Check if roll number is empty, if so, skip this record
    if (empty($rollNumber)) {
        continue;
    }

    // Get the current date in the format YYYY-MM-DD
    $date = date("Y-m-d");

    // Echo the roll number to console (for debugging)
    // echo "Roll Number: $rollNumber\n";

    // Execute the prepared statement with the attendance data
    $stmt->bind_param("sss", $date, $rollNumber, $attendance);
    $stmt->execute();

    // Check if the execution was successful
    if ($stmt->affected_rows === -1) {
        die("Error executing statement: " . $stmt->error);
    }


    // Check for errors during insert operation
    if ($stmt->errno) {
        die("Error executing statement: " . $stmt->error);
    }
}



// Close the statement
$stmt->close();

// Close the database connection
$conn->close();

// Send a response back to the client
echo "Attendance updated successfully!";
?>