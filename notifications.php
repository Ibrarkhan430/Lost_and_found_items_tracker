<?php
session_start();
include 'db/connection.php';

if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please login to view notifications.'); window.location.href='login.php';</script>";
    exit();
}

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("
    SELECT n.*, 
           u.name AS from_name, u.phone AS from_phone,
           i.name AS item_name, i.contact AS item_contact,
           i.image AS item_image
    FROM notifications n
    LEFT JOIN users u ON n.from_user_id = u.id
    LEFT JOIN items i ON n.item_id = i.id
    WHERE n.user_id = ?
    ORDER BY n.created_at DESC
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Your Notifications</title>
    <style>
        body { font-family: Arial; background-color: #f2f2f2; padding: 20px; }
        .notification { background: white; padding: 15px; margin-bottom: 10px; border-left: 5px solid #2196F3; border-radius: 8px; }
        .read { opacity: 0.6; }
        img.item-image { max-width: 250px; height: auto; display: block; margin-top: 10px; border-radius: 8px; box-shadow: 0 0 5px rgba(0,0,0,0.3); }
    </style>
</head>
<body>
    <h2>Your Notifications</h2>

    <?php
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $readClass = $row['is_read'] ? 'read' : '';
            echo "<div class='notification $readClass'>";
            echo "<p>" . nl2br(htmlspecialchars($row['message'])) . "</p>";

            // Show item name
            if (!empty($row['item_name'])) {
                echo "<p><strong>Item:</strong> " . htmlspecialchars($row['item_name']) . "</p>";
            }

            // Show image if available
            if (!empty($row['item_image'])) {
                echo "<img src='" . htmlspecialchars($row['item_image']) . "' class='item-image' alt='Item image'>";
            } else {
                echo "<p><em>No image available</em></p>";
            }

            // Reporter name
            if (!empty($row['from_name'])) {
                echo "<p><strong>Reported by:</strong> " . htmlspecialchars($row['from_name']) . "</p>";
            }

            // Contact
            if (!empty($row['item_contact'])) {
                echo "<p><strong>Contact Info:</strong> " . htmlspecialchars($row['item_contact']) . "</p>";
            }

            echo "<small>Received on: " . htmlspecialchars($row['created_at']) . "</small>";
            echo "</div>";
        }

        // Mark all as read
        $update = $conn->prepare("UPDATE notifications SET is_read = 1 WHERE user_id = ?");
        $update->bind_param("i", $user_id);
        $update->execute();
        $update->close();
    } else {
        echo "<p>No notifications found.</p>";
    }

    $stmt->close();
?>
</body>
</html>
