<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $name = trim($_POST['name']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO users (username, name, password) VALUES (?, ?, ?)");
    if ($stmt->execute([$username, $name, $password])) {
        header("Location: login.php");
        exit;
    } else {
        $error = "Gagal daftar, username mungkin sudah dipakai.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Daftar YoChat</title>
<style>
body {
    margin:0;
    font-family: 'Segoe UI', sans-serif;
    background: linear-gradient(135deg, #43e97b, #38f9d7);
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
}
.register-box {
    background:white;
    padding:40px;
    border-radius:15px;
    width:90%;
    max-width:400px;
    box-shadow:0 8px 25px rgba(0,0,0,0.2);
}
.register-box h2 {
    text-align:center;
    margin-bottom:30px;
    color:#333;
}
.register-box input[type=text],
.register-box input[type=password] {
    width:100%;
    padding:12px 15px;
    margin:10px 0;
    border-radius:8px;
    border:1px solid #ccc;
    outline:none;
    font-size:16px;
}
.register-box button {
    width:100%;
    padding:12px;
    margin-top:15px;
    border:none;
    border-radius:8px;
    background:#43e97b;
    color:white;
    font-size:18px;
    cursor:pointer;
    transition:0.3s;
}
.register-box button:hover {
    background:#38f9d7;
}
.register-box .login-link {
    text-align:center;
    margin-top:20px;
}
.register-box .error {
    color:red;
    text-align:center;
}
</style>
</head>
<body>
<div class="register-box">
    <h2>Daftar YoChat</h2>
    <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>
    <form method="post">
        <input type="text" name="name" placeholder="Nama" required>
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Daftar</button>
    </form>
    <div class="login-link">
        Sudah punya akun? <a href="login.php">Login di sini</a>
    </div>
</div>
</body>
</html>
