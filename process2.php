<?php
session_start();

// Include database configuration file
include 'config.php';

// Redirect to the login page if the user is not logged in
if (!isset($_SESSION['driver_id'])) {
    header("Location: Dlogin.php");
    exit;
}

// Fetch user information based on ID
$driverID = $_SESSION['driver_id'];

// Fetch user information from the database based on the user's ID
$query = "SELECT * FROM driver WHERE driver_id = '$driverID'";
$result = mysqli_query($connection, $query);

if (!$result) {
    die("Error executing the query: " . mysqli_error($connection));
}

$driverData = mysqli_fetch_assoc($result);

// Fetch data from the database
$sql = "SELECT * FROM booking";
$result = mysqli_query($connection, $sql);

if (!$result) {
    die("Error executing the query: " . mysqli_error($connection));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Registration</title>
</head>
<body>
<style>
        <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #93CCAD;
            margin: 0;
            padding: 0;
            display: flex;
            min-height: 100vh;
        }

        .nav {
            display: flex;
            flex-direction: column;
            background-color: #2B6A48;
            padding: 10px;
            width: 140px;
            height: 100vh;
            box-sizing: border-box;
            font: arial;
            margin-left:-7px;
        }

        .nav a {
            text-decoration: none;
            color: white;
            padding: 10px;
            width: 100%;
            box-sizing: border-box;
        }

        .nav a:hover {
            background-color: #93CCAD;
        }

        .dropdown {
            display: inline-block;
        }

        .dropbtn {
            background-color: #2B6A48;
            color: white;
            padding: 10px;
            font-size: 16px;
            border: none;
            cursor: pointer;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #93CCAD;
            box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
            z-index: 1;
            width: 100px;
            box-sizing: border-box;
        }

        .dropdown-content a {
            color: white;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #ddd;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .notif {
            background-color: #2B6A48;
            margin-left: 130px;
            margin-top:-740px;
            padding: 20px;
            border-radius: 8px;
            color:white;
            font: arial;
        
        }

        .notif2 {
            margin-top: 20px;
            margin-LEFT:150PX ;
         
        }

        .notification {
            background-color: #93CCAD;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .notification strong {
            display: block;
            margin-bottom: 10px;
        }

        .button {
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            display: flex;
           
        }
        

.button button {
    margin-right: 10px; /* Adjust the margin to control the space between buttons */
}

.inline-form {
    display: inline-block;
}
        .bg-green-500 {
            background-color: #4CAF50;
        }

        .bg-red-500 {
            background-color: #f44336;
        }

        .bg-blue-500 {
            background-color: #2196F3;
        }

        .text-white {
            color: white;
        }

        .text-gray-600 {
            color: #666;
        }
    </style>
<header>
   
<body class="flex">
    <!-- Navigation Sidebar -->
    <div class="nav">
        <div class="menu-icon" onclick="toggleNav()">☰</div>
        <a href="landingpage.php">Home</a>
        <a href="driverprofile.php">Profile</a>
        <a href="process2.php">Notification</a>
        <div class="dropdown">
            <button class="dropbtn">Booking History</button>
            <div class="dropdown-content">
                <a href="accepthistory.php">Accept Booking</a>
                <a href="#">Declined Booking </a>
            </div>
        </div>
        <a href="#">Contact</a>
        <a href="landingpage.php">Logout</a>
    </div>

    <section class="p-4">
        <!-- Content for the section goes here -->
    </section>

    <div class="notif">
        <h2 class="text-2xl font-bold mb-4">Bookings Notifications</h2>
        <strong class="block mb-2 text-lg">Your Current location is : <?php echo $driverData['driver_location']; ?></strong>

    </div>

    <div class= notif2>
    <?php
if (mysqli_num_rows($result) > 0) {
    while ($booking = mysqli_fetch_assoc($result)) {
        ?>
        <div class="notification bg-white shadow-md p-4 mb-4">
        <p> You can Confirmed the booking</p>
            <strong class="block mb-2 text-lg">Passenger: <?php echo $booking['username']; ?></strong>
            <strong>Current Location:</strong> <?php echo $booking['current_location']; ?><br>
            <strong>Destination:</strong> <?php echo $booking['destination']; ?><br>
            <strong>Fare :</strong> <?php echo $booking['fare']; ?><br>
            <strong>Current Time/Date:</strong> <?php echo $booking['current_timedate']; ?><br>
            <strong>Number of passenger:</strong> <?php echo $booking['numpass']; ?><br>

            <!-- Container for buttons with flex display -->
            <div class="button">
    <!-- Add buttons for accept, decline, and edit -->
    <form method="post" action="accept.php" class="inline-form" onsubmit="showAlert()">
        <input type="hidden" name="booking_id" value="<?php echo $booking['booking_id']; ?>">
        <button type="submit" class="button bg-green-500 text-white px-4 py-2 inline-block mr-2">Accept</button>
    </form>

    

</div>
<!-- End of button container -->

<script>
    function showAlert() {
        alert("You approved the destination. You have 5 seconds to decline.");
    }

    function startTimer() {
        setTimeout(function () {
            alert("Time's up! You didn't decline within 5 seconds.");
        }, 5000);
    }
</script>
        <?php
    }
} else {
    echo "<p class='text-gray-600'>No bookings found.</p>";
}
?>

    
</div>

</body>
</html>
