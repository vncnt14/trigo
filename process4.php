<?php
session_start();

// Include database configuration file
include 'config.php';

// Redirect to the login page if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Establish a database connection
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch data from the travel table
$query = "SELECT * FROM travel";
$result = mysqli_query($connection, $query);

// Check if the query was successful
if (!$result) {
    die("Query failed: " . mysqli_error($connection));
}

// Fetch the data from the result set
$travelData = mysqli_fetch_assoc($result);

// Close the database connection
mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Time Record</title>
    <!-- Add Tailwind CSS link here -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
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

        .profile-container {
            flex: 1; /* Fill the remaining space in the flex container */
            background-color: #93CCAD;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        
    .image img {
        max-width: 100%; /* Set the maximum width to 100% of its container */
        max-height:200px; /* Set the maximum height as needed */
        border-radius: 50%; /* Optional: Make the image round */
        margin-left: 50px;
    }
    /* Updated styles for the welcome heading */
.welcome-heading {
    background-color: #2B6A48; /* Change to the desired color */
    color: white;
    padding: 15px; /* Adjust padding as needed */
    margin-bottom: 10px; /* Add margin-bottom for spacing */
    border-radius: 8px; /* Add border-radius for rounded corners */
    text-align: center;
}
   
.time{

            border: 2px solid #ccc;
            padding: 20px;
            margin: 10px;
            border-radius: 10px;
            max-width: 700px; /* Adjust the width as needed */
            margin-top: 20px;
            background-color: white; 
            margin-left:100px;
            width:800px;
           
        }

        .form-control {
            width: 100%;
            box-sizing: border-box;
            margin-bottom: 10px;
            padding:13px;
            border-radius: 6px;

            
           
        }
        #paymentBtn {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
.header{
    background-color: #2B6A48; 
    padding: 20px;
    width:100px;
    
}
    .form-container {
        max-width: 400px;
        margin: 0 auto;
        padding: 30px;
        background-color: #ffffff;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
     
    }

    /* Input label styling */
    label {
        display: block;
        font-weight: bold;
        margin-top: 10px;
    }

    /* Input styling */
    .form-control {
        width: 100%;
        padding: 8px;
        margin-top: 5px;
        box-sizing: border-box;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    /* Button styling */
    #paymentBtn {
        background-color: #2B6A48;
        color: #fff;
        border: none;
        padding: 10px;
        cursor: pointer;
        border-radius: 5px;
        margin-top: 10px;
        width: 100%;
    }

    #paymentBtn:hover {
        background-color: #7DBB9E;
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
    </div>    

   
   <div class= "time">    
   <h2 class="text-2xl font-bold mb-4">Travel Time Record</h2>
        <label for="current_location">Current Location</label>
        <input type="text" class="form-control" name="current_location" id="current_location" value ="<?php echo $travelData['current_location'];?>">
        <label for="destination">Destination</label>
        <input type="text" class="form-control" name="destination" id="destination" value ="<?php echo $travelData['destination'];?>">

        <label for="arrival_time">Arrival Time</label>
        <input type="text" class="form-control" name="time_arrival" id="time_arrival" value ="<?php echo $travelData['time_arrival'];?>">

        <label for="departure_time">Departure time</label>
        <input type="text" class="form-control" name="departure_time" id="departure_time" value ="<?php echo $travelData['departure_time'];?>">
        
        <label for="destination_arrival">Destination Arrival</label>
        <input type="text" class="form-control" name="destination_arrival" id="destination_arrival" value ="<?php echo $travelData['destination_arrival'];?>">
        
        <label for="fare">Fare</label>
        <input type="text" class="form-control" name="fare" id="fare"value ="<?php echo $travelData['fare'];?>">

        <div class="redirect-container">
        <div class="redirect-dropdown">
            <label for="redirected-dropdown">Redirect</label>
            <select id="redirected-dropdown" name="redirected-dropdown">
                <option value="Alambre">Alambre</option>
                <option value="Bangkas">Bangkas</option>
                <option value="Crossing_Bayabas">Crossing Bayabas</option>
                <option value="Daliao">Daliao</option>
                <option value="Public_Market">Public Market</option>
                <option value="Lubogan">Lubogan</option>
                <option value="Davao_Central_College">Davao Central College</option>
            </select>
        </div>
        <div class="redirect-value-box" id="redirect-value-box"></div>
    </div>
    <button id="paymentBtn">Send</button>
<script>
        document.addEventListener("DOMContentLoaded", function () {
        var redirectDropdown = document.getElementById("redirected-dropdown");
        var redirectValueBox = document.getElementById("redirect-value-box");
        var destinationInput = document.getElementById("destination");
        var fareInput = document.getElementById("fare");

        redirectDropdown.addEventListener("change", function () {
            var selectedPlace = this.value;
            var placeValues = {
                "Alambre": "₱50.00",
                "Bangkas": "₱50.00",
                "Daliao": "₱10.00",
                "Crossing_Bayabas": "₱15.00",
                "Public_Market": "₱10.00",
                "Lubogan": "₱30.00",
                "Davao_Central_College": "₱10.00"
                // Add other places and their values here
            };

            redirectValueBox.innerText = placeValues[selectedPlace] || "";

            // Update destination and fare when destination is changed
            destinationInput.value = selectedPlace;
            fareInput.value = placeValues[selectedPlace] || "";

            // Send an asynchronous request to update the database
            updateDatabase(selectedPlace, placeValues[selectedPlace] || "");
        });

        function updateDatabase(destination, fare) {
            // Use AJAX to send a request to the server to update the database
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "update_database.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Handle the server's response if needed
                    console.log(xhr.responseText);
                }
            };
            
            // Assuming travel_id is the identifier for the current travel record
            var travelId = "<?php echo $travelData['travel_id']; ?>";
            
            // Send the data to the server
            var data = "destination=" + destination + "&fare=" + fare + "&travel_id=" + travelId;
            xhr.send(data);
        }
    });
    document.addEventListener("DOMContentLoaded", function () {
        var sendButton = document.getElementById("paymentBtn");

        sendButton.addEventListener("click", function () {
            // Create a modal-style alert with "Yes" and "Cancel"
            var confirmation = confirm("Are you sure you want to send the data?");

            // Check if the user clicked "Yes"
            if (confirmation) {
                // If Yes, perform the action (you can add your logic here)
                alert("Data sent successfully!");
            } else {
                // If Cancel, do nothing or handle accordingly
                alert("Data sending canceled!");
            }
        });
    });
    </script>
</body>
</html>
