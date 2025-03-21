<?php
require_once 'config/db.php';

// Fetch buildings from the database
$sql = "SELECT building_id, building_name FROM buildings";
$result = $conn->query($sql);

$buildings = [];
while ($row = $result->fetch_assoc()) {
    $buildings[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2>Register</h2>
        <form action="controllers/submit_registration.php" method="POST">
            <div class="mb-3">
                <label for="full_name" class="form-label">Full Name</label>
                <input type="text" class="form-control" id="full_name" name="full_name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
                <label for="phone_number" class="form-label">Phone Number</label>
                <input type="text" class="form-control" id="phone_number" name="phone_number">
            </div>
            <div class="mb-3">
                <label for="building" class="form-label">Building</label>
                <select class="form-control" id="building" name="building" required>
                    <option value="" disabled selected>Select your building</option>
                    <?php foreach ($buildings as $building): ?>
                        <option value="<?= htmlspecialchars($building['building_id']) ?>" 
                            data-building-id="<?= $building['building_id'] ?>">
                            <?= htmlspecialchars($building['building_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Hidden input for can_request_pickup -->
            <input type="hidden" id="can_request_pickup" name="can_request_pickup" value="0">

            <button type="submit" class="btn btn-primary">Register</button>
        </form>
    </div>

    <script>
        document.getElementById('building').addEventListener('change', function() {
            let buildingId = this.value;

            // Send AJAX request to check if any resident in the building has permission
            fetch('controllers/check_first_resident.php?building_id=' + buildingId)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('can_request_pickup').value = data.is_first ? "1" : "0";
                });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
