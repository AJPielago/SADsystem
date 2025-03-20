<?php
session_start();
require 'config/db.php';

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    die("Session Error: User ID not found. Please log in.");
}

$user_id = $_SESSION['user_id'];

// Fetch user role from the database
$query = "SELECT role FROM users WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    die("Database Error: User ID $user_id not found in users table.");
}


// Ensure the user is a Collector
if ($user['role'] !== 'collector') {
    die("Access Denied: You are not authorized to request a reschedule.");
}

// Ensure schedule_id is received via GET
if (!isset($_GET['schedule_id'])) {
    die("Error: Schedule ID missing.");
}

$schedule_id = intval($_GET['schedule_id']);

// Fetch schedule details
$query = "SELECT ps.schedule_id, ps.collection_date, ps.collection_time, r.pickup_location, r.waste_type 
          FROM pickup_schedules ps
          JOIN pickuprequests r ON ps.request_id = r.request_id
          WHERE ps.schedule_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $schedule_id);
$stmt->execute();
$result = $stmt->get_result();
$schedule = $result->fetch_assoc();

if (!$schedule) {
    die("Error: Schedule not found.");
}

// Check if a reschedule request already exists for this schedule
$check_query = "SELECT * FROM reschedule_requests WHERE schedule_id = ? AND user_id = ? AND status = 'Pending'";
$check_stmt = $conn->prepare($check_query);
$check_stmt->bind_param("ii", $schedule_id, $user_id);
$check_stmt->execute();
$check_result = $check_stmt->get_result();

if ($check_result->num_rows > 0) {
    die("Error: You have already requested a reschedule for this pickup.");
}

$stmt->close();
?>

<?php include 'includes/header.php'; ?>

<div class="container mt-4">
    <h2>🚛 Request Reschedule</h2>
    <p><strong>Schedule ID:</strong> <?= htmlspecialchars($schedule['schedule_id']) ?></p>
    <p><strong>Collection Date:</strong> <?= htmlspecialchars($schedule['collection_date']) ?></p>
    <p><strong>Collection Time:</strong> <?= htmlspecialchars($schedule['collection_time']) ?></p>
    <p><strong>Pickup Location:</strong> <?= htmlspecialchars($schedule['pickup_location']) ?></p>
    <p><strong>Waste Type:</strong> <?= htmlspecialchars($schedule['waste_type']) ?></p>

    <form action="request_reschedule.php" method="POST">
        <input type="hidden" name="schedule_id" value="<?= $schedule_id ?>">

        <div class="mb-3">
            <label for="reason" class="form-label">Reason for Reschedule:</label>
            <textarea name="reason" id="reason" class="form-control" required></textarea>
        </div>

        <button type="submit" class="btn btn-warning">Submit Request</button>
        <a href="assigned_pickups.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<?php include 'includes/footer.php'; ?>
