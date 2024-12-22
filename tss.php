<?php
// Connect to the database
$conn = new mysqli('localhost', 'root', '', 'trigo');

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Fetch all announcements and determine their status
$sql = "SELECT *, 
               IF(registration_period < CURDATE(), 'Expired', 'Active') AS status 
        FROM Registration_Announcement_Details
        ORDER BY id DESC";
$result = $conn->query($sql);
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
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .sidebar {
            height: 100vh;
            background-color: #343a40;
            color: #fff;
        }
        .sidebar a {
            color: #adb5bd;
            text-decoration: none;
        }
        .sidebar a:hover {
            color: #fff;
        }
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }
        .modal-header {
            background-color: #343a40;
            color: #fff;
        }
        .table-danger {
            background-color: #f8d7da;
        }
    </style>
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar p-3">
            <h2 class="text-center">Admin Panel</h2>
            <ul class="nav flex-column mt-4">
                <li class="nav-item mb-3">
                    <a class="nav-link" href="#dashboard">Dashboard</a>
                </li>
                <li class="nav-item mb-3">
                    <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#postAnnouncementModal">Post Announcement</a>
                </li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <?php if (isset($_GET['message']) && $_GET['message'] == 'deleted'): ?>
                <div class="alert alert-success">Announcement deleted successfully!</div>
            <?php endif; ?>
            <h1>Manage Announcements</h1>
            <table class="table table-striped">
    <thead>
        <tr>
            <th>Title</th>
            <th>Registration Period</th>
            <th>Date Posted</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($announcements)): ?>
            <?php foreach ($announcements as $announcement): ?>
                <tr class="<?php echo $announcement['status'] === 'Expired' ? 'table-danger' : ''; ?>">
                    <td><?php echo $announcement['title']; ?></td>
                    <td><?php echo $announcement['registration_period']; ?></td>
                    <td><?php echo $announcement['date_posted']; ?></td>
                    <td><?php echo $announcement['status']; ?></td>
                    <td>
                        <a href="edit_announcement.php?id=<?php echo $announcement['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="del.php?id=<?php echo $announcement['id']; ?>" 
                           class="btn btn-sm btn-danger"
                           onclick="return confirm('Are you sure you want to delete this announcement?');">
                           Delete
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5" class="text-center">No announcements found.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

        </div>
    </div>

    <!-- Post Announcement Modal -->
    <div class="modal fade" id="postAnnouncementModal" tabindex="-1" aria-labelledby="postAnnouncementModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="postAnnouncementModalLabel">Post Announcement</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="post.php" method="POST">
                        <div class="mb-3">
                            <label for="announcement-title" class="form-label">Announcement Title</label>
                            <input type="text" class="form-control" id="announcement-title" name="announcement-title" placeholder="Enter announcement title" required>
                        </div>
                        <div class="mb-3">
                            <label for="registration-period" class="form-label">Registration Period</label>
                            <input type="date" class="form-control" id="registration-period" name="registration-period" required>
                        </div>
                        <div class="mb-3">
                            <label for="who-can-apply" class="form-label">Who Can Apply</label>
                            <textarea class="form-control" id="who-can-apply" name="who-can-apply" rows="2" placeholder="Enter eligibility criteria" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="required-documents" class="form-label">Required Documents</label>
                            <textarea class="form-control" id="required-documents" name="required-documents" rows="3" placeholder="List required documents" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Post Announcement</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
