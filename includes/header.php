<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in and fetch user details
$user_role = '';
$user_id = '';
$full_name = 'User';
$points = 0;
$building_id = null;
$isFirstResident = false;
$isLoggedIn = isset($_SESSION['user_id']);
$showPickupOptions = false; // Controls "Request Pickup" & "Pickup History" visibility

if ($isLoggedIn) {
    $user_id = $_SESSION['user_id'];

    // Include database connection if not already included
    if (!isset($conn)) {
        require_once __DIR__ . '/../config/db.php';
    }

    // Fetch user details including building_id
    $sql_user = "SELECT full_name, role, points, building_id FROM users WHERE user_id = ?";
    $stmt_user = $conn->prepare($sql_user);
    $stmt_user->bind_param("i", $user_id);
    $stmt_user->execute();
    $result_user = $stmt_user->get_result();

    if ($result_user->num_rows > 0) {
        $user = $result_user->fetch_assoc();
        $full_name = htmlspecialchars($user['full_name'] ?? 'User');
        $user_role = $user['role'] ?? '';
        $points = $user['points'] ?? 0;
        $building_id = $user['building_id'] ?? null;
    }
    $stmt_user->close();

    // Check if the user is the first resident in their building
    if ($building_id !== null) {
        $stmt = $conn->prepare("SELECT MIN(user_id) FROM users WHERE building_id = ?");
        $stmt->bind_param("i", $building_id);
        $stmt->execute();
        $stmt->bind_result($lowest_user_id);
        $stmt->fetch();
        $stmt->close();

        if ($user_id == $lowest_user_id) {
            $isFirstResident = true;
            $showPickupOptions = true; // Enable visibility
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Waste Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        /* Sidebar styling */
        #sidebar {
            background: #343a40;
            color: white;
            padding: 20px;
            position: fixed;
            left: -300px;
            top: 50px;
            width: 250px;
            height: 85vh;
            border-radius: 10px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.25);
            transition: all 0.3s ease;
            overflow-y: auto;
            z-index: 999;
        }
        
        #sidebar.show {
            left: 20px;
        }
        
        #sidebar ul li a {
            color: white;
            font-size: 18px;
            text-decoration: none;
            display: block;
            padding: 15px 15px;
            font-weight: bold;
        }
        
        #sidebar ul li a:hover {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 5px;
        }
        
        .navbar .profile-btn {
            margin-left: auto;
        }
        
        .navbar-brand {
            color: rgba(132, 255, 0, 0.89); 
            font-weight: bold;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <?php if ($isLoggedIn): ?>
                <button id="sidebarToggle" class="btn btn-outline-light me-2"><i class="bi bi-list"></i></button>
            <?php endif; ?>
            
            <a class="navbar-brand" href="index.php">Green Bin</a>
            
            <?php if ($isLoggedIn): ?>
                <div class="profile-btn">
                    <a href="profile.php" class="btn btn-outline-light">
                        <i class="bi bi-person-circle"></i> <?php echo $full_name; ?>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </nav>

    <?php if ($isLoggedIn): ?>
        <div id="sidebar">
            <h4 class="text-center">Menu</h4>
            <ul class="list-unstyled">
                <?php if ($user_role === 'admin'): ?>
                    <li><a href="admin_dashboard.php"><i class="bi bi-speedometer"></i> Dashboard</a></li>
                    <li><a href="manage_users.php"><i class="bi bi-people-fill"></i> Manage Users</a></li>
                    <li><a href="manage_schedules.php"><i class="bi bi-calendar-check"></i> Manage Pickup Schedules</a></li>
                    <li><a href="reschedule_requests.php"><i class="bi bi-clock-history"></i> Reschedule Requests</a></li>
                    <li><a href="view_reports.php"><i class="bi bi-clipboard-data"></i> View Reports</a></li>
                    <li><a href="view_feedback.php"><i class="bi bi-chat-text"></i> View Feedback</a></li>
                    <li><a href="view_donations.php"><i class="bi bi-box"></i> View Donations</a></li>
                <?php elseif ($user_role === 'collector'): ?>
                    <li><a href="collector_dashboard.php"><i class="bi bi-truck"></i> Dashboard</a></li>
                    <li><a href="assigned_pickups.php"><i class="bi bi-clipboard-check"></i> Assigned Pickups</a></li>
                    <li><a href="pickup_history.php"><i class="bi bi-clock-history"></i> Pickup History</a></li>
                <?php else: ?>
                    <li><a href="dashboard.php"><i class="bi bi-speedometer"></i> Dashboard</a></li>
                    <?php if ($showPickupOptions): ?>
                        <li><a href="pickup.php"><i class="bi bi-truck"></i> Request Pickup</a></li>
                        <li><a href="pickup_history.php"><i class="bi bi-clock-history"></i> Recent Activities</a></li>
                    <?php endif; ?>
                    <li><a href="report_issue.php"><i class="bi bi-exclamation-triangle"></i> Report Issue</a></li>
                    <hr class="bg-light">
                    <li><a href="donations.php"><i class="bi bi-gift"></i> Donate an Item</a></li>
                    <li><a href="view_donations.php"><i class="bi bi-box"></i> View Donations</a></li>
                    <li><a href="redeem_rewards.php"><i class="bi bi-gift"></i> Redeem Rewards</a></li>
                    <hr class="bg-light">
                    <li><a href="user_reschedule.php"><i class="bi bi-clock-history"></i> Manage Reschedule Requests</a></li>
                <?php endif; ?>

                <li><a href="logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
            </ul>
        </div>
    <?php endif; ?>

    <?php if ($isLoggedIn): ?>
        <script>
            document.getElementById("sidebarToggle").addEventListener("click", function() {
                document.getElementById("sidebar").classList.toggle("show");
            });
        </script>
    <?php endif; ?>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
