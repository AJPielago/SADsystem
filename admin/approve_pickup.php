<!-- filepath: c:\xamppSAD\htdocs\SADsystem\controllers\approve_pickup.php -->
<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

require_once '../config/db.php'; // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $request_id = $_POST['request_id'];
    $status = 'approved';

    // Update the status of the pickup request
    $stmt = $conn->prepare("UPDATE pickuprequests SET status = ? WHERE request_id = ?");
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }
    $stmt->bind_param("si", $status, $request_id);

    if ($stmt->execute()) {
        header("Location: ../admin_dashboard.php?success=Pickup request approved successfully.");
    } else {
        header("Location: ../admin_dashboard.php?error=Failed to approve pickup request. " . htmlspecialchars($stmt->error));
    }

    $stmt->close();
    $conn->close();
}
?>