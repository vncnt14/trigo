<?php
// Start the session
session_start();

$host = "localhost";
$dbname = "trigo"; // Change the database name to "trigo"
$username = "root";
$password = "";

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data from the database
$sql = "SELECT * FROM b_up ORDER BY current_timedate DESC LIMIT 1";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    // Output data of the last booking
    $row = $result->fetch_assoc();
    $current_timedate = $row['current_timedate'];
    $current_location = $row['current_location'];
    $destination = $row['destination'];
    $fare = $row['fare'];
} else {
    // No booking data found
    $current_timedate = "";
    $current_location = "";
    $destination = "";
    $fare = "";
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <title>Travel Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #93CCAD;
        }

        header {
            background-color: #2B6A48;
            color: #fff;
            text-align: center;
            padding: 5px;
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
            margin-left: -7px;
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

        section {
            padding: 20px;
            box-sizing: border-box;
            margin-left: 300px;
            margin-top: -670px;
            width: 700px;
        }

        h1 {
            color: #2B6A48;
        }

        .label {
            font-weight: bold;
            margin-top: 10px;
        }

        .rectangle {
            background-color: #E5FEEF;
            padding: 15px;
            border-radius: 5px;
            margin-top: 10px;
        }

        .info {
            margin-top: 10px;
            text-align: left;
        }

        .clock-container {
            text-align: center;
            margin-top: 20px;
            font-size: 24px;
        }

        #startButton,
        #stopButton,
        #destinationButton {
            padding: 10px;
            background-color: #2B6A48;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }

        #startButton:hover,
        #stopButton:hover,
        #destinationButton:hover {
            background-color: #7DBB9E;
        }

        #stopButton:disabled,
        #destinationButton:disabled {
            background-color: #888;
            cursor: not-allowed;
        }

        #bookingTable,
        #departureTable,
        #destinationTable {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        #bookingTable th,
        #bookingTable td,
        #departureTable th,
        #departureTable td,
        #destinationTable th,
        #destinationTable td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        .button1 {
            background-color: #2B6A48;
            width: 10px;
            margin-left: 550px;
        }

        button:hover {
            background-color: #2B6A48;
        }

        .table {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        /* Add styles for the tables if needed */
        #bookingTable,
        #departureTable,
        #destinationTable {
            width: 100%;
            margin-top: 20px;
        }

        #bookingTable th,
        #departureTable th,
        #destinationTable th {
            background-color: #2B6A48;
            color: white;
            padding: 10px;
        }

        #bookingTable tbody,
        #departureTable tbody,
        #destinationTable tbody {
            /* Add styles for table body if needed */
        }

        .button1 {
            background-color: #2B6A48;
            color: white;
            padding: 5px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            margin-top: 20px;
            margin-left: 250px;
            width: 60px;
        }
    </style>
</head>

