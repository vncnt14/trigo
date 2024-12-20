<?php
include 'config.php';

// Check if the user is logged in, redirect to login.php if not
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

// Retrieve user information from the database based on the user_id in the session
$user_id = $_SESSION["user_id"];
$query = "SELECT * FROM user"; // Update with the correct table name
$result = mysqli_query($connection, $query);

if ($result) {
    $user = mysqli_fetch_assoc($result);
} else {
    // Handle the error, and consider redirecting or displaying a message
    die("Error retrieving user information: " . mysqli_error($connection));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <!-- Add Tailwind CSS link here -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <style>
        /* Your existing styles here */

        .image img {
            max-width: 100%;
            max-height: 200px;
            border-radius: 50%;
            margin-left: 50px;
        }

        /* Updated styles for the welcome heading */
        .welcome-heading {
            background-color: #2B6A48;
            color: white;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 8px;
            text-align: center;
        }
    </style>
</head>
<body class="flex">
    <!-- Navigation Sidebar -->
    <!-- Your existing navigation code here -->

    <div class="notif2">
    <?php
    if (mysqli_num_rows($result) > 0) {
        while ($booking = mysqli_fetch_assoc($result)) {
            ?>
            <div class="notification bg-white shadow-md p-4 mb-4">
                <p>You can confirm the booking</p>
                <strong class="block mb-2 text-lg">Username: <?php echo $booking['username']; ?></strong>
                <strong>Current Location:</strong> <?php echo $booking['current_location']; ?><br>
                <strong>Destination:</strong> <?php echo $booking['destination']; ?><br>
                <strong>Fare:</strong> <?php echo $booking['fare']; ?><br>
                <strong>Current Time/Date:</strong> <?php echo $booking['current_timedate']; ?><br>
                <strong>Number of passengers:</strong> <?php echo $booking['numpass']; ?><br>

                <!-- Container for buttons with flex display -->
                <div class="button">
                    <!-- Add buttons for accept, decline, and edit -->
                    <form method="post" action="accept.php" class="inline-form">
                        <input type="hidden" name="booking_id" value="<?php echo $booking['booking_id']; ?>">
                        <button type="submit" class="button bg-green-500 text-white px-4 py-2 inline-block mr-2">Accept</button>
                    </form>

                    <form method="post" action="decline.php" class="inline-form">
                        <input type="hidden" name="booking_id" value="<?php echo $booking['booking_id']; ?>">
                        <button type="submit" class="button bg-red-500 text-white px-4 py-2 inline-block mr-2" onclick="startTimer()">Remove</button>
                    </form>
                </div>
                <!-- End of button container -->
            </div>
        <?php
        }
    }
    ?>
    </div>
    <!-- Your existing HTML code here -->
</body>
</html>
