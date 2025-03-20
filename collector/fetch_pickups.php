<?php
require_once '../config/db.php';

header('Content-Type: application/json');

$approved_pickups = [];

$sql = "SELECT p.request_id, b.building_name AS building, 
               COALESCE(p.latitude, b.latitude) AS latitude, 
               COALESCE(p.longitude, b.longitude) AS longitude
        FROM pickuprequests p
        LEFT JOIN users u ON p.user_id = u.user_id
        LEFT JOIN buildings b ON u.building_id = b.building_id
        WHERE p.status = 'approved' AND (p.latitude IS NOT NULL OR b.latitude IS NOT NULL)";

if ($result = $conn->query($sql)) {
    while ($row = $result->fetch_assoc()) {
        if (!empty($row['latitude']) && !empty($row['longitude'])) {
            $approved_pickups[] = $row;
        }
    }
    $result->free();
} else {
    error_log("Database Error: " . $conn->error);
    echo json_encode(["error" => "Database query failed."]);
    exit();
}

// Debugging: Log output in browser console
echo json_encode($approved_pickups, JSON_PRETTY_PRINT);
?>