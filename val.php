<?php
session_start();

// Include database connection file
include('config.php');  // You'll need to replace this with your actual database connection code

// Redirect to the login page if the user is not logged in
if (!isset($_SESSION['username'])) {
    header("Location login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$driver_id = $_GET['driver_id'];

// Query to fetch driver details
$query = "SELECT *FROM requirement_record_details WHERE driver_id = $driver_id";
$result = mysqli_query($connection, $query);
$driver_data = mysqli_fetch_assoc($result);

// Function to convert BLOB to base64 string

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Requirements</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f9f9f9;
        }
        .container {
            width: 700px;
            margin: auto;
            background: white;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }
        .header {
            display: flex;
            margin-bottom: 20px;
        }
        .header img {
            width: 100px;
            height: 100px;
            border: 1px solid #000;
            margin-right: 20px;
        }
        .header .details {
            margin-top: 20px;
        }
        .header .details label {
            font-weight: bold;
            display: block;
        }
        .requirements {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin: 20px 0;
        }
        .requirement-box {
            height: 150px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            border: 1px dashed #000;
        }
        .requirement-box img {
            max-width: 100%;
            max-height: 100%;
        }
        .status, .comments, .validated {
            margin-top: 20px;
        }
        .comments textarea {
            width: 100%;
            height: 100px;
            border: 1px solid #ddd;
            padding: 10px;
            resize: none;
        }
        .validated label {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="<?php echo $driver_data['id_photo'];?>" alt="ID Photo">
            <div class="details">
                <label>Name:</label>
                <span><?= htmlspecialchars($driver_data['first_name'] . ' ' . $driver_data['middle_name'] . ' ' . $driver_data['last_name']) ?></span>
                <label>Submission Date:</label>
                <span><?= date("Y-m-d") ?></span>
            </div>
        </div>

        <h3>Requirements</h3>
        <div class="requirements">
            <div class="requirement-box">
                <img src="<?php echo $driver_data['driver_license'];?>" alt="Driver License">
            </div>
            <div class="requirement-box">
            <img src="<?php echo $driver_data['puv_id'];?>" alt="PUV Identification">
            </div>
            <div class="requirement-box">
                <img src="<?php echo $driver_data['vehicle_registration'];?>" alt="Vehicle Registration">
            </div>
            <div class="requirement-box">
                <img src="<?php echo $driver_data['proof_of_residency'];?>" alt="Proof of Residency">
            </div>
        </div>

        <div class="status">
            <label>Validation Status:</label> Approved or Not
        </div>

        <div class="comments">
            <label>Comments:</label>
            <textarea placeholder="Enter comments here..."></textarea>
        </div>

        <div class="validated">
            <label>Validated by:</label> ______________________
        </div>
    </div>
</body>
</html>
