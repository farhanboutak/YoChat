<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        header("Location: index.php");
        exit;
    } else {
        $error = "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login YoChat</title>
<style>
body {
    margin:0;
    font-family: 'Segoe UI', sans-serif;
    background: linear-gradient(135deg, #4facfe, #00f2fe);
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
}
.login-box {
    background:white;
    padding:40px;
    border-radius:15px;
    width:90%;
    max-width:400px;
    box-shadow:0 8px 25px rgba(0,0,0,0.2);
}
.login-box h2 {
    text-align:center;
    margin-bottom:30px;
    color:#333;
}
.login-box input[type=text],
.login-box input[type=password] {
    width:100%;
    padding:12px 15px;
    margin:10px 0;
    border-radius:8px;
    border:1px solid #ccc;
    outline:none;
    font-size:16px;
}
.login-box button {
    width:100%;
    padding:12px;
    margin-top:15px;
    border:none;
    border-radius:8px;
    background:#4facfe;
    color:white;
    font-size:18px;
    cursor:pointer;
    transition:0.3s;
}
.login-box button:hover {
    background:#00f2fe;
}
.login-box .register-link {
    text-align:center;
    margin-top:20px;
}
.login-box .error {
    color:red;
    text-align:center;
}
</style>
</head>
<body>
<div class="login-box">
    <h2>Login YoChat</h2>
    <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>
    <form method="post">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
    <div class="register-link">
        Belum punya akun? <a href="register.php">Daftar di sini</a>
    </div>
</div>
</body>
</html>
