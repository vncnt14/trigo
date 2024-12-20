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
$sqlBooking = "SELECT * FROM b_up";
$resultBooking = mysqli_query($connection, $sqlBooking);

if (!$resultBooking) {
    die("Error in SQL query: " . mysqli_error($connection));
}

// Fetch data from the travel_table
$sqlTravel = "SELECT * FROM travel";
$resultTravel = mysqli_query($connection, $sqlTravel);

if (!$resultTravel) {
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
        /* Your existing styles remain unchanged */
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

        /* Add styles for the modal */
        #detailsModal,
        #travelDetailsModal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 600px;
            height: 300px; /* Adjusted height for travel details modal */
            margin-left: 500px;
        }

        .modal-content {
            background-color: white;
            padding: 50px;
            border-radius: 5px;
            max-width: 500px;
            margin: 15% auto; /* Adjusted margin for vertical alignment */
            background-color: white;
        }

        .main-content {
            background-color: #93CCAD;
            width: 1500px;
        }

        /* Add styles for the modal */
        #bookingDetailsModal,
        #travelDetailsModal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 600px;
            height: 300px; /* Adjusted height for travel details modal */
            margin-left: 500px;
            z-index: 1000; /* Set a higher z-index value */
        }

        .modal-content {
            background-color: white;
            padding: 50px;
            border-radius: 5px;
            max-width: 500px;
            margin: 15% auto; /* Adjusted margin for vertical alignment */
            background-color: white;
        }
    </style>
</head>
<body class="flex">
    <!-- Navigation Sidebar -->
    <div class="nav">
        <div class="menu-icon" onclick="toggleNav()">☰</div>
        <a href=".php">Home</a>
        <div class="dropdown">
            <button class="dropbtn">Booking</button>
            <div class="dropdown-content">
                <a href="process1.php">Book</a>
                <a href="#">Booking History</a>
            </div>
        </div>
        <a href="notification.php">Notification</a>
        <a href="profile.php">Profile</a>
        <a href="#">Contact</a>
        <a href="landingpage.php">Logout</a>
    </div>

    <div class="main-content">
        <header class="header">
            <h1 class="text-2xl font-bold">Notifications</h1>
        </header>

        <!-- Display success message if it exists -->
        <?php if (isset($successMessage)): ?>
            <div class="bg-green-200 text-green-800 p-3 mb-4 rounded">
                <?php echo $successMessage; ?>
            </div>
        <?php endif; ?>

        <!-- Iterate over bookings and display details -->
        <?php
        if (mysqli_num_rows($resultBooking) > 0) {
            while ($booking = mysqli_fetch_assoc($resultBooking)) {
                ?>
                <div class="notification bg-white shadow-md p-4 mb-4">
                    <p>Your booking has been approved, The driver will arrive in 5 minutes</p>
                    <p></p>
                    <button class="text-blue-500" onclick="viewDetails(
                        '<?php echo $booking['username']; ?>',
                        '<?php echo $booking['current_location']; ?>',
                        '<?php echo $booking['destination']; ?>',
                        '<?php echo $booking['fare']; ?>',
                        '<?php echo $booking['current_timedate']; ?>',
                        '<?php echo $booking['action']; ?>'
                    )">View Booking Details</button>
                </div>
                <?php
            }
        } else {
            echo "<p class='text-gray-600'>No Approved bookings found.</p>";
        }

        // Iterate over travel data and display details
        if (mysqli_num_rows($resultTravel) > 0) {
            while ($travel = mysqli_fetch_assoc($resultTravel)) {
                ?>
                <div class="notification bg-white shadow-md p-4 mb-4">
                    <p>You have reached your destination</p>
                    <button class="text-blue-500" onclick="viewTravelDetails(
                        '<?php echo $travel['current_location']; ?>',
                        '<?php echo $travel['destination']; ?>',
                        '<?php echo $travel['time_arrival']; ?>',
                        '<?php echo $travel['departure_time']; ?>',
                        '<?php echo $travel['destination_arrival']; ?>',
                        '<?php echo $travel['fare']; ?>'
                    )">View to Add Payment</button>
                </div>
                <?php
              }
            } else {
                echo "<p class='text-gray-600'>No Approved Travel found.</p>";
            }
        ?>

        <!-- Add a hidden modal for detailed information -->
        <div id="detailsModal" style="display: none;">
            <div class="modal-content">
                <strong>Username: <span id="username"></span></strong><br>
                <strong>Current Location:</strong> <span id="currentLocation"></span><br>
                <strong>Destination:</strong> <span id="destination"></span><br>
                <strong>Fare :</strong> <span id="fare"></span><br>
                <strong>Current Time/Date:</strong> <span id="currentTimedate"></span><br>
                <strong>Booking:</strong> <span id="action"></span><br>
                
                <button class="bg-blue-500 text-white p-2 rounded hover:bg-blue-600" onclick="closeModal()">Close</button>
            </div>
        </div>

        <!-- Add a hidden modal for travel details -->
        <div id="travelDetailsModal" style="display: none;">
            <div class="modal-content">
                <strong>Current Location:</strong> <span id="currentLocationTravel"></span><br>
                <strong>Destination:</strong> <span id="destinationTravel"></span><br>
                <strong>Arrival Time:</strong> <span id="arrivalTime"></span><br>
                <strong>Departure Time:</strong> <span id="departureTime"></span><br>
                <strong>Destination Arrival:</strong> <span id="destinationArrival"></span><br>
                <strong> Total Fare :</strong> <span id="fareTravel"></span><br>
                <button class="bg-blue-500 text-white p-2 rounded hover:bg-blue-600" onclick="closeTravelModal()"> Add Pay</button>
            </div>
        </div>

        <!-- ... (unchanged script) -->
    </div>

    <script>
        function viewDetails(username, currentLocation, destination, fare, currentTimedate, action) {
            // Populate modal with fetched data
            document.getElementById('username').innerText = username;
            document.getElementById('currentLocation').innerText = currentLocation;
            document.getElementById('destination').innerText = destination;
            document.getElementById('fare').innerText = fare;
            document.getElementById('currentTimedate').innerText = currentTimedate;
            document.getElementById('action').innerText = action;

            // Show the modal by setting the 'display' style to 'block'
            document.getElementById('detailsModal').style.display = 'block';
        }

        function closeModal() {
            // Hide the modal by setting the 'display' style to 'none'
            document.getElementById('detailsModal').style.display = 'none';
        }

        function viewTravelDetails(currentLocation, destination, arrivalTime, departureTime, destinationArrival, fare) {
            // Populate travel modal with fetched data
            document.getElementById('currentLocationTravel').innerText = currentLocation;
            document.getElementById('destinationTravel').innerText = destination;
            document.getElementById('arrivalTime').innerText = arrivalTime;
            document.getElementById('departureTime').innerText = departureTime;
            document.getElementById('destinationArrival').innerText = destinationArrival;
            document.getElementById('fareTravel').innerText = fare;

            // Show the travel modal by setting the 'display' style to 'block'
            document.getElementById('travelDetailsModal').style.display = 'block';
        }

        function closeTravelModal() {
            // Hide the travel modal by setting the 'display' style to 'none'
            document.getElementById('travelDetailsModal').style.display = 'none';
        }
    </script>
</body>
</html>
