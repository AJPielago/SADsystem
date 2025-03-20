<?php
session_start();
require '../config/db.php';

// Ensure session is properly set
if (!isset($_SESSION['user_id'])) {
    die("Unauthorized access: No user_id in session.");
}

// Fetch user role from the database
$user_id = $_SESSION['user_id'];
$sql_role = "SELECT role FROM users WHERE user_id = ?";
$stmt_role = $conn->prepare($sql_role);
$stmt_role->bind_param("i", $user_id);
$stmt_role->execute();
$result_role = $stmt_role->get_result();
$user = $result_role->fetch_assoc();
$stmt_role->close(); // Close statement

if (!$user || $user['role'] !== 'collector') {
    die("Unauthorized access: You do not have collector privileges.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reschedule_id = $_POST['reschedule_id'] ?? null;
    $action = $_POST['action'] ?? null;

    if (!$reschedule_id || !$action) {
        die("Error: Missing reschedule_id or action.");
    }

    // Check if the request exists
    $check_stmt = $conn->prepare("SELECT status FROM reschedule_requests WHERE reschedule_id = ?");
    $check_stmt->bind_param("i", $reschedule_id);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if ($result->num_rows === 0) {
        die("Error: Request not found in database.");
    }

    $request = $result->fetch_assoc();
    $check_stmt->close(); // Close statement

    // Set status based on action
    $status = ($action === 'approve') ? 'Approved' : 'Denied';

    // Update the status
    $update_stmt = $conn->prepare("UPDATE reschedule_requests SET status = ? WHERE reschedule_id = ?");
    $update_stmt->bind_param("si", $status, $reschedule_id);

    if (!$update_stmt->execute()) {
        die("Error: Update failed - " . $conn->error);
    }

    $update_stmt->close();
    $conn->close(); // Close connection

    // Redirect back
    header("Location: ../admin_dashboard.php?success=$action");
    exit();
}
?>
