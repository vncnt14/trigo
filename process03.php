<?php
session_start();

$host = "localhost";
$dbname = "trigo";
$username = "root";
$password = "";

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data from the client-side (JavaScript)
$timeOfArrival = $_POST['timeOfArrival'];
$departureTime = $_POST['departureTime'];
$timeOfDestination = $_POST['timeOfDestination'];
$current_location = $_POST['current_location'];
$destination = $_POST['destination'];
$fare = $_POST['fare'];

// Insert data into the "travel" table using prepared statements
$sql = "INSERT INTO travel (current_location, destination, fare, time_arrival, departure_time, destination_arrival) 
        VALUES (?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Error preparing statement: " . $conn->error);
}

$stmt->bind_param("ssssss", $current_location, $destination, $fare, $timeOfArrival, $departureTime, $timeOfDestination);

if ($stmt->execute()) {
    echo "Record saved successfully";
} else {
    echo "Error: " . $stmt->error;
}

// Close the prepared statement and database connection
$stmt->close();
$conn->close();
?>
