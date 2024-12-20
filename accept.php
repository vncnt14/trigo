<?php
// Include database configuration file
include 'config.php';

// Get the booking ID from the POST parameter
$booking_id = $_POST['booking_id'];

// Fetch booking information based on the booking ID
$query = "SELECT * FROM booking WHERE booking_id = '$booking_id'";
$result = mysqli_query($connection, $query);

if (!$result) {
    die("Error executing the query: " . mysqli_error($connection));
}

$booking = mysqli_fetch_assoc($result);

$insert_query = "INSERT INTO b_up (username, current_location, destination,fare, current_timedate, action)
                 VALUES ('{$booking['username']}', '{$booking['current_location']}', '{$booking['destination']}', 
                         '{$booking['fare']}', '{$booking['current_timedate']}', 'accepted')";

if (mysqli_query($connection, $insert_query)) {
    // Delete the booking record from the 'booking' table
    $delete_query = "DELETE FROM booking WHERE booking_id = '$booking_id'";
    mysqli_query($connection, $delete_query);

    // Redirect back to the notification page
    header("Location: process3.php");
    exit;
} else {
    echo "Error: " . $insert_query . "<br>" . mysqli_error($connection);
}

// Close the database connection
mysqli_close($connection);
?>
