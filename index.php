<?php
require 'config.php';
if (!isset($_SESSION['user_id'])) header("Location: login.php");
$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$current_user = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>YoChat</title>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<style>
* { box-sizing:border-box; margin:0; padding:0; font-family:'Segoe UI', sans-serif; }
body { height:100vh; display:flex; background:#f0f2f5; }
.container { display:flex; width:100%; height:100vh; overflow:hidden; }
.sidebar { width:30%; max-width:300px; background:white; border-right:1px solid #ddd; display:flex; flex-direction:column; }
.sidebar header { padding:20px; font-size:18px; font-weight:bold; text-align:center; border-bottom:1px solid #ddd; display:flex; flex-direction:column; align-items:center; }
#profile_pic { width:60px; height:60px; border-radius:50%; margin-bottom:10px; object-fit:cover; cursor:pointer; border:2px solid #4facfe; }
#search { padding:10px 15px; margin:10px; border-radius:20px; border:1px solid #ccc; width:calc(100% - 40px); }
#user_list { flex:1; overflow-y:auto; }
.user { display:flex; align-items:center; padding:10px; cursor:pointer; border-bottom:1px solid #f0f0f0; transition:0.2s; }
.user img { width:40px; height:40px; border-radius:50%; margin-right:10px; object-fit:cover; }
.user:hover, .user.selected { background:#e6f7ff; }
.chat-container { flex:1; display:flex; flex-direction:column; }
.chat-header { padding:15px; border-bottom:1px solid #ddd; display:flex; align-items:center; background:white; position:sticky; top:0; z-index:10; }
.chat-header img { width:40px; height:40px; border-radius:50%; margin-right:10px; object-fit:cover; }
.chat-header span { font-weight:bold; font-size:16px; }
.messages { flex:1; padding:15px; overflow-y:auto; background:#f9f9f9; }
.message { margin:5px 0; padding:10px 15px; border-radius:20px; max-width:70%; word-wrap:break-word; }
.message.sent { background:#4facfe; color:white; margin-left:auto; border-bottom-right-radius:0; }
.message.received { background:#e4e6eb; color:#000; margin-right:auto; border-bottom-left-radius:0; }
.chat-input { display:flex; padding:10px; border-top:1px solid #ddd; background:white; }
.chat-input input { flex:1; padding:10px 15px; border-radius:20px; border:1px solid #ccc; outline:none; }
.chat-input button { margin-left:10px; padding:10px 20px; border:none; border-radius:20px; background:#4facfe; color:white; cursor:pointer; }
@media(max-width:768px) {
    .container { flex-direction:column; }
    .sidebar { width:100%; max-width:none; height:40%; }
    .chat-container { height:60%; }
}
</style>
</head>
<body>
<div class="container">
    <div class="sidebar">
        <header>
            <img id="profile_pic" src="uploads/<?= $current_user['profile_pic'] ?: 'default.png'; ?>" alt="Avatar" title="Klik untuk ganti foto">
            YoChat
        </header>
        <input type="text" id="search" placeholder="Cari user...">
        <div id="user_list"></div>
    </div>
    <div class="chat-container">
        <div class="chat-header" id="chat_header" style="display:none;">
            <img id="chat_avatar" src="default.png" alt="Avatar">
            <span id="chat_name"></span>
        </div>
        <div class="messages" id="messages"></div>
        <div class="chat-input">
            <input type="text" id="message" placeholder="Ketik pesan...">
            <button id="send_btn">Kirim</button>
        </div>
    </div>
</div>

<!-- Form upload profile (hidden) -->
<form id="upload_form" style="display:none;" enctype="multipart/form-data">
    <input type="file" name="profile_pic" id="upload_input" accept="image/*">
</form>

<script>
let selectedUser = null;

// Load user list
function loadUsers(query='') {
    $.get('get_users.php', {q: query}, function(data) {
        $('#user_list').html(data);
    });
}

// Load chat messages
function loadMessages() {
    if (!selectedUser) return;
    $.get('get_messages.php', {receiver_id:selectedUser}, function(data) {
        $('#messages').html(data);
        $('#messages').scrollTop($('#messages')[0].scrollHeight);
    });
}

// Select user to chat
$(document).on('click', '.user', function(){
    $('.user').removeClass('selected');
    $(this).addClass('selected');
    selectedUser = $(this).data('id');
    let name = $(this).data('name');
    let avatar = $(this).data('avatar');
    $('#chat_name').text(name);
    $('#chat_avatar').attr('src', avatar);
    $('#chat_header').show();
    loadMessages();
});

// Search
$('#search').on('input', function() { loadUsers($(this).val()); });

// Send message
$('#send_btn').click(function(){
    if (!selectedUser) return;
    let msg = $('#message').val();
    if(msg.trim()=='') return;
    $.post('send_message.php', {receiver_id:selectedUser, message:msg}, function(){
        $('#message').val('');
        loadMessages();
    });
});
$('#message').keypress(function(e){
    if(e.which==13){ $('#send_btn').click(); return false; }
});

// Upload profile picture
$('#profile_pic').click(function(){
    $('#upload_input').click();
});
$('#upload_input').change(function(){
    let formData = new FormData($('#upload_form')[0]);
    $.ajax({
        url:'update_profile.php',
        type:'POST',
        data:formData,
        contentType:false,
        processData:false,
        success:function(resp){
            $('#profile_pic').attr('src', 'uploads/' + $('#upload_input')[0].files[0].name);
            alert('Foto profil berhasil diubah!');
        }
    });
});

setInterval(loadMessages, 2000);
loadUsers();
</script>
</body>
</html>
