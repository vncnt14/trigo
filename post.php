<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form inputs
    $title = $_POST['announcement-title'];
    $registration_period = $_POST['registration-period'];
    $who_can_apply = $_POST['who-can-apply'];
    $required_documents = $_POST['required-documents'];
    $office_contact_info = $_POST['office-contact'];
    $registration_procedure = $_POST['registration-procedure'];
    $registration_fee = $_POST['registration-fee'];
    $date_posted = $_POST['date-posted'];

    // Connect to database
    $conn = new mysqli('localhost', 'root', '', 'trigo');

    // Check connection
    if ($conn->connect_error) {
        die("Database connection failed: " . $conn->connect_error);
    }

    // Update table name in the SQL query
    $sql = "INSERT INTO Registration_Announcement_Details (title, registration_period, who_can_apply, required_documents, office_contact_info, registration_procedure, registration_fee, date_posted) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    // Prepare the statement
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Statement preparation failed: " . $conn->error);
    }

    // Bind parameters to the statement
    $stmt->bind_param(
        "ssssssss",
        $title,
        $registration_period,
        $who_can_apply,
        $required_documents,
        $office_contact_info,
        $registration_procedure,
        $registration_fee,
        $date_posted
    );

    // Execute the statement
    if ($stmt->execute()) {
        echo "Announcement posted successfully!";
    } else {
        echo "Error executing statement: " . $stmt->error;
    }

    // Close connections
    $stmt->close();
    $conn->close();
}
?>
