<?php
session_start(); // Start the session

// Include your database connection code here (config.php)
include 'config.php';

// Check if the user is logged in, redirect to login.php if not
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

// Retrieve user information from the database based on the user_id in the session
$user_id = $_SESSION["user_id"];
$query = "SELECT * FROM user WHERE user_id = '$user_id'";
$result = mysqli_query($connection, $query);

if ($result) {
    $user = mysqli_fetch_assoc($result);
} else {
    // Handle the error, and consider redirecting or displaying a message
    die("Error retrieving user information: " . mysqli_error($connection));
}

// Retrieve booking details from the form
$current_time_date = $_POST['current_time_date'];
$current_location = $_POST['current_location'];
$destination = $_POST['destination'];
$fare = $_POST['fare']; // Assuming you have added the fare field in your form

// Insert booking details into the booking table
$insert_query = "INSERT INTO booking (user_id, username, current_location, destination, fare, current_timedate) 
                 VALUES ('$user_id', '{$user['username']}', '$current_location', '$destination', '$fare', '$current_time_date')";

if (mysqli_query($connection, $insert_query)) {
    echo "Booking saved successfully";
} else {
    echo "Error: " . $insert_query . "<br>" . mysqli_error($connection);
}

// Close the database connection
mysqli_close($connection);
?>
