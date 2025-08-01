<?php
session_start();
include("connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $group_id = intval($_POST['group_id']);
    $user_id = $_SESSION['user_id'];
    $message = mysqli_real_escape_string($con, $_POST['message']);

    $sql = "INSERT INTO messages (group_id, user_id, message) VALUES ('$group_id', '$user_id', '$message')";
    mysqli_query($con, $sql);
}
?>