<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'includes/header.php';
require 'config/db.php';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $item_name = trim($_POST['item_name']);
    $description = trim($_POST['description']);
    $category = trim($_POST['category']);
    $image = "";

    // Handle image upload
    if (!empty($_FILES["image"]["name"])) {
        $target_dir = "uploads/donations/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $image = $target_dir . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $image);
    }

    // Insert into database
    $sql = "INSERT INTO donations (user_id, item_name, description, category, image) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issss", $user_id, $item_name, $description, $category, $image);
    
    if ($stmt->execute()) {
        header("Location: donations.php?success=Donation submitted successfully!");
        exit();
    } else {
        $error = "Error submitting donation: " . $conn->error;
    }
}
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-success text-white">
                    <h3 class="mb-0">Donate an Item</h3>
                </div>
                <div class="card-body">
                    <?php if (isset($_GET['success'])): ?>
                        <div class="alert alert-success"><?= htmlspecialchars($_GET['success']) ?></div>
                    <?php elseif (isset($error)): ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                    <?php endif; ?>

                    <form action="donate.php" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label">Item Name</label>
                            <input type="text" name="item_name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <select name="category" class="form-control" required>
                                <option value="Clothing">Clothing</option>
                                <option value="Electronics">Electronics</option>
                                <option value="Furniture">Furniture</option>
                                <option value="Books">Books</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Upload Image (optional)</label>
                            <input type="file" name="image" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-success w-100">Submit Donation</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>