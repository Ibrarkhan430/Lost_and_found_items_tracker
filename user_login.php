<?php
session_start();
include("db/connection.php");

// Agar user already logged in hai to dashboard pe redirect karo
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}

$message = "";

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($user_id, $hashed_password);
    $stmt->fetch();

    if ($user_id && password_verify($password, $hashed_password)) {
        $_SESSION['user_id'] = $user_id;
        header("Location: dashboard.php");
        exit();
    } else {
        $message = "Invalid email or password.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head><title>User Login</title></head>
<body>

<h2>User Login</h2>

<form method="post" action="">
    Email: <input type="email" name="email" required><br><br>
    Password: <input type="password" name="password" required><br><br>
    <input type="submit" name="login" value="Login">
</form>

<div style="color:red;"><?php echo $message; ?></div>

</body>
</html>
