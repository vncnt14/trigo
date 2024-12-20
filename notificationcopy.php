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
        #detailsModal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 600px;
            height: 100px;
           
            margin-left:500px;
        }

        .modal-content {
            background-color: white;
            padding: 50px;
            border-radius: 5px;
            max-width: 500px;
            margin: 15% auto; /* Adjusted margin for vertical alignment */
            background-color: white;
        }
        .main-content{
            background-color: #93CCAD;
            width: 1500px;
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
        <a href="profile.phps">Profile</a>
        <a href="#">Contact</a>
        <a href="landingpage.php">Logout</a>
    </div>

    <div class="main-content">
        <header class="header">
            <h1 class="text-2xl font-bold">Bookings Notifications</h1>
        </header>

        <!-- Display success message if it exists -->
        <?php if (isset($successMessage)): ?>
            <div class="bg-green-200 text-green-800 p-3 mb-4 rounded">
                <?php echo $successMessage; ?>
            </div>
        <?php endif; ?>

        <!-- Add a hidden modal for detailed information -->
        <div id="detailsModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <strong>Username: <span id="username"></span></strong><br>
        <strong>Current Location:</strong> <span id="currentLocation"></span><br>
        <strong>Destination:</strong> <span id="destination"></span><br>
        <strong>KM Value:</strong> <span id="kmValue"></span><br>
        <strong>Fare Value:</strong> <span id="fareValue"></span><br>
        <strong>Current Time/Date:</strong> <span id="currentTimedate"></span><br>
        <strong>Number of passengers:</strong> <span id="numpass"></span><br>

        <!-- Accept Form -->
        <form method="post" action="accept.php" class="inline-form" onsubmit="showAlert()">
            <input type="hidden" name="booking_id" id="acceptBookingId" value="">
            <button type="submit" class="button bg-green-500 text-white px-4 py-2 inline-block mr-2">Accept</button>
        </form>

        <!-- Decline Form -->
        <form method="post" action="decline.php" class="inline-form">
            <input type="hidden" name="booking_id" id="declineBookingId" value="">
            <button type="submit" class="button bg-red-500 text-white px-4 py-2 inline-block mr-2" onclick="startTimer()">Decline</button>
        </form>
    </div>
</div>

<!-- Iterate over bookings and display details -->
<?php
if (mysqli_num_rows($result) > 0) {
    while ($booking = mysqli_fetch_assoc($result)) {
        ?>
        <div class="notification bg-white shadow-md p-4 mb-4">
            <p>Your have another Booking</p>
            <button class="text-blue-500" onclick="viewDetails(
                '<?php echo $booking['username']; ?>',
                '<?php echo $booking['current_location']; ?>',
                '<?php echo $booking['destination']; ?>',
                '<?php echo $booking['km_value']; ?>',
                '<?php echo $booking['fare_value']; ?>',
                '<?php echo $booking['current_timedate']; ?>',
                '<?php echo $booking['numpass']; ?>'
            )">View Details</button>
        </div>
        <?php
    }
} else {
    echo "<p class='text-gray-600'>No bookings found.</p>";
}
?>

<script>
    function viewDetails(username, currentLocation, destination, kmValue, fareValue, currentTimedate, numpass) {
        // Populate modal with fetched data
        document.getElementById('username').innerText = username;
        document.getElementById('currentLocation').innerText = currentLocation;
        document.getElementById('destination').innerText = destination;
        document.getElementById('kmValue').innerText = kmValue;
        document.getElementById('fareValue').innerText = fareValue;
        document.getElementById('currentTimedate').innerText = currentTimedate;
        document.getElementById('numpass').innerText = numpass; // Update to 'numpass'

        // Show the modal by setting the 'display' style to 'block'
        document.getElementById('detailsModal').style.display = 'block';
        
        // Set the booking ID for accept and decline forms
        document.getElementById('acceptBookingId').value = numpass; // Update to 'numpass'
        document.getElementById('declineBookingId').value = numpass; // Update to 'numpass'
    }

    function closeModal() {
        console.log("Close modal clicked.");

        // Hide the modal by setting the 'display' style to 'none'
        document.getElementById('detailsModal').style.display = 'none';
    }

    function startTimer() {
        // Add your timer logic here
        console.log("Timer started.");
    }
        </script>
    </div>
</body>
</html>
