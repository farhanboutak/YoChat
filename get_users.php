<?php
require 'config.php';
$user_id = $_SESSION['user_id'] ?? 0;
$q = $_GET['q'] ?? '';

$stmt = $pdo->prepare("SELECT * FROM users WHERE (username LIKE ? OR name LIKE ?) AND id != ?");
$stmt->execute(["%$q%", "%$q%", $user_id]);
$users = $stmt->fetchAll();

foreach($users as $user){
    echo "<div class='user' data-id='{$user['id']}'>
    <img src='uploads/{$user['profile_pic']}' width='30'> {$user['name']} (@{$user['username']})
    </div>";
}
