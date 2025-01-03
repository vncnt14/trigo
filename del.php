<?php
// Connect to the database
$conn = new mysqli('localhost', 'root', '', 'trigo');

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Check if `id` is set in the query string
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Ensure `id` is an integer
    
    // Prepare the delete query
    $sql = "DELETE FROM Registration_Announcement_Details WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Redirect back to the admin dashboard with a success message
        header("Location: admin_dashboard.php?message=deleted");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>
