<?php
session_start();
include("connection.php");

$user_id = intval($_POST['user_id'] ?? 0);
$group_id = intval($_POST['group_id'] ?? 0);

// Only allow if current user is group owner
$owner_row = mysqli_fetch_assoc(mysqli_query($con, "SELECT user_id FROM user_groups WHERE group_id = '$group_id' ORDER BY id ASC LIMIT 1"));
$owner_id = $owner_row ? $owner_row['user_id'] : 0;
if ($_SESSION['user_id'] != $owner_id) {
    echo json_encode(['success' => false, 'error' => 'Not authorized']);
    exit;
}

// Prevent owner from kicking themselves
if ($user_id == $owner_id) {
    echo json_encode(['success' => false, 'error' => 'Cannot kick owner']);
    exit;
}

// Remove member from group
mysqli_query($con, "DELETE FROM user_groups WHERE user_id='$user_id' AND group_id='$group_id'");
echo json_encode(['success' => true]);
?>