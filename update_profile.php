<?php
require 'config.php';
if (!isset($_SESSION['user_id'])) exit;
$user_id = $_SESSION['user_id'];

if($_SERVER['REQUEST_METHOD']=='POST'){
    $name = $_POST['name'];
    $username = $_POST['username'];
    $pic = $_FILES['profile_pic']['name'] ?? null;

    if($pic){
        move_uploaded_file($_FILES['profile_pic']['tmp_name'], "uploads/$pic");
        $stmt = $pdo->prepare("UPDATE users SET name=?, username=?, profile_pic=? WHERE id=?");
        $stmt->execute([$name, $username, $pic, $user_id]);
    } else {
        $stmt = $pdo->prepare("UPDATE users SET name=?, username=? WHERE id=?");
        $stmt->execute([$name, $username, $user_id]);
    }
    echo "Profile updated!";
}
?>

<form method="post" enctype="multipart/form-data">
    Name: <input type="text" name="name" required><br>
    Username: <input type="text" name="username" required><br>
    Foto Profil: <input type="file" name="profile_pic"><br>
    <button type="submit">Update</button>
</form>
