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
                <li class="nav-item mb-3">
                    <a class="nav-link" href="val_list.php">Validation Center</a>
                </li>
                <li class="nav-item mb-3">
                    <a class="nav-link" href="#tricycles">Tricycles</a>
                </li>
                <li class="nav-item mb-3">
                    <a class="nav-link" href="#memberships">Memberships</a>
                </li>
                <li class="nav-item mb-3">
                    <a class="nav-link" href="#scheduling-routes">Scheduling and Routes</a>
                </li>
                <li class="nav-item mb-3">
                    <a class="nav-link" href="#complaints-reports">Complaints/Reports</a>
                </li>
                <li class="nav-item mb-3">
                    <a class="nav-link" href="#financials">Financials</a>
                </li>
                <li class="nav-item mb-3">
                    <a class="nav-link" href="#notifications">Notifications</a>
                </li>
                <li class="nav-item mb-3">
                    <a class="nav-link" href="#reports-analytics">Reports and Analytics</a>
                </li>
                <li class="nav-item mb-3">
                    <a class="nav-link" href="#admin-settings">Admin Settings</a>
                </li>
                <li class="nav-item mb-3">
                    <a class="nav-link" href="#help-support">Help/Support</a>
                </li>
                <li class="nav-item mb-3">
                    <a class="nav-link" href="login.php">Logout</a>
                </li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <section id="dashboard">
                <h1>Dashboard</h1>
                <div class="row">
                    <div class="col-md-4">
                        <div class="card text-bg-primary mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Total Users</h5>
                                <p class="card-text">50</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-bg-success mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Announcements Posted</h5>
                                <p class="card-text">10</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-bg-warning mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Pending Requests</h5>
                                <p class="card-text">5</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
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
                        <div class="mb-3">
                            <label for="office-contact" class="form-label">Office Contact Information</label>
                            <input type="text" class="form-control" id="office-contact" name="office-contact" placeholder="Enter contact details" required>
                        </div>
                        <div class="mb-3">
                            <label for="registration-procedure" class="form-label">Registration Procedure</label>
                            <textarea class="form-control" id="registration-procedure" name="registration-procedure" rows="4" placeholder="Describe the registration process" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="registration-fee" class="form-label">Registration Fee</label>
                            <input type="text" class="form-control" id="registration-fee" name="registration-fee" placeholder="Enter fee details" required>
                        </div>
                        <div class="mb-3">
                            <label for="date-posted" class="form-label">Date Posted</label>
                            <input type="date" class="form-control" id="date-posted" name="date-posted" required>
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
