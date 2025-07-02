<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

require 'db.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_GET['id'])) {
    die("No item ID specified.");
}

$id = intval($_GET['id']);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $description = $conn->real_escape_string($_POST['description']);
    $location = $conn->real_escape_string($_POST['location']);
    $contact = $conn->real_escape_string($_POST['contact']);
    $status = $conn->real_escape_string($_POST['status']);

    $sql = "UPDATE items SET name='$name', description='$description', location='$location', contact='$contact', status='$status' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        header("Location: admin_panel.php?msg=ItemUpdated");
        exit();
    } else {
        echo "Error updating item: " . $conn->error;
    }
}

// Fetch item data to pre-fill form
$sql = "SELECT * FROM items WHERE id = $id LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows !== 1) {
    $item = []; // fallback to avoid undefined variable errors
} else {
    $item = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Item</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="container mt-4">
    <h2>Edit Item</h2>
    <form method="post" action="">
        <div class="mb-3">
            <label for="name" class="form-label">Item Name</label>
            <input type="text" id="name" name="name" class="form-control"
                   value="<?= htmlspecialchars($item['name'] ?? '') ?>" required />
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea id="description" name="description" class="form-control" required><?= htmlspecialchars($item['description'] ?? '') ?></textarea>
        </div>
        <div class="mb-3">
            <label for="location" class="form-label">Location</label>
            <input type="text" id="location" name="location" class="form-control"
                   value="<?= htmlspecialchars($item['location'] ?? '') ?>" required />
        </div>
        <div class="mb-3">
            <label for="contact" class="form-label">Contact</label>
            <input type="text" id="contact" name="contact" class="form-control"
                   value="<?= htmlspecialchars($item['contact'] ?? '') ?>" required />
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select id="status" name="status" class="form-select" required>
                <option value="lost" <?= ($item['status'] ?? '') === 'lost' ? 'selected' : '' ?>>Lost</option>
                <option value="found" <?= ($item['status'] ?? '') === 'found' ? 'selected' : '' ?>>Found</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update Item</button>
        <a href="admin_panel.php" class="btn btn-secondary ms-2">Cancel</a>
    </form>
</div>
</body>
</html>

<?php $conn->close(); ?>
