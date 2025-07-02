<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

require 'db.php'; // your database connection file

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $sql = "DELETE FROM items WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        // Redirect back with success message
        header("Location: admin_panel.php?msg=ItemDeleted");
        exit();
    } else {
        echo "Error deleting item: " . $conn->error;
    }
} else {
    echo "Invalid request.";
}

$conn->close();
?>
