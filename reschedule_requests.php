<?php
session_start();
require 'config/db.php';

// Ensure only admins can access this page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch the user's role from the database
$user_id = $_SESSION['user_id'];
$sql_role = "SELECT role FROM users WHERE user_id = ?";
$stmt_role = $conn->prepare($sql_role);
$stmt_role->bind_param("i", $user_id);
$stmt_role->execute();
$result_role = $stmt_role->get_result();
$user = $result_role->fetch_assoc();
$stmt_role->close(); // Close statement

if (!$user || $user['role'] !== 'admin') {
    header("Location: dashboard.php");
    exit();
}

// Fetch only pending reschedule requests
$query = "SELECT rr.reschedule_id, rr.schedule_id, rr.request_date, rr.reason, 
                 u.full_name AS requester_name
          FROM reschedule_requests rr
          JOIN users u ON rr.user_id = u.user_id
          WHERE rr.status = 'Pending'
          ORDER BY rr.request_date DESC";

$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();
$reschedule_requests = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>

<?php include 'includes/header.php'; ?>

<div class="container mt-4">
    <h2>📋 Reschedule Requests</h2>

    <!-- Display Success/Error Messages -->
    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">
            <?= htmlspecialchars($_GET['success']) === 'approve' ? 'Request approved successfully!' : 'Request denied successfully!' ?>
        </div>
    <?php elseif (isset($_GET['error'])): ?>
        <div class="alert alert-danger">
            <?php
            $errors = [
                'update_failed' => 'Failed to update schedule.',
                'deny_failed' => 'Failed to deny request.',
                'invalid_request' => 'Invalid request.'
            ];
            echo $errors[$_GET['error']] ?? 'An unknown error occurred.';
            ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($reschedule_requests)): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Requester</th>
                    <th>Schedule ID</th>
                    <th>Requested Date</th>
                    <th>Reason</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reschedule_requests as $request): ?>
                    <tr>
                        <td><?= htmlspecialchars($request['requester_name']) ?></td>
                        <td><?= htmlspecialchars($request['schedule_id']) ?></td>
                        <td><?= htmlspecialchars($request['request_date']) ?></td>
                        <td><?= htmlspecialchars($request['reason']) ?></td>
                        <td>
                            <form action="handle_reschedule.php" method="POST">
                                <input type="hidden" name="reschedule_id" value="<?= htmlspecialchars($request['reschedule_id']) ?>">
                                <button type="submit" name="action" value="approve" class="btn btn-success btn-sm">Approve</button>
                                <button type="submit" name="action" value="deny" class="btn btn-danger btn-sm">Deny</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-warning text-center">No pending reschedule requests.</div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
