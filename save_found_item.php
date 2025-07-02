<?php
session_start();
include 'db/connection.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Make sure this path is correct

if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please log in to report a found item.'); window.location.href='login.php';</script>";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id     = $_SESSION['user_id'];
    $name        = trim($_POST['name']);
    $description = trim($_POST['description']);
    $location    = trim($_POST['location']);
    $date        = $_POST['date'];
    $contact     = trim($_POST['contact']);
    $status      = strtolower(trim($_POST['status'])); // Should be "found"

    // --- Image upload ---
    $image_path = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
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

    // --- Insert found item with image ---
    $stmt = $conn->prepare("INSERT INTO items (user_id, name, description, location, date, contact, status, image) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssssss", $user_id, $name, $description, $location, $date, $contact, $status, $image_path);

    if ($stmt->execute()) {
        $item_id = $stmt->insert_id;

        // --- Match with lost items ---
        if ($status === 'found') {
            $match_query = $conn->prepare("SELECT id, user_id FROM items WHERE LOWER(name) = LOWER(?) AND status = 'lost'");
            $match_query->bind_param("s", $name);
            $match_query->execute();
            $result = $match_query->get_result();

            while ($row = $result->fetch_assoc()) {
                $lost_user_id = $row['user_id'];
                $message = "Someone reported a found item that matches your lost item: '" . htmlspecialchars($name) . "'";
                $from_user_id = $user_id;

                // --- Save notification ---
                $notify_stmt = $conn->prepare("INSERT INTO notifications (from_user_id, user_id, message, item_id) 
                                               VALUES (?, ?, ?, ?)");
                $notify_stmt->bind_param("iisi", $from_user_id, $lost_user_id, $message, $item_id);
                $notify_stmt->execute();
                $notify_stmt->close();

                // --- Send email to lost item user ---
                $email_stmt = $conn->prepare("SELECT email FROM users WHERE id = ?");
                $email_stmt->bind_param("i", $lost_user_id);
                $email_stmt->execute();
                $email_result = $email_stmt->get_result();

                if ($email_row = $email_result->fetch_assoc()) {
                    $lost_user_email = $email_row['email'];

                    $mail = new PHPMailer(true);
                    try {
                        $mail->isSMTP();
                        $mail->Host       = 'smtp.gmail.com';
                        $mail->SMTPAuth   = true;
                        $mail->Username   = 'ia7672848@gmail.com'; // Your Gmail
                        $mail->Password   = 'mrgx legt kdtk mfkm';  // App Password
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                        $mail->Port       = 587;

                        $mail->setFrom('ia7672848@gmail.com', 'Lost and Found');
                        $mail->addAddress($lost_user_email);

                        $mail->isHTML(true);
                        $mail->Subject = 'Match Found for Your Lost Item!';
                        $mail->Body    = "
                            Hello,<br><br>
                            A <b>found item</b> has been reported that may match the item you lost:<br><br>
                            <b>Item Name:</b> " . htmlspecialchars($name) . "<br>
                            <b>Contact Info:</b> " . htmlspecialchars($contact) . "<br><br>
                            Please log in to the website to see more details.<br><br>
                            Thank you,<br>
                            Lost and Found Team
                        ";

                        $mail->send();
                    } catch (Exception $e) {
                        error_log("Email error to $lost_user_email: {$mail->ErrorInfo}");
                    }
                }

                $email_stmt->close();
            }

            $match_query->close();
        }

        echo "<script>alert('Found item submitted successfully!'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Error saving item: " . addslashes($stmt->error) . "');</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
