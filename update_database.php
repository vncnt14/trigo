<?php
// Include the database configuration file
include 'config.php';

// Assuming travel_id is the identifier for the current travel record
if (isset($_POST['travel_id']) && isset($_POST['destination']) && isset($_POST['fare'])) {
    $travelId = $_POST['travel_id'];
    $destination = $_POST['destination'];
    $fare = $_POST['fare'];

    // Use prepared statement to prevent SQL injection
    $query = "UPDATE travel SET destination = ?, fare = ? WHERE travel_id = ?";
    $stmt = mysqli_prepare($connection, $query);

    if (!$stmt) {
        die("Error in preparing statement: " . mysqli_error($connection));
    }

    mysqli_stmt_bind_param($stmt, "ssi", $destination, $fare, $travelId);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) > 0) {
        echo "Database updated successfully!";
    } else {
        echo "No changes made to the database.";
    }

    // Close the prepared statement and the database connection
    mysqli_stmt_close($stmt);
    mysqli_close($connection);
} else {
    echo "Invalid request parameters.";
}
?>
