<?php
session_start();

// Include database configuration file
include 'config.php';

// Redirect to the login page if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Fetch user information based on ID
$driverID = $_SESSION['user_id'];

// Fetch user information from the database based on the user's ID
$query = "SELECT * FROM user WHERE user_id = '$driverID'";
$result = mysqli_query($connection, $query);

if (!$result) {
    die("Error executing the query: " . mysqli_error($connection));
}

$driverData = mysqli_fetch_assoc($result);

// Display success message if it exists
if (isset($_SESSION['success_message'])) {
    $successMessage = $_SESSION['success_message'];
    unset($_SESSION['success_message']); // Clear the session variable
}

// Fetch data from the b_up table
$sql = "SELECT * FROM b_up";
$result = mysqli_query($connection, $sql);

if (!$result) {
    die("Error in SQL query: " . mysqli_error($connection));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookings Notifications</title>
    <!-- Include Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="css/process2.css" rel="stylesheet">

    <style>
     
     .nav {
            display: flex;
            flex-direction: column;
            background-color: #2B6A48;
            padding: 20px;
            width: 140px; /* Adjust the width of the sidebar as needed */
            height: 100vh; /* Take full height of the viewport */
            box-sizing: border-box; /* Include padding and border in the height */
        }

        .nav a {
            text-decoration: none;
            color: white;
            padding: 10px;
            transition: background-color 0.3s ease;
            width: 100%; /* Take full width of the sidebar */
            box-sizing: border-box; /* Include padding and border in the width */
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

        /* Custom styles for the header */
        .header {
            background-color: #2B6A48; /* Change to the desired color */
            color: white;
            padding: 1rem;
            text-align: left;
        }
        .main-content {
        width: calc(150% - 150px); /* Adjust the margin based on the width of the leftnav */
        padding: 20px;
        margin-left: -20px;
        margin-top: -13px;
        background-color:#93CCAD;
    }
    </style>
</head>
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


<div class="main-content">
    <header class="header">
        <h1 class="text-2xl font-bold"> Approved Booking</h1>
    </header>

    <!-- Display success message if it exists -->
    <?php if (isset($successMessage)): ?>
        <div class="bg-green-200 text-green-800 p-3 mb-4 rounded">
            <?php echo $successMessage; ?>
        </div>
    <?php endif; ?>

    <?php
    if (mysqli_num_rows($result) > 0) {
        while ($booking = mysqli_fetch_assoc($result)) {
            ?>
            <div class="notification bg-white shadow-md p-4 mb-4">
                 <p> Your approved the booked of: </p>
                    <strong>Username:</strong> <?php echo $booking['username']; ?><br>
                    <strong>Current Location:</strong> <?php echo $booking['current_location']; ?><br>
                    <strong>Destination:</strong> <?php echo $booking['destination']; ?><br>
                    <strong>Fare:</strong> <?php echo $booking['fare']; ?><br>
                    <strong>Current Time/Date:</strong> <?php echo $booking['current_timedate']; ?><br>
                    <strong>Action:</strong> <?php echo $booking['action']; ?><br>
            <?php
        }
    } else {
        echo "<p class='text-gray-600'>No bookings found.</p>";
    }
    ?>
</div>

</body>
</html>
