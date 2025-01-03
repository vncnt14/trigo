<?php
include 'config.php'; // Include database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $middle_name = $_POST['middle_name'];
    $user_id = $_POST['user_id'];
    $announcement_id = $_POST['announcement_id'];

    // Handle file uploads
    $driver_license = $_FILES['driver_license']['name'];
    $vehicle_registration = $_FILES['vehicle_registration']['name'];
    $proof_of_residency = $_FILES['proof_of_residency']['name'];
    $puv_id = $_FILES['puv_id']['name'];
    $id_photo = $_FILES['id_photo']['name'];

    // Define upload directory
    $upload_dir = "uploads/";

    // Define target paths for each file
    $driver_license_target = $upload_dir . time() . "_" . basename($driver_license);
    $vehicle_registration_target = $upload_dir . time() . "_" . basename($vehicle_registration);
    $proof_of_residency_target = $upload_dir . time() . "_" . basename($proof_of_residency);
    $puv_id_target = $upload_dir . time() . "_" . basename($puv_id);
    $id_photo_target = $upload_dir . time() . "_" . basename($id_photo);

    // Upload files
    if (move_uploaded_file($_FILES['driver_license']['tmp_name'], $driver_license_target) &&
        move_uploaded_file($_FILES['vehicle_registration']['tmp_name'], $vehicle_registration_target) &&
        move_uploaded_file($_FILES['proof_of_residency']['tmp_name'], $proof_of_residency_target) &&
        move_uploaded_file($_FILES['id_photo']['tmp_name'], $id_photo_target) &&
        move_uploaded_file($_FILES['puv_id']['tmp_name'], $puv_id_target)) {

        // Insert data into the database
        $sql = "INSERT INTO requirement_record_details 
                (user_id, announcement_id, first_name, middle_name, last_name, driver_license, vehicle_registration, proof_of_residency, puv_id, id_photo)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $connection->prepare($sql);
        $stmt->bind_param(
            "iissssssss",
            $user_id, 
            $announcement_id,
            $first_name,
            $middle_name, 
            $last_name, 
            $driver_license_target, 
            $vehicle_registration_target, 
            $proof_of_residency_target, 
            $puv_id_target, 
            $id_photo_target
        );

        if ($stmt->execute()) {
            echo "<script>alert('Information Added succesfully!.'); window.location.href='sample.php';</script>";
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        echo "File upload failed.";
    }
}
?>
