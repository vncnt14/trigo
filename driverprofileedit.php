<?php
include ('config.php');

session_start();

// Check if the driver is logged in, redirect to driverlogin.php if not
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_GET['user_id'];

$user_query = "SELECT *FROM user WHERE user_id = '$user_id'";
$user_result  = mysqli_query($connection, $user_query);
$userData = mysqli_fetch_assoc($user_result);

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Edit</title>
</head>
<style>    
:root {
        --primary-color: #2B6A48;
        --secondary-color: #93CCAD;
        --white: #ffffff;
    }

    .profile-container {
        max-width: 800px;
        margin: 20px auto;
        background-color: var(--white);
        border-radius: 8px;
        margin-top: 20px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .edit-form input {
        width: 100%;
        padding: 10px;
        margin: 8px 0;
        border: 2px solid #2B6A48;
        border-radius: 15px;
        font-size: 16px;
        transition: all 0.3s ease;
    }

    .edit-form input:focus {
        outline: none;
        border-color: #93CCAD;
        box-shadow: 0 0 5px rgba(147, 204, 173, 0.5);
    }

    .edit-form label {
        color: #2B6A48;
        font-weight: bold;
        display: block;
        margin-top: 10px;
    }

    .button-group {
        display: flex;
        gap: 10px;
        margin-top: 20px;
    }

    .edit-btn {
        background-color: #2B6A48;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .save-btn {
        background-color: #93CCAD;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .edit-btn:hover,
    .save-btn:hover {
        opacity: 0.9;
        transform: translateY(-2px);
    }

    .form-group {
        margin-bottom: 15px;
    }

    .profile-image {
        text-align: center;
        margin: 20px 0;
    }

    .profile-image img {
        width: 200px;
        height: 200px;
        border-radius: 50%;
        border: 5px solid var(--primary-color);
        object-fit: cover;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    @media (max-width: 768px) {
        .profile-image img {
            width: 150px;
            height: 150px;
        }
    }

    @media (max-width: 480px) {
        .profile-image img {
            width: 120px;
            height: 120px;
        }
    }
</style>

<body>

    <div class="profile-container">
        <?php if (isset($userData) && $userData !== null) { ?>
            <div class="profile-header">
                <h2 class="welcome-heading">
                    Welcome, <?php echo isset($userData["first_name"]) ? $userData["first_name"] . " " . $userData["last_name"] : "User"; ?>!
                </h2>
            </div>

            <div class="profile-content">
                <div class="profile-image">
                    <img src="https://thumbs.dreamstime.com/b/default-avatar-profile-icon-vector-social-media-user-image-182145777.jpg"
                        alt="Profile Image">
                </div>

                <!-- Display Profile Info -->
                <div class="info-container">
                    <div class="info-row">
                        <span class="info-label">First Name:</span>
                        <span class="info-value"><?php echo isset($userData["first_name"]) ? $userData["first_name"] : "Not set"; ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Last Name:</span>
                        <span class="info-value"><?php echo isset($userData["last_name"]) ? $userData["last_name"] : "Not set"; ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Email:</span>
                        <span class="info-value"><?php echo isset($userData["email"]) ? $userData["email"] : "Not set"; ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Contact Number:</span>
                        <span class="info-value"><?php echo isset($userData["contact_number"]) ? $userData["contact_number"] : "Not set"; ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Address:</span>
                        <span class="info-value"><?php echo isset($userData["address"]) ? $userData["address"] : "Not set"; ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Plate Number:</span>
                        <span class="info-value"><?php echo isset($userData["plate_number"]) ? $userData["plate_number"] : "Not set"; ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">License Number:</span>
                        <span class="info-value"><?php echo isset($userData["license_number"]) ? $userData["license_number"] : "Not set"; ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Driver Location:</span>
                        <span class="info-value"><?php echo isset($userData["driver_location"]) ? $userData["driver_location"] : "Not set"; ?></span>
                    </div>

                    <div class="button-container">
                        <button class="edit-btn">Edit</button>
                        <button class="save-btn" style="display: none;">Save Changes</button>
                    </div>
                </div>

                <!-- Edit Form -->
                <form class="edit-form" id="editForm" method="post" action="">
                    <div class="form-group">
                        <label for="first_name">First Name:</label>
                        <input type="text" id="first_name" name="first_name"
                            value="<?php echo isset($userData['first_name']) ? htmlspecialchars($userData['first_name']) : ''; ?>">
                    </div>

                    <div class="form-group">
                        <label for="last_name">Last Name:</label>
                        <input type="text" id="last_name" name="last_name"
                            value="<?php echo isset($userData['last_name']) ? htmlspecialchars($userData['last_name']) : ''; ?>">
                    </div>

                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email"
                            value="<?php echo isset($userData['email']) ? htmlspecialchars($userData['email']) : ''; ?>">
                    </div>

                    <div class="form-group">
                        <label for="contact_number">Contact Number:</label>
                        <input type="text" id="contact_number" name="contact_number"
                            value="<?php echo isset($userData['contact_number']) ? htmlspecialchars($userData['contact_number']) : ''; ?>">
                    </div>

                    <div class="form-group">
                        <label for="address">Address:</label>
                        <input type="text" id="address" name="address"
                            value="<?php echo isset($userData['address']) ? htmlspecialchars($userData['address']) : ''; ?>">
                    </div>

                    <div class="form-group">
                        <label for="plate_number">Plate Number:</label>
                        <input type="text" id="plate_number" name="plate_number"
                            value="<?php echo isset($userData['plate_number']) ? htmlspecialchars($userData['plate_number']) : ''; ?>">
                    </div>

                    <div class="form-group">
                        <label for="license_number">License Number:</label>
                        <input type="text" id="license_number" name="license_number"
                            value="<?php echo isset($userData['license_number']) ? htmlspecialchars($userData['license_number']) : ''; ?>">
                    </div>
                </form>
            </div>
        <?php } else { ?>

        <?php } ?>
    </div>



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const editForm = document.getElementById('editForm');
            const editBtn = document.querySelector('.edit-btn');
            const saveBtn = document.querySelector('.save-btn');

            editBtn.addEventListener('click', function() {
                editForm.style.display = 'block';
                editBtn.style.display = 'none';
                saveBtn.style.display = 'block';
            });

            saveBtn.addEventListener('click', function() {
                editForm.style.display = 'none';
                editBtn.style.display = 'block';
                saveBtn.style.display = 'none';
                editForm.submit();
            });
        });
    </script>

</body>

</html>