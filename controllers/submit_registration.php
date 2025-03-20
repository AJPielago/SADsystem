<!-- filepath: c:\xamppSAD\htdocs\SADsystem\controllers\submit_registration.php -->
<?php
require_once '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $phone_number = $_POST['phone_number'];
    $building = $_POST['building'];

    // Insert the new user into the database
    $stmt = $conn->prepare("INSERT INTO users (full_name, email, password, phone_number, building) VALUES (?, ?, ?, ?, ?)");
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }
    $stmt->bind_param("sssss", $full_name, $email, $password, $phone_number, $building);

    if ($stmt->execute()) {
        header("Location: ../login.php?success=Registration successful.");
    } else {
        header("Location: ../register.php?error=Failed to register user. " . htmlspecialchars($stmt->error));
    }

    $stmt->close();
    $conn->close();
}
?>