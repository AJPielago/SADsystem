<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'includes/header.php';

// Fetch the user's building and its coordinates from the database
$userId = $_SESSION['user_id'];
$conn = new mysqli('localhost', 'root', '', 'saddb'); // Update with your database credentials
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch building name from users table
$stmt = $conn->prepare("SELECT building FROM users WHERE user_id = ?");
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}
$stmt->bind_param("i", $userId);
$stmt->execute();
$stmt->bind_result($building);
$stmt->fetch();
$stmt->close();

// Fetch building coordinates from buildings table
$latitude = null;
$longitude = null;
$stmt = $conn->prepare("SELECT latitude, longitude FROM buildings WHERE building_name = ?");
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}
$stmt->bind_param("s", $building);
$stmt->execute();
$stmt->bind_result($latitude, $longitude);
$stmt->fetch();
$stmt->close();
$conn->close();

// Default to a central location if no coordinates are found
if (!$latitude || !$longitude) {
    $latitude = 14.5534;
    $longitude = 121.0490;
}
?>

<div class="container mt-4">
    <h2>Request Trash Pickup</h2>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($_GET['error']) ?></div>
    <?php elseif (isset($_GET['success'])): ?>
        <div class="alert alert-success"><?= htmlspecialchars($_GET['success']) ?></div>
    <?php endif; ?>

    <form action="controllers/submit_pickup.php" method="POST">
        <button type="submit" class="btn btn-primary w-100 p-3">🚛 Submit Pickup Request</button>
    </form>



    <div id="map" style="height: 500px; width: 100%;" class="mt-4"></div>
</div>

<!-- Include Leaflet and FullCalendar libraries -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>


<script>
    document.addEventListener("DOMContentLoaded", function () {
        var map = L.map('map').setView([<?= htmlspecialchars($latitude) ?>, <?= htmlspecialchars($longitude) ?>], 15);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        var marker = L.marker([<?= htmlspecialchars($latitude) ?>, <?= htmlspecialchars($longitude) ?>]).addTo(map)
            .bindPopup('Pickup Location')
            .openPopup();

        map.setMaxBounds([[14.490, 121.015], [14.560, 121.100]]);
        map.setMinZoom(13);

    });
</script>

<?php include 'includes/footer.php'; ?>
