<?php
require 'config.php';
if (!isset($_SESSION['user_id'])) exit;
$user_id = $_SESSION['user_id'];
$receiver_id = $_GET['receiver_id'];

$stmt = $pdo->prepare("SELECT m.*, u.name as sender_name FROM messages m 
    JOIN users u ON u.id = m.sender_id
    WHERE (sender_id=? AND receiver_id=?) OR (sender_id=? AND receiver_id=?)
    ORDER BY m.created_at ASC");
$stmt->execute([$user_id, $receiver_id, $receiver_id, $user_id]);
$messages = $stmt->fetchAll();

foreach($messages as $msg){
    $align = $msg['sender_id']==$user_id ? 'right' : 'left';
    echo "<div style='text-align:$align; margin:5px;'><b>{$msg['sender_name']}:</b> {$msg['message']}</div>";
}
