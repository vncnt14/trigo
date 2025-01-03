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
$query = "SELECT * FROM user WHERE user_id = '$user_id'";
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
        <a href="login.php">Logout</a>
    </div>

   <!-- User Profile Section -->
    <div class="profile-container bg-white"> <!-- Separate background color for the profile container -->
        <?php if (isset($user) && $user !== null) { ?>
            <h2 class="text-3xl font-bold mb-4 welcome-heading">
    Welcome, <?php echo $user["first_name"] . " " . $user["last_name"]; ?>!
</h2>
            <div class="image mb-4">
                <?php
                $select = mysqli_query($connection, "SELECT * FROM user WHERE user_id = '$user_id'") or die('query failed');
                if(mysqli_num_rows($select) > 0){
                    $fetch = mysqli_fetch_assoc($select);
                }
                if($fetch['image'] == ''){
                    echo '<img src="images/default-avatar.png" alt="Profile Image" class="max-w-full max-h-48 mx-auto rounded-full">';
                } else {
                    echo '<img src="uploaded_img/'.$fetch['image'].'" alt="Profile Image" class="max-w-full max-h-48 mx-auto rounded-full">';
                }
                ?>
            </div>
            <div class="text-left bg-white p-4 rounded">
    <p class="mb-2"><span class="font-bold">First Name:</span> <?php echo $user["first_name"]; ?></p>
    <p class="mb-2"><span class="font-bold">Email:</span> <?php echo $user["email"]; ?></p>
    <p class="mb-2"><span class="font-bold">Contact Number:</span> <?php echo $user["contact_number"]; ?></p>
    <p class="mb-2"><span class="font-bold">Address:</span> <?php echo $user["address"]; ?></p>

    <!-- Edit button -->
    <button class="bg-blue-500 text-white px-4 py-2 rounded">Edit</button>

    <!-- Save Changes button (initially hidden) -->
    <button class="bg-green-500 text-white px-4 py-2 rounded ">Save Changes</button>
</div>


        <?php } else { ?>
            <p>Error: User information not available.</p>
            <!-- You can handle this case as needed, such as redirecting to the login page -->
        <?php } ?>
    </div>
    
</body>
</html>
