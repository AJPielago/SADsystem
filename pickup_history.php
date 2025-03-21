<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'includes/header.php';
require 'config/db.php';

$user_id = $_SESSION['user_id'];

// Get the user's building ID
$sql_building = "SELECT building_id FROM users WHERE user_id = ?";
$stmt_building = $conn->prepare($sql_building);
if (!$stmt_building) {
    die("SQL Error: " . $conn->error);
}
$stmt_building->bind_param("i", $user_id);
$stmt_building->execute();
$result_building = $stmt_building->get_result();
$user_data = $result_building->fetch_assoc();

if (!$user_data || !isset($user_data['building_id'])) {
    die("Error retrieving building information.");
}

$building_id = $user_data['building_id'];

// Get the lowest user_id in the building
$sql_lowest_user = "SELECT MIN(user_id) AS lowest_user FROM users WHERE building_id = ?";
$stmt_lowest_user = $conn->prepare($sql_lowest_user);
if (!$stmt_lowest_user) {
    die("SQL Error: " . $conn->error);
}
$stmt_lowest_user->bind_param("i", $building_id);
$stmt_lowest_user->execute();
$result_lowest_user = $stmt_lowest_user->get_result();
$lowest_user = $result_lowest_user->fetch_assoc()['lowest_user'] ?? null;

// Restrict access if the user is not the lowest user in the building
if ($user_id != $lowest_user) {
    header("Location: dashboard.php");
    exit();
}

// Fetch user details safely
$sql_user = "SELECT full_name FROM users WHERE user_id = ?";
$stmt_user = $conn->prepare($sql_user);
if (!$stmt_user) {
    die("SQL Error: " . $conn->error);
}
$stmt_user->bind_param("i", $user_id);
$stmt_user->execute();
$result_user = $stmt_user->get_result();
$user = $result_user->fetch_assoc();
$full_name = $user['full_name'] ?? 'User';

// Fetch completed pickups with building name
$sql_completed = "SELECT pr.request_id, pr.status, pr.created_at, pr.building_id, b.building_name, pr.latitude, pr.longitude 
                  FROM pickuprequests pr 
                  LEFT JOIN buildings b ON pr.building_id = b.building_id
                  WHERE pr.user_id = ? AND pr.status = 'completed' 
                  ORDER BY pr.created_at DESC";
$stmt_completed = $conn->prepare($sql_completed);
if (!$stmt_completed) {
    die("SQL Error: " . $conn->error);
}
$stmt_completed->bind_param("i", $user_id);
$stmt_completed->execute();
$result_completed = $stmt_completed->get_result();

// Fetch pending pickups with building name
$sql_pending = "SELECT pr.request_id, pr.status, pr.created_at, pr.building_id, b.building_name, pr.latitude, pr.longitude 
                FROM pickuprequests pr 
                LEFT JOIN buildings b ON pr.building_id = b.building_id
                WHERE pr.user_id = ? AND pr.status = 'pending' 
                ORDER BY pr.created_at DESC";
$stmt_pending = $conn->prepare($sql_pending);
if (!$stmt_pending) {
    die("SQL Error: " . $conn->error);
}
$stmt_pending->bind_param("i", $user_id);
$stmt_pending->execute();
$result_pending = $stmt_pending->get_result();
?>

<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-body text-center">
            <h2 class="card-title">Recent Activities</h2>
            <p class="text-muted">Review your past and upcoming waste pickups.</p>
        </div>
    </div>

    <!-- Completed Pickups -->
    <div class="mt-4">
        <h4>✅ Completed Pickups</h4>
        <?php if ($result_completed->num_rows > 0): ?>
            <div class="list-group">
                <?php while ($pickup = $result_completed->fetch_assoc()): ?>
                    <div class="list-group-item">
                        <div class="d-flex justify-content-between">
                            <div>
                                <strong>📅 Request Date:</strong> <?= htmlspecialchars($pickup['created_at']) ?><br>
                                <strong>🏢 Building:</strong> <?= htmlspecialchars($pickup['building_name'] ?? 'Unknown Building') ?><br>
                                <strong>📍 Location:</strong> 
                                <?= "Lat: " . htmlspecialchars($pickup['latitude']) . ", Long: " . htmlspecialchars($pickup['longitude']) ?>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-warning mt-2">No completed pickups found.</div>
        <?php endif; ?>
    </div>

    <!-- Pending Pickups -->
    <div class="mt-4">
        <h4>⏳ Pending Pickups</h4>
        <?php if ($result_pending->num_rows > 0): ?>
            <div class="list-group">
                <?php while ($pickup = $result_pending->fetch_assoc()): ?>
                    <div class="list-group-item list-group-item-warning">
                        <div class="d-flex justify-content-between">
                            <div>
                                <strong>📅 Request Date:</strong> <?= htmlspecialchars($pickup['created_at']) ?><br>
                                <strong>🏢 Building:</strong> <?= htmlspecialchars($pickup['building_name'] ?? 'Unknown Building') ?><br>
                                <strong>📍 Location:</strong> 
                                <?= "Lat: " . htmlspecialchars($pickup['latitude']) . ", Long: " . htmlspecialchars($pickup['longitude']) ?>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-secondary mt-2">No pending pickups found.</div>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
