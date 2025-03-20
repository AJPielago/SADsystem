<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'includes/header.php';
require 'config/db.php';

// Debugging: Ensure session user_id is set
if (!isset($_SESSION['user_id'])) {
    die("Error: User ID not found in session.");
}

$today = date('Y-m-d');

// Fetch assigned pickups for today (Collectors should see requests from residents)
$sql = "SELECT ps.schedule_id, ps.request_id, ps.collection_date, ps.collection_time, 
               r.pickup_location, r.waste_type, u.full_name AS resident_name
        FROM pickup_schedules ps
        JOIN pickuprequests r ON ps.request_id = r.request_id
        JOIN users u ON r.user_id = u.user_id  -- Get resident's name
        LEFT JOIN reschedule_requests rr ON ps.schedule_id = rr.schedule_id
        WHERE (rr.schedule_id IS NULL OR rr.status = 'Denied') 
        AND ps.collection_date = CURDATE()";  // Only show today's pickups

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("SQL Error: " . $conn->error);
}

$stmt->execute();
$result = $stmt->get_result();
$pickups = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
$conn->close();
?>

<div class="container mt-4">
    <h2>📦 Assigned Pickups</h2>
    <?php if (!empty($pickups)): ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Resident Name</th>
                    <th>Waste Type</th>
                    <th>Collection Time</th>
                    <th>Pickup Location</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pickups as $pickup): ?>
                    <tr>
                        <td><?= htmlspecialchars($pickup['resident_name']) ?></td>
                        <td><?= htmlspecialchars($pickup['waste_type']) ?></td>
                        <td><?= htmlspecialchars($pickup['collection_time']) ?></td>
                        <td><?= htmlspecialchars($pickup['pickup_location']) ?></td>
                        <td>
                            <form action="reschedule_pickups.php" method="GET" style="display:inline;">
                                <input type="hidden" name="schedule_id" value="<?= $pickup['schedule_id'] ?>">
                                <button type="submit" class="btn btn-warning">Request Reschedule</button>
                            </form>
                            <button class="btn btn-success mark-completed" data-schedule-id="<?= $pickup['schedule_id'] ?>">Mark as Completed</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="alert alert-warning">No pickups assigned for today.</p>
    <?php endif; ?>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('.mark-completed').click(function() {
        var button = $(this);
        var scheduleId = button.data('schedule-id');

        $.ajax({
            url: 'update_status.php',
            type: 'POST',
            data: { schedule_id: scheduleId, status: 'Completed' },
            success: function(response) {
                if (response === 'success') {
                    button.closest('tr').remove();
                    alert('Pickup marked as completed.');
                } else {
                    alert('Error updating status.');
                }
            }
        });
    });
});
</script>

<?php include 'includes/footer.php'; ?>