<?php
$host = "localhost";
$user = "root";
$password = "root";
$database = "lost_found_db";

// Enable mysqli error reporting for debugging (optional - disable in production)
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conn = new mysqli($host, $user, $password, $database);
    $conn->set_charset("utf8mb4");  // Set charset to avoid encoding issues
} catch (mysqli_sql_exception $e) {
    // Don't expose sensitive info in production
    error_log("Database connection error: " . $e->getMessage());
    die("Sorry, we are experiencing technical difficulties. Please try again later.");
}
?>
