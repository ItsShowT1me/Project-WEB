<?php
session_start();
include("connection.php");

$group_id = intval($_GET['group_id'] ?? 0);

$res = mysqli_query($con, "
    SELECT m.*, u.user_name, u.mbti, u.image
    FROM messages m
    JOIN users u ON m.user_id = u.user_id
    WHERE m.group_id = '$group_id'
    ORDER BY m.created_at ASC
");

$messages = [];
while ($row = mysqli_fetch_assoc($res)) {
    $messages[] = [
        'user_id' => $row['user_id'],
        'user_name' => $row['user_name'],
        'mbti' => $row['mbti'],
        'image' => $row['image'],
        'message' => $row['message'],
        'file_path' => $row['file_path'] ?? null,
        'datetime' => date('d/m/Y H:i', strtotime($row['created_at']))
    ];
}
header('Content-Type: application/json');
echo json_encode($messages);
?>