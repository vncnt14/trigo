<?php
include 'config.php';

// Start the session at the beginning
session_start();

// Check if the driver is logged in, redirect to driverlogin.php if not
if (!isset($_SESSION["user_id"])) {
    header("Location: driverlogin.php");
    exit();
}

// Retrieve driver information from the database based on the driver_id in the session
$user_id = $_SESSION["user_id"];
$query = "SELECT * FROM user WHERE user_id = '$user_id'";
$result = mysqli_query($connection, $query);

if ($result) {
    $driver = mysqli_fetch_assoc($result);
} else {
    // Handle the error, and consider redirecting or displaying a message
    die("Error retrieving driver information: " . mysqli_error($connection));
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the driver_location is set in the POST data
    if (isset($_POST["driver_location"])) {
        // Get the selected driver_location from the form
        $newLocation = $_POST["driver_location"];

        // Update the driver_location in the database
        $updateQuery = "UPDATE driver SET driver_location = '$newLocation' WHERE driver_id = '$driver_id'";
        $updateResult = mysqli_query($connection, $updateQuery);

        if ($updateResult) {
            echo "<script>alert('Driver location updated successfully.');</script>";
            // Refresh the page or redirect as needed
        } else {
            echo "Error updating driver location: " . mysqli_error($connection);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Profile</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <style>
        /* Add your additional styles here */
        /* ... */

        /* Use the styles from the user profile for consistency */
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
            max-height: 200px; /* Set the maximum height as needed */
            border-radius: 50%; /* Optional: Make the image round */
            margin-left: 50px;
        }

        .welcome-heading {
            background-color: #2B6A48; /* Change to the desired color */
            color: white;
            padding: 15px; /* Adjust padding as needed */
            margin-bottom: 10px; /* Add margin-bottom for spacing */
            border-radius: 8px; /* Add border-radius for rounded corners */
            text-align: center;
        }
        
.status-form {
   
    width: 1000px; /* Set the width for the status form */
    background-color: white;
    border-radius: 15px;
    margin-top: 50px;
    margin-left:10px;

}.status{
    position: relative;
    margin-left:800px;
    margin-top: -300px;
    background-color: #2B6A48; /* Change to the desired color */
    width: 550px;
    border-radius:5px;
    padding:1px;
}
#status {
        /* Style for the status dropdown */
        margin-right: 10px;
        padding: 5px;
    }

    input[type="submit"] {
        /* Style for the Update Status button */
        background-color: #93CCAD;
        color: white;
        padding: 3px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    input[type="submit"]:hover {
        /* Hover effect for the button */
        background-color: #45a049;
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
        <a href="login.php">Logout</a>
    </div>

    <!-- Driver Profile Section -->
    <div class="profile-container bg-white"> <!-- Separate background color for the profile container -->
        <?php if (isset($driver) && $driver !== null) { ?>
            <h2 class="text-3xl font-bold mb-4 welcome-heading">
                Welcome, <?php echo $driver["first_name"] . " " . $driver["last_name"]; ?>!
            </h2>
            <div class="image mb-4">
    <img src="https://thumbs.dreamstime.com/b/default-avatar-profile-icon-vector-social-media-user-image-182145777.jpg" alt="Profile Image" class="max-w-full max-h-48 mx-auto rounded-full">
</div>

            <div class="text-left bg-white p-4 rounded">
    <p class="mb-2"><span class="font-bold">First Name:</span> <?php echo $driver["first_name"]; ?></p>
    <p class="mb-2"><span class="font-bold">Last Name:</span> <?php echo $driver["last_name"]; ?></p>
    <p class="mb-2"><span class="font-bold">Email:</span> <?php echo $driver["email"]; ?></p>
    <p class="mb-2"><span class="font-bold">Contact Number:</span> <?php echo $driver["contact_number"]; ?></p>
    <p class="mb-2"><span class="font-bold">Address:</span> <?php echo isset($driver["address"]) ? $driver["address"] : "Not set"; ?></p>
    <p class="mb-2"><span class="font-bold">Plate Number:</span> <?php echo isset($driver["plate_number"]) ? $driver["plate_number"] : "Not set"; ?></p>
    <p class="mb-2"><span class="font-bold">License Number:</span> <?php echo isset($driver["license_number"]) ? $driver["license_number"] : "Not set"; ?></p>
    <p class="mb-2"><span class="font-bold">Driver Location:</span> <?php echo isset($driver["driver_location"]) ? $driver["driver_location"] : "Not set"; ?></p>

    <!-- Edit button -->
    <a href="#"><button class="bg-blue-500 text-white px-4 py-2 rounded">Edit</button></a>

    <!-- Save Changes button (initially hidden) -->
    <button class="bg-green-500 text-white px-4 py-2 rounded ">Save Changes</button>
    
</div>

<div class="status">
    <!-- Status Update Form -->
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="driver_location">Driver Location:</label>
        <select name="driver_location" id="status">
            <option value="Alambre" <?php echo (isset($driver["driver_location"]) && $driver["driver_location"] == 'Alambre') ? 'selected' : ''; ?>>Alambre</option>
            <option value="atan-awe" <?php echo (isset($driver["driver_location"]) && $driver["driver_location"] == 'atan-awe') ? 'selected' : ''; ?>>Atan-Awe</option>
            <option value="bangkas-heights" <?php echo (isset($driver["driver_location"]) && $driver["driver_location"] == 'bangkas-heights') ? 'selected' : ''; ?>>Bangkas Heights</option>
            <option value="baracatan" <?php echo (isset($driver["driver_location"]) && $driver["driver_location"] == 'baracatan') ? 'selected' : ''; ?>>Baracatan</option>
            <option value="bato" <?php echo (isset($driver["driver_location"]) && $driver["driver_location"] == 'bato') ? 'selected' : ''; ?>>Bato</option>
            <option value="daliao" <?php echo (isset($driver["driver_location"]) && $driver["driver_location"] == 'daliao') ? 'selected' : ''; ?>>Daliao</option>
            <option value="Davao-Central-Colloge" <?php echo (isset($driver["driver_location"]) && $driver["driver_location"] == 'Davao-Central-Colloge') ? 'selected' : ''; ?>>Davao Central Colloge</option>
            <option value="Toril-Public-Market" <?php echo (isset($driver["driver_location"]) && $driver["driver_location"] == ' Toril-Public-Market') ? 'selected' : ''; ?>> Toril Public Market</option>
            <option value="daliaoan-plantation" <?php echo (isset($driver["driver_location"]) && $driver["driver_location"] == 'daliaoan-plantation') ? 'selected' : ''; ?>>Daliaoan Plantation</option>
            <option value="Eden" <?php echo (isset($driver["driver_location"]) && $driver["driver_location"] == 'Eden') ? 'selected' : ''; ?>>Eden</option>
            <option value="kilate" <?php echo (isset($driver["driver_location"]) && $driver["driver_location"] == 'kilate') ? 'selected' : ''; ?>>Kilate</option>
            <option value="lizada" <?php echo (isset($driver["driver_location"]) && $driver["driver_location"] == 'lizada') ? 'selected' : ''; ?>>Lizada</option>
            <option value="bayabas" <?php echo (isset($driver["driver_location"]) && $driver["driver_location"] == 'bayabas') ? 'selected' : ''; ?>>Bayabas</option>
            <option value="binugao" <?php echo (isset($driver["driver_location"]) && $driver["driver_location"] == 'binugao') ? 'selected' : ''; ?>>Binugao</option>
            <option value="calamansi" <?php echo (isset($driver["driver_location"]) && $driver["driver_location"] == 'calamansi') ? 'selected' : ''; ?>>Calamansi</option>
            <option value="catigan" <?php echo (isset($driver["driver_location"]) && $driver["driver_location"] == 'catigan') ? 'selected' : ''; ?>>Catigan</option>
            <option value="crossing-bayabas" <?php echo (isset($driver["driver_location"]) && $driver["driver_location"] == 'crossing-bayabas') ? 'selected' : ''; ?>>Crossing Bayabas</option>
            <option value="lubogan" <?php echo (isset($driver["driver_location"]) && $driver["driver_location"] == 'lubogan') ? 'selected' : ''; ?>>Lubogan</option>
            <option value="marapangi" <?php echo (isset($driver["driver_location"]) && $driver["driver_location"] == 'marapangi') ? 'selected' : ''; ?>>Marapangi</option>
            <option value="sibulan" <?php echo (isset($driver["driver_location"]) && $driver["driver_location"] == 'sibulan') ? 'selected' : ''; ?>>Sibulan</option>
            <option value="sirawan" <?php echo (isset($driver["driver_location"]) && $driver["driver_location"] == 'sirawan') ? 'selected' : ''; ?>>Sirawan</option>
            <option value="tagluno" <?php echo (isset($driver["driver_location"]) && $driver["driver_location"] == 'tagluno') ? 'selected' : ''; ?>>Tagluno</option>
            <option value="tagurano" <?php echo (isset($driver["driver_location"]) && $driver["driver_location"] == 'tagurano') ? 'selected' : ''; ?>>Tagurano</option>
            <option value="tibuloy" <?php echo (isset($driver["driver_location"]) && $driver["driver_location"] == 'tibuloy') ? 'selected' : ''; ?>>Tibuloy</option>
            <option value="toril-proper" <?php echo (isset($driver["driver_location"]) && $driver["driver_location"] == 'toril-proper') ? 'selected' : ''; ?>>Toril Proper</option>
            <option value="tungkalan" <?php echo (isset($driver["driver_location"]) && $driver["driver_location"] == 'tungkalan') ? 'selected' : ''; ?>>Tungkalan</option>
        </select>
        <input type="submit" value="Update Status">
    </form>
</div>


    <?php } else { ?>
        <p>Error: Driver information not available.</p>
        <!-- You can handle this case as needed, such as redirecting to the login page -->t
    <?php } ?>
</body>

</html>
