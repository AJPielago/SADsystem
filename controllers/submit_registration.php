<?php
require_once '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $phone_number = trim($_POST['phone_number']);
    $building_id = intval($_POST['building']); // Ensure it's an integer

    // Insert the new user into the database
    $stmt = $conn->prepare("INSERT INTO users (full_name, email, password, phone_number, building_id) VALUES (?, ?, ?, ?, ?)");
    if (!$stmt) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }

    $stmt->bind_param("ssssi", $full_name, $email, $password, $phone_number, $building_id);

    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        header("Location: ../login.php?success=Registration successful.");
        exit();
    } else {
        $stmt->close();
        $conn->close();
        header("Location: ../register.php?error=Failed to register user. " . htmlspecialchars($stmt->error));
        exit();
    }
}
?>
