<?php
// getdriver.php

$host = "localhost";
$dbname = "trigo";
$username = "root";
$password = "";

// Create connection
$your_database_connection = mysqli_connect($host, $username, $password, $dbname);

if (!$your_database_connection) {
    die("Connection failed: " . mysqli_connect_error());
}

$query = "SELECT * FROM driver";
$result = mysqli_query($your_database_connection, $query);

$drivers = array();

while ($row = mysqli_fetch_assoc($result)) {
    $driver = array(
        'driver_id' => $row['driver_id'],
        'first_name' => $row['first_name'],
        'last_name' => $row['last_name'],
        'plate_number' => $row['plate_number'],
        'status' => $row['status'] // Include the 'status' field
    );
    $drivers[] = $driver;
}

// Output the result as JSON
header('Content-Type: application/json');
echo json_encode($drivers);

mysqli_close($your_database_connection);
?>
