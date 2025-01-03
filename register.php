<?php
// Include your database connection code here
include 'config.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve user inputs
    $first_name = mysqli_real_escape_string($connection, $_POST["first_name"]);
    $middle_name = mysqli_real_escape_string($connection, $_POST["middle_name"]);
    $last_name = mysqli_real_escape_string($connection, $_POST["last_name"]);
    $email = mysqli_real_escape_string($connection, $_POST["email"]);
    $contact_number = mysqli_real_escape_string($connection, $_POST["contact_number"]);
    $username = mysqli_real_escape_string($connection, $_POST["username"]);
    $password = $_POST["password"];
    $role = $_POST["role"];

    // Handle file upload
    if (isset($_FILES['image'])) {
        $image_size = $_FILES['image']['size'];
        $image_tmp_name = $_FILES['image']['tmp_name'];
        
        // Check if file upload is successful
        if ($image_size > 0) {
            // Move uploaded file to the desired folder
            $image_folder = 'uploads/';
            $image = basename($_FILES['image']['name']);
            $target_path = $image_folder . $image;
            
            if (move_uploaded_file($image_tmp_name, $target_path)) {
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
    $stmt = $connection->prepare("INSERT INTO user (first_name, middle_name, last_name, email, contact_number, username, password, image, role) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssss", $first_name, $middle_name, $last_name, $email, $contact_number, $username, $password, $image, $role);

    if ($stmt->execute()) {
        echo "<script>alert('Registration successful. You can now login.'); window.location.href='login.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the prepared statement
    $stmt->close();
}

// Close the database connection
$connection->close();
?>