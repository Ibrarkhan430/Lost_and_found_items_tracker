<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("db/connection.php");

$message = ""; // For user feedback

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $name     = trim($_POST['name']);
    $email    = trim($_POST['email']);
    $password = $_POST['password'];
    $phone    = trim($_POST['phone']);

    // Basic validation
    if (empty($name) || empty($email) || empty($password) || empty($phone)) {
        $message = "<p style='color: red;'>All fields are required.</p>";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "<p style='color: red;'>Please enter a valid email address.</p>";
    } else {
        // Check if email exists
        $check_stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $check_stmt->bind_param("s", $email);
        $check_stmt->execute();
        $check_stmt->store_result();

        if ($check_stmt->num_rows > 0) {
            $message = "<p style='color: red;'>Email already registered. Please login.</p>";
        } else {
            // Hash password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            // Insert user with phone field
            $stmt = $conn->prepare("INSERT INTO users (name, email, password, phone) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $name, $email, $hashed_password, $phone);

            if ($stmt->execute()) {
                $_SESSION['user_id'] = $stmt->insert_id; // Auto-login
                header("Location: dashboard.php");
                exit();
            } else {
                $message = "<p style='color: red;'>Error: " . htmlspecialchars($stmt->error) . "</p>";
            }
            $stmt->close();
        }
        $check_stmt->close();
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Registration</title>
    <style>
        body {
            font-family: Arial;
            background: #f1f1f1;
            padding: 40px;
        }
        form {
            background: white;
            padding: 20px;
            border-radius: 8px;
            width: 320px;
            margin: auto;
            box-shadow: 0px 0px 10px gray;
        }
        input {
            width: 100%;
            padding: 8px;
            margin: 10px 0;
            box-sizing: border-box;
        }
        input[type=submit] {
            background: green;
            color: white;
            border: none;
            cursor: pointer;
        }
        h2, .message {
            text-align: center;
        }
    </style>
</head>
<body>

<form method="post" action="">
    <h2>User Registration</h2>

    <label>Name:</label>
    <input type="text" name="name" required>

    <label>Email:</label>
    <input type="email" name="email" required>

    <label>Password:</label>
    <input type="password" name="password" required>

    <label>Phone:</label>
    <input type="text" name="phone" required>

    <input type="submit" name="register" value="Register">

    <div class="message"><?php echo $message; ?></div>
</form>

</body>
</html>