<body>
    <header>
        <h1>Your Profile</h1>
        <div class="info">
            <div class="menu-icon" onclick="toggleMenu()">
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
    </header>

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

    <section>
        <h1>Booking Details</h1>
        <form id="bookingForm" method="post" action="">
            <div class="rectangle">`
                <div class="label">TIME and DATE:</div>
                <div id="current_timedate" name="current_timedate"><?php echo $current_timedate; ?></div>

                <div class="label">BOOKING PASSENGER TICKET:</div>
                <div class="rectangle">
                    <div class="label">Current Location:</div>
                    <div id="current_location" name="current_location"><?php echo $current_location; ?></div>

                    <div class="label">Destination:</div>
                    <div id="destination" name="destination"><?php echo $destination; ?></div>
                </div>


                <div class="label">Fare:</div>
                <div id="fare" name="fare"><?php echo $fare; ?></div>
            </div>

            <div class="clock-container">
                <div class="label">Clock:</div>
                <div id="clock"></div>
                <button id="startButton" onclick="startClock()">Arrival</button>
                <button id="stopButton" onclick="stopClock()" disabled>Departure</button>
                <button id="destinationButton" onclick="startDestination()">Destination</button>
            </div>

            <div class="table">
                <!-- Table for Time of Arrival -->
                <table id="bookingTable">
                    <thead>
                        <tr>
                            <th>Time of Arrival</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Table content will be dynamically populated using JavaScript -->
                    </tbody>
                </table>

                <!-- Table for Departure Time -->
                <table id="departureTable">
                    <thead>
                        <tr>
                            <th>Departure Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Table content will be dynamically populated using JavaScript -->
                    </tbody>
                </table>

                <!-- Table for Time of Destination -->
                <table id="destinationTable">
                    <thead>
                        <tr>
                            <th>Destination Arrival</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Table content will be dynamically populated using JavaScript -->
                    </tbody>
                </table>

                <!-- Submit button -->
                <div class="button1">
                    <button type="button" onclick="saveToDatabase()">Submit</button>
                </div>
            </div>
        </form>
    </section>

    <script>
        let intervalId;
        let departureTime;
        let timeOfArrival;
        let timeOfDestination;

        function toggleMenu() {
            var menuIcon = document.querySelector('.menu-icon');
            var nav = document.querySelector('nav');

            menuIcon.classList.toggle('active');
            nav.style.display = (menuIcon.classList.contains('active')) ? 'block' : 'none';
        }

        function updateClock() {
            var now = new Date();
            var options = {
                timeZone: 'Asia/Manila',
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: 'numeric',
                minute: 'numeric',
                second: 'numeric',
                hour12: false,
            };
            var formattedTime = now.toLocaleString('en-PH', options);

            document.getElementById("clock").innerText = formattedTime;
        }

        function padZero(number) {
            return number < 10 ? "0" + number : number;
        }

        function startClock() {
            intervalId = setInterval(updateClock, 1000);
            if (!timeOfArrival) {
                timeOfArrival = new Date();
                saveToTable("Time of Arrival", timeOfArrival, "bookingTable");
            }
            departureTime = null; // Reset departureTime when starting the clock
            document.getElementById("startButton").disabled = true;
            document.getElementById("stopButton").disabled = false;
        }

        function startDestination() {
            intervalId = setInterval(updateClock, 1000);
            timeOfDestination = new Date();
            document.getElementById("startButton").disabled = true;
            document.getElementById("stopButton").disabled = false;
            document.getElementById("destinationButton").disabled = true;

            // Save destination time immediately
            saveToTable("Time of Destination", timeOfDestination, "destinationTable");
        }

        function stopClock() {
            clearInterval(intervalId);
            timeOfArrival = new Date();
            departureTime = new Date();

            document.getElementById("startButton").disabled = false;
            document.getElementById("stopButton").disabled = true;

            if (!timeOfArrival) {
                return;
            }

            if (!departureTime) {
                saveToTable("Time of Arrival", timeOfArrival, "bookingTable");
            } else {
                saveToTable("Departure Time", departureTime, "departureTable");
            }

            if (timeOfDestination) {
                saveToTable("Time of Destination", timeOfDestination, "destinationTable");
            }
        }

        function saveToTable(travelType, time, tableId) {
            var table = document.getElementById(tableId).getElementsByTagName('tbody')[0];
            var newRow = table.insertRow(table.rows.length);
            var cell1 = newRow.insertCell(0);
            var cell2 = newRow.insertCell(1);

            cell1.innerHTML = travelType;
            cell2.innerHTML = formatTime(time);
        }

        function formatTime(time) {
            var hours = time.getHours();
            var minutes = time.getMinutes();
            var seconds = time.getSeconds();
            return padZero(hours) + ":" + padZero(minutes) + ":" + padZero(seconds);
        }

        function saveToDatabase() {
    // Fetch other data from the form
    var current_location = document.getElementById("current_location").innerHTML;
    var destination = document.getElementById("destination").innerHTML;
    var fare = document.getElementById("fare").innerHTML;

    // Fetch the current_location and destination values
    console.log("Current Location:", current_location);
    console.log("Destination:", destination);

    var xhr = new XMLHttpRequest();
    var url = "process03.php";

    // Use Intl.DateTimeFormat to format the time with a specific time zone
    var timeOfArrivalString = timeOfArrival ? new Intl.DateTimeFormat('en-US', {
        timeZone: 'Asia/Manila',
        year: 'numeric',
        month: 'numeric',
        day: 'numeric',
        hour: 'numeric',
        minute: 'numeric',
        second: 'numeric',
        hour12: false,
    }).format(timeOfArrival) : "";

    var departureTimeString = departureTime ? new Intl.DateTimeFormat('en-US', {
        timeZone: 'Asia/Manila',
        year: 'numeric',
        month: 'numeric',
        day: 'numeric',
        hour: 'numeric',
        minute: 'numeric',
        second: 'numeric',
        hour12: false,
    }).format(departureTime) : "";

    var timeOfDestinationString = timeOfDestination ? new Intl.DateTimeFormat('en-US', {
        timeZone: 'Asia/Manila',
        year: 'numeric',
        month: 'numeric',
        day: 'numeric',
        hour: 'numeric',
        minute: 'numeric',
        second: 'numeric',
        hour12: false,
    }).format(timeOfDestination) : "";

    var params = "current_location=" + encodeURIComponent(current_location) +
        "&destination=" + encodeURIComponent(destination) +
        "&fare=" + encodeURIComponent(fare) +
        "&timeOfArrival=" + encodeURIComponent(timeOfArrivalString) +
        "&departureTime=" + encodeURIComponent(departureTimeString) +
        "&timeOfDestination=" + encodeURIComponent(timeOfDestinationString);

    xhr.open("POST", url, true);

    // Set the content type of the request
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function () {
    if (xhr.readyState == 4) {
        console.log("Response Status:", xhr.status);
        console.log("Response Text:", xhr.responseText);

        // Check if the request was successful (status 200)
        if (xhr.status === 200) {
            // Display a SweetAlert confirmation dialog
            Swal.fire({
                icon: 'success',
                title: 'Record saved successfully!',
                showCancelButton: true,
                confirmButtonText: 'OK',
            }).then((result) => {
                if (result.isConfirmed) {
                    // If the user clicks OK, redirect to process4.php
                    window.location.href = "process4.php";
                }
            });
        } else {
            // Display a SweetAlert error notification
            Swal.fire({
                icon: 'error',
                title: 'Error saving record. Please try again.',
            });
        }
    }
};



    // Send the request
    xhr.send(params);
}

        // Call the updateClock function immediately
        updateClock();

        // Update the clock every second
        setInterval(updateClock, 1000);
        
    </script>
</body>

</html>
