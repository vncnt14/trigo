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

// Close the database connection
mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Details</title>
    
    <style>
        /* Reset some default styles for better consistency */
        body,  h2, ul, li, p, button {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            background-color:#93CCAD;
        }

        /* Global styles */
        body {
            font-family: Arial, sans-serif;
        }

        /* Header styles */
        header {
            background-color: #2B6A48;
            color: #fff;
            text-align: center;
            padding: 10px; /* Increased padding for better visibility */
            margin-top: -25px;
        }

        header h1 {
            margin-bottom: 10px; /* Added margin for better spacing */
        }

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


        /* Section styles */
        section {
            padding: 20px;
          width:750px;
            margin-left: 360px;
            margin-top:-650px;
            border:4px;
            background-color:white;
            border-radius:20px;
        }

        section h1 {
            color: #2B6A48;
            margin-bottom: 20px; /* Added margin for better spacing */
        } body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            background-color: #93CCAD;
        }

        section {
            padding: 20px;
            width: 750px;
            margin: 50px auto;
            border: 4px;
            background-color: white;
            border-radius: 20px;
            margin-left:200px;
            margin-top:-700px;
        }

        h1 {
            color: white;
            margin-bottom: 20px;
            text-align: center;
        }

        form {
            max-width: 600px;
            margin: 0 auto;
        }

        .label {
            font-weight: bold;
            margin-top: 10px;
            display: block;
        }

        .input-box,
        .value-box {
            margin-top: 10px;
        }

        select,
        input {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            margin-top: 5px;
        }

        .value-box {
            width: calc(100% - 16px);
            padding: 8px;
            box-sizing: border-box;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .submit-btn {
            padding: 10px;
            background-color: #2B6A48;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
            display: block;
            width: 100%;
            box-sizing: border-box;
        }

        .submit-btn:hover {
            background-color: #7DBB9E;
        }
    </style>
</head>
<body>
<header>
        <h1>Book Now</h1> 
    </header>
    <body class="flex">
    <!-- Navigation Sidebar -->
    <div class="nav">
        <div class="menu-icon" onclick="toggleNav()">☰</div>
        <a href=".php">Home</a>
        <div class="dropdown">
            <button class="dropbtn">Booking</button>
            <div class="dropdown-content">
                <a href="process1.php">Book Now</a>
                <a href="bookinghistory.php">Booking History</a>
            </div>
        </div>
        <a href="notification.php">Notification</a>
        <a href="profile.php">Profile</a>
        <a href="#">Contact</a>
        <a href="landingpage.php">Logout</a>
    </div>
    <section>
        <h1>Booking Details</h1>
        <form id="bookingForm" method="post" action="process01.php">

        <div class="label">TIME:</div>
            <div id="currentTime"></div>

            <div class="label">DATE:</div>
            <div id="currentDate"></div>

            <input type="hidden" id="current_time_date" name="current_time_date" value="">

            <div class="label">Current Location:</div>
            <div class="input-box">
                <select id="current_location" name="current_location">
                    <option value="Daliao">Daliao</option>
                    <option value="Lubogan">Lubogan</option>
                </select>
            </div>

            <div class="label">Destination:</div>
            <div class="input-box">
                <select id="destination" name="destination" onchange="calculateValues()">
                    <option value="Alambre"></option>
                    <option value="Alambre">Alambre</option>
                    <option value="Bangkas">Bangkas</option>
                    <option value="Crossing_Bayabas">Crossing Bayabas</option>
                    <option value="Daliao">Daliao</option>
                    <option value="Public_Market">Public Market</option>
                    <option value="Lubogan">Lubogan</option>
                    <option value="Davao_Central_College">Davao Central College</option>
                </select>
            </div>
        
<div class="value-box" id="fareResult" name="fare"></div>
<input type="hidden" id="fare" name="fare">

           

            <!-- Your existing form elements... -->

            <button type="button" class="submit-btn" onclick="proceedBooking()">PROCEED</button>
        </form>
    </section>

    <script>
        
        function updateClock() {
            var now = new Date();
            var hours = now.getHours();
            var minutes = now.getMinutes();
            var seconds = now.getSeconds();

            // Format the time
            var formattedTime = padZero(hours) + ":" + padZero(minutes) + ":" + padZero(seconds);

            // Display the time
            document.getElementById("currentTime").innerText = formattedTime;

            // Display the date
            var formattedDate = now.toLocaleDateString();
            document.getElementById("currentDate").innerText = formattedDate;

            // Set the date and time values
            document.getElementById("current_time_date").value = formattedDate + " " + formattedTime;
        }

        function padZero(number) {
            return number < 10 ? "0" + number : number;
        }

  {
    }
        

        // Call the updateClock function immediately
        updateClock();

        // Update the clock every second
        setInterval(updateClock, 1000);
        function calculateValues() {
        var currentLocation = document.getElementById("current_location").value;
        var destination = document.getElementById("destination").value;

        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (this.readyState == 4) {
                if (this.status == 200) {
                    var fare = this.responseText;

                    // Display the fare value in the 'fareResult' div
                    document.getElementById("fareResult").innerText = "Fare: " + fare;

                    // Set the fare value in the hidden input field for submission
                    document.getElementById("fare").value = fare;
                } else {
                    console.error("Error in AJAX request: Status " + this.status);
                }
            }
        };

        xhr.open("GET", "destination.php?current_location=" + currentLocation + "&destination=" + destination, true);
        xhr.send();
    }

        function displayDriverList() {
            // Your existing logic for displaying available drivers can go here
            // ...

            // For demonstration purposes, just displaying a static message
            alert("Displaying available drivers."); // Replace this with dynamic data

            // For demonstration, let's pick a driver with ID 123
            pickDriver(123);
        }

        function pickDriver(driverId) {
            // Send an AJAX request to record the booking and associate it with the selected driver
            // ...
        }
        function proceedBooking() {
        // Your existing logic for calculations or validations can go here
        // ...

        // Perform AJAX request to save booking details
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (this.readyState == 4) {
                if (this.status == 200) {
                    // Handle the response from the server, e.g., display a success message
                    alert(this.responseText);
                } else {
                    // Handle the error, e.g., display an error message
                    alert("Error: " + this.status);
                }
            }
        };

        // Get form data
        var formData = new FormData(document.getElementById("bookingForm"));

        // Send the AJAX request
        xhr.open("POST", "process01.php", true);
        xhr.send(formData);
    }
        // Your existing JavaScript code...
    </script>
</body>

</html>


