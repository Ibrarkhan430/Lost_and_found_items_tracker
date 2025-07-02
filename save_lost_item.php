<?php
session_start();
include 'db/connection.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please log in to report a lost item.'); window.location.href='login.php';</script>";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id     = $_SESSION['user_id'];
    $name        = htmlspecialchars(trim($_POST['name'] ?? ''), ENT_QUOTES);
    $description = htmlspecialchars(trim($_POST['description'] ?? ''), ENT_QUOTES);
    $location    = htmlspecialchars(trim($_POST['location'] ?? ''), ENT_QUOTES);
    $date        = trim($_POST['date'] ?? '');
    $contact     = htmlspecialchars(trim($_POST['contact'] ?? ''), ENT_QUOTES);
    $status      = strtolower(trim($_POST['status'] ?? ''));

    // Handle image upload if provided
    $image_path = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $image_name = time() . '_' . basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $image_name;
        $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($image_file_type, $allowed_types) && $_FILES["image"]["size"] <= 5 * 1024 * 1024) {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $image_path = $target_file;
            } else {
                echo "<script>alert('Failed to upload image.'); window.history.back();</script>";
                exit();
            }
        } else {
            echo "<script>alert('Invalid image format or size (Max 5MB).'); window.history.back();</script>";
            exit();
        }
    }

    // Validate required fields and status
    if (empty($name) || empty($location) || empty($date) || empty($contact) || $status !== 'lost') {
        echo "<script>alert('Please fill all required fields and set status to lost.'); window.history.back();</script>";
        exit();
    }

    // Insert the lost item into the database
    $stmt = $conn->prepare("INSERT INTO items (user_id, name, description, location, date, contact, status, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("isssssss", $user_id, $name, $description, $location, $date, $contact, $status, $image_path);

    if ($stmt->execute()) {
        $item_id = $stmt->insert_id;

        // Find matching found items by name
        $match_stmt = $conn->prepare("SELECT id, user_id FROM items WHERE LOWER(name) = LOWER(?) AND status = 'found'");
        if ($match_stmt) {
            $match_stmt->bind_param("s", $name);
            $match_stmt->execute();
            $result = $match_stmt->get_result();

            while ($row = $result->fetch_assoc()) {
                $found_user_id = $row['user_id'];

                $message = "Someone reported a lost item matching your found item: '" . htmlspecialchars($name, ENT_QUOTES) . "'.";

                $notify_stmt = $conn->prepare("INSERT INTO notifications (from_user_id, user_id, item_id, message) VALUES (?, ?, ?, ?)");
                if ($notify_stmt) {
                    $notify_stmt->bind_param("iiis", $user_id, $found_user_id, $item_id, $message);
                    $notify_stmt->execute();
                    $notify_stmt->close();
                }
            }
            $match_stmt->close();
        }

        echo "<script>alert('Lost item reported successfully!'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Error: " . htmlspecialchars($stmt->error, ENT_QUOTES) . "'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();

} else {
    // If request is not POST, redirect to homepage
    header("Location: index.php");
    exit();
}
?>
