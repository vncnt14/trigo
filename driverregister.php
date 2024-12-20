<?php
// Include your database connection code here
include 'config.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $first_name = mysqli_real_escape_string($connection, $_POST["first_name"]);
    $last_name = mysqli_real_escape_string($connection, $_POST["last_name"]);
    $address = mysqli_real_escape_string($connection, $_POST["address"]);
    $email = mysqli_real_escape_string($connection, $_POST["email"]);

    // Check if the 'contact' key exists in $_POST
    $contact = isset($_POST["contact"]) ? mysqli_real_escape_string($connection, $_POST["contact"]) : '';
    
    $plate_number = mysqli_real_escape_string($connection, $_POST["plate_number"]);
    $license_number = mysqli_real_escape_string($connection, $_POST["license_number"]);
    $username = mysqli_real_escape_string($connection, $_POST["username"]);
    $password = $_POST["password"]; // No hashing

    // Initialize a default value for $dimage
    $dimage = 'default_image.jpg';

    if (isset($_FILES['dimage'])) {
        $dimage_size = $_FILES['dimage']['size'];
        $dimage_tmp_name = $_FILES['dimage']['tmp_name'];
        
        // Check if file upload is successful
        if ($dimage_size > 0) {
            // Move uploaded file to the desired folder
            $dimage_folder = 'duploaded_img';
            $dimage = basename($_FILES['dimage']['name']);
            $target_path = $dimage_folder . $dimage;
            
            if (move_uploaded_file($dimage_tmp_name, $target_path)) {
                echo "File uploaded successfully.";
            } else {
                echo "Error uploading file.";
            }
        } else {
            echo "File size is 0 or file not uploaded.";
        }
    } else {
        echo "Image file not provided.";
    }

    // Use prepared statement to prevent SQL injection
    $stmt = $connection->prepare("INSERT INTO driver (first_name, last_name, address, email, contact, plate_number, license_number, username, password, dimage) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    // Check if the prepared statement was successfully created
    if ($stmt === false) {
        die("Error in preparing the statement: " . $connection->error);
    }

    $stmt->bind_param("ssssssssss", $first_name, $last_name, $address, $email, $contact, $plate_number, $license_number, $username, $password, $dimage);

    if ($stmt->execute()) {
        echo "<script>alert('Driver registration successful. Click OK to proceed to login.'); window.location.href='driverlogin.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the prepared statement
    $stmt->close();
}

// Close the database connection
$connection->close();
?>
