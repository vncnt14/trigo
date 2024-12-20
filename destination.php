<?php
// Include the database configuration
include 'config.php';

// Fetch data from the daliao table based on the selected destination
if (isset($_GET['current_location']) && isset($_GET['destination'])) {
    $current_location = $_GET['current_location'];
    $destination = $_GET['destination'];

    // Ensure that $destination is a valid column name to prevent SQL injection
    $validColumns = ['Alambre', 'Bangkas', 'Crossing_Bayabas', 'Daliao', 'Public_Market', 'Lubogan', 'Davao_Central_College'];
    
    if (!in_array($destination, $validColumns)) {
        die("Invalid destination selected.");
    }

   // Use prepared statement to prevent SQL injection
$query = "SELECT $destination FROM Lubogan WHERE current_location = ?";
$stmt = mysqli_prepare($connection, $query);

if (!$stmt) {
    die("Error in preparing statement: " . mysqli_error($connection));
}

mysqli_stmt_bind_param($stmt, "s", $current_location);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

    if ($result) {
        $row = mysqli_fetch_assoc($result);

        if ($row) {
            $fareValue = $row[$destination];
            echo " " . $fareValue;
        } else {
            echo "No data found for the selected destination.";
        }
    } else {
        echo "Error fetching data: " . mysqli_error($connection);
    }

    // Close the prepared statement and the database connection
    mysqli_stmt_close($stmt);
    mysqli_close($connection);

    exit(); // Stop further execution
}

// Rest of your existing PHP code...
?>
