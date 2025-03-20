<?php
// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Include header first - this will establish the database connection
include 'includes/header.php';

// Now get the database connection from the already included file
// We don't need to require db.php again since header.php already includes it
// But we need to make sure we're using the same connection

// Get current week's start and end date
$start_of_week = date('Y-m-d', strtotime('monday this week'));
$end_of_week = date('Y-m-d', strtotime('sunday this week'));

// Fetch scheduled pickups for this week (for all users)
$sql = "SELECT created_at, building_id, latitude, longitude 
        FROM pickuprequests 
        WHERE status = 'pending' 
        AND DATE(created_at) BETWEEN ? AND ?
        ORDER BY created_at";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die('Prepare failed: ' . htmlspecialchars($conn->error));
}
$stmt->bind_param("ss", $start_of_week, $end_of_week);
$stmt->execute();
$result = $stmt->get_result();

$pickups = [];
while ($row = $result->fetch_assoc()) {
    $pickups[] = $row;
}
$stmt->close();
// Do NOT close $conn here as it will be needed by other parts of the application

// Days of the week mapping
$days_of_week = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];
?>

<div class="container" style="margin-top: 80px;">
    <h2 class="text-center">Weekly Pickup Schedule</h2>
    <div class="schedule-container">
        <div class="time-column"></div>
        <?php foreach ($days_of_week as $day) echo "<div class='text-center fw-bold'>$day</div>"; ?>
        
        <?php
        for ($hour = 7; $hour <= 18; $hour++) {
            $time_label = date("h:i A", strtotime("$hour:00"));
            echo "<div class='time-column'>$time_label</div>";
            foreach ($days_of_week as $day) {
                echo "<div class='schedule-cell' data-day='$day' data-time='$hour:00'></div>";
            }
        }
        ?>
    </div>
</div> 

<script>
    document.addEventListener("DOMContentLoaded", function () {
        let pickups = <?php echo json_encode($pickups); ?>;
        pickups.forEach(pickup => {
            let date = new Date(pickup.created_at);
            let dayName = date.toLocaleDateString('en-US', { weekday: 'long' });
            let time = date.toTimeString().substring(0, 5);
            let cell = document.querySelector(`[data-day='${dayName}'][data-time='${time}']`);
            if (cell) {
                let div = document.createElement("div");
                div.className = "pickup-block";
                div.innerText = pickup.building;
                cell.appendChild(div);
            }
        });
    });
</script>

<style>
    .schedule-container {
        display: grid;
        grid-template-columns: 100px repeat(7, 1fr);
    }
    .time-column {
        background: #f0f0f0;
        text-align: center;
    }
    .schedule-cell {
        border: 1px solid #ddd;
        min-height: 50px;
        position: relative;
    }
    .pickup-block {
        background: #a0d468;
        position: absolute;
        width: 100%;
        text-align: center;
        padding: 5px;
        border-radius: 5px;
    }
</style>

<?php 
// Close the connection only at the very end if needed
// $conn->close(); // Commented out as this should be handled in footer.php

include 'includes/footer.php'; 
?>