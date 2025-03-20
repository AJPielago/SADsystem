<!-- filepath: c:\xamppSAD\htdocs\SADsystem\controllers\submit_pickup.php -->
<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

require_once '../config/db.php'; // Include your database connection file

// Fetch the user's building from the database
$userId = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT building FROM users WHERE user_id = ?");
if ($stmt === false) {
    die('Prepare failed: ' . htmlspecialchars($conn->error));
}
$stmt->bind_param("i", $userId);
$stmt->execute();
$stmt->bind_result($building);
$stmt->fetch();
$stmt->close();

// Get the coordinates of the building from the buildings table
$stmt = $conn->prepare("SELECT latitude, longitude FROM buildings WHERE building_name = ?");
if ($stmt === false) {
    die('Prepare failed: ' . htmlspecialchars($conn->error));
}
$stmt->bind_param("s", $building);
$stmt->execute();
$stmt->bind_result($latitude, $longitude);
$stmt->fetch();
$stmt->close();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status = 'pending';
    $created_at = date('Y-m-d H:i:s');

    // Insert the pickup request into the database
    $stmt = $conn->prepare("INSERT INTO pickuprequests (user_id, building, latitude, longitude, status, created_at) VALUES (?, ?, ?, ?, ?, ?)");
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }
    $stmt->bind_param("isssss", $userId, $building, $latitude, $longitude, $status, $created_at);

    if ($stmt->execute()) {
        header("Location: ../pickup.php?success=Pickup request submitted successfully.");
    } else {
        header("Location: ../pickup.php?error=Failed to submit pickup request. " . htmlspecialchars($stmt->error));
    }

    $stmt->close();
    $conn->close();
}
?>