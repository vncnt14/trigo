<?php
session_start();

// Include database connection file
include('config.php');  // You'll need to replace this with your actual database connection code

// Redirect to the login page if the user is not logged in
if (!isset($_SESSION['username'])) {
    header("Location index.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$id = $_GET['id'];

$user_query = "SELECT *FROM user WHERE user_id = '$user_id'";
$user_result = mysqli_query($connection, $user_query);
$userData = mysqli_fetch_assoc($user_result);


$announce_query = "SELECT *FROM registration_announcement_details WHERE id = '$id'";
$announce_result = mysqli_query($connection, $user_query);
$announceData = mysqli_fetch_assoc($announce_result);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css" />
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
  <link rel="stylesheet" href="css/dataTables.bootstrap5.min.css" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <title>Driver Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
            margin-top:500px ;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-top: 15px;
            color: #555;
        }
        input[type="text"], input[type="file"] {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
            margin-top: 5px;
        }
        button {
            margin-top: 20px;
            background-color: #007bff;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Driver Registration</h1>
        <form action="connectreg.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="user_id" id="user_id" value="<?php echo $userData['user_id'];?>"
            
            <label for="first_name">First Name:</label>
            <input type="text" id="first_name" name="first_name"  value="<?php echo $userData['first_name'];?>" readonly>
            <input type="hidden" name="announcement_id" id="id" value="<?php echo $id;?>"
            
            <label for="middle_name">Middle Name:</label>
            <input type="text" name="middle_name" id="middle_name" value="<?php echo $userData['middle_name'];?>">
            
            <label for="last_name">Last Name:</label>
            <input type="text" id="last_name" name="last_name"  value="<?php echo $userData['last_name'];?>" readonly>

            <label for="driver_license">Driver License (Picture):</label>
            <input type="file" id="driver_license" name="driver_license" accept="image/*" required>

            <label for="vehicle_registration">Vehicle Registration (Picture):</label>
            <input type="file" id="vehicle_registration" name="vehicle_registration" accept="image/*" required>

            <label for="proof_of_residency">Proof of Residency (Picture):</label>
            <input type="file" id="proof_of_residency" name="proof_of_residency" accept="image/*" required>

            <label for="puv_id">PUV ID:</label>
            <input type="file" id="puv_id" name="puv_id" accept="image/*" required>


            <label for="id_photo">ID Photo:</label>
            <input type="file" id="id_photo" name="id_photo" accept="image/*" required>

            <button type="submit">Submit</button>
        </form>
    </div>
</body>
</html>
