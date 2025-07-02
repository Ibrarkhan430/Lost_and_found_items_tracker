<?php
session_start();

$error = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Hardcoded credentials - change as needed
    if ($username === "admin" && $password === "1234") {
        $_SESSION['admin'] = true;
        header("Location: admin_panel.php");
        exit();
    } else {
        $error = "Invalid username or password!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #e9ecef;
            padding: 40px;
            text-align: center;
        }
        form {
            background: white;
            padding: 30px;
            border-radius: 10px;
            display: inline-block;
        }
        input {
            width: 250px;
            padding: 10px;
            margin: 10px 0;
            font-size: 1rem;
        }
        button {
            padding: 10px 20px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 1rem;
        }
        button:hover {
            background: #0056b3;
        }
        .error {
            color: red;
            margin-top: 15px;
        }
    </style>
</head>
<body>

<h2>Admin Login</h2>

<form action="admin_login.php" method="POST" autocomplete="off">
    <input type="text" name="username" placeholder="Username" required autofocus><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <button type="submit">Login</button>
</form>

<?php if ($error): ?>
    <p class="error"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

</body>
</html>
