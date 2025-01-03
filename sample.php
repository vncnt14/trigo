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

$user_query = "SELECT *FROM user WHERE user_id = $user_id";
$user_result = mysqli_query($connection, $user_query);
$userData = mysqli_fetch_assoc($user_result);

// Fetch all announcements
$sql = "SELECT * FROM Registration_Announcement_Details ORDER BY id DESC";
$result = $connection->query($sql);
$announcements = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $announcements[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Interface</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }
        .header {
            position: relative;
            width: 100%;
            height: 250px; /* Lock the size of the background */
            background: url('https://image.slidesdocs.com/responsive-images/background/simple-geometric-gradient-poster-powerpoint-background_78e0b9533c__960_540.jpg') no-repeat center center;
            background-size: cover;
            color: BLACK;
            text-align: center;
            padding: 10px;
        }
        .announcement-content {
            max-width: 1000px; /* Widen the announcement area */
            margin: 0 auto;
            padding: 10px;
            text-align: Center;
        }
        .announcement-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .announcement-column {
            width: 48%; /* Each column takes 48% of the width */
            font-size: 13px;
            line-height: 1.5;
            text-align: left;
        }
        .announcement-title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 10px;
            text-align: Left;
        }
            .register-btn {
    width: 15%;
    margin-top: -10px;
    margin-left: 900px;
    text-align: center;
    background-color:green;
}
.announcement-item {
    border-bottom: 1px solid #ddd;
}
    </style>
</head>
<body>
    <!-- Header Section with Announcements -->
    <div class="header">
        <div class="announcement-content">
            <h2>Announcements</h2>
            <?php if (!empty($announcements)): ?>
                <?php foreach ($announcements as $announcement): ?>
                    <div class="announcement-item">
                        <div class="announcement-column">
                            <strong>Title:</strong> <?php echo $announcement['title']; ?><br>
                            <strong>Registration is open from:</strong> <?php echo $announcement['registration_period']; ?><br>
                            <strong>AWe are hiring::</strong> <?php echo $announcement['who_can_apply']; ?><br>
                            <strong>Applicants must provide a:</strong> <?php echo $announcement['required_documents']; ?>
                        </div>
                        <div class="announcement-column">
                            <strong>For inquiries, contact our office at:</strong> <?php echo $announcement['office_contact_info']; ?><br>
                            <strong>Procedure:</strong> <?php echo $announcement['registration_procedure']; ?><br>
                            <strong>A fee of:</strong> <?php echo $announcement['registration_fee']; ?><br>
                            <strong>Date Posted:</strong> <?php echo $announcement['date_posted']; ?>
                        </div>
                        </div>
                        <a href="sample2reg.php?id=<?php echo $announcement['id']; ?>" class="btn btn-primary register-btn">Register</a>


                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="announcement-title">No Announcements Yet</div>
            <?php endif; ?>
        </div>
    </div>



    <!-- Main Content for Driver Interface -->
    <div class="main-content">
        <h1>Welcome to the Driver Interface</h1>
        <p>Here you can view your schedules, routes, and other important details.</p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
