<?php
$host = "localhost";
$dbname = "trigo";
$username = "root";
$password = "";

// Create connection using object-oriented style
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch travel data from the "travel" table
$sql = "SELECT * FROM travel";
$result = $conn->query($sql);

// Check if there is any data
if ($result && $result->num_rows > 0) {
    // Fetch data as an associative array
    $travelData = array();
    while ($row = $result->fetch_assoc()) {
        $travelData[] = $row;
    }

    // Close the database connection
    $conn->close();

    // Return travel data as JSON
    header('Content-Type: application/json');
    echo json_encode($travelData);
} else {
    // No data found
    echo json_encode(array());
}
?>
