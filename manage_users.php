<?php
session_start();
include 'includes/header.php';
include 'config/db.php';

// Check if the user is an admin
if (!isset($_SESSION['role']) || strtolower($_SESSION['role']) !== 'admin') {
    echo "<script>alert('Access Denied!'); window.location.href='../index.php';</script>";
    exit();
}

// Fetch users from the database
$query = "SELECT user_id, full_name, email, phone_number, address, role FROM users";
$result = mysqli_query($conn, $query);

// Handle role update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_role'])) {
    $user_id = $_POST['user_id'];
    $new_role = $_POST['role'];

    // Prevent SQL Injection
    $user_id = mysqli_real_escape_string($conn, $user_id);
    $new_role = mysqli_real_escape_string($conn, $new_role);

    $update_query = "UPDATE users SET role = ? WHERE user_id = ?";
    $stmt = mysqli_prepare($conn, $update_query);
    mysqli_stmt_bind_param($stmt, "si", $new_role, $user_id);

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['message'] = "User role updated successfully!";
    } else {
        $_SESSION['error'] = "Error updating role!";
    }

    header("Location: manage_users.php");
    exit();
}
?>

<div class="container mt-4">
    <h2 class="mb-4">Manage Users</h2>

    <!-- Success/Error Messages -->
    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($_SESSION['message']); unset($_SESSION['message']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Role</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= htmlspecialchars($row['user_id']); ?></td>
                    <td><?= htmlspecialchars($row['full_name']); ?></td>
                    <td><?= htmlspecialchars($row['email']); ?></td>
                    <td><?= htmlspecialchars($row['phone_number']); ?></td>
                    <td><?= htmlspecialchars($row['address']); ?></td>
                    <td>
                        <form method="POST">
                            <input type="hidden" name="user_id" value="<?= htmlspecialchars($row['user_id']); ?>">
                            <select name="role" class="form-select">
                                <option value="resident" <?= ($row['role'] === 'resident') ? 'selected' : ''; ?>>Resident</option>
                                <option value="admin" <?= ($row['role'] === 'admin') ? 'selected' : ''; ?>>Admin</option>
                                <option value="collector" <?= ($row['role'] === 'collector') ? 'selected' : ''; ?>>Collector</option>
                            </select>
                    </td>
                    <td>
                        <button type="submit" name="update_role" class="btn btn-primary btn-sm">
                            <i class="bi bi-pencil-square"></i> Update
                        </button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include 'includes/footer.php'; ?>
