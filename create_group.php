<?php

session_start();
include("connection.php");

function generatePin($length = 4) {
    return str_pad(rand(0, pow(10, $length)-1), $length, '0', STR_PAD_LEFT);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $group_id = uniqid('g_');
    $pin = generatePin(rand(4,5)); // 4 or 5 digit pin

    $sql = "INSERT INTO groups (group_id, name, pin) VALUES ('$group_id', '$name', '$pin')";
    if (mysqli_query($con, $sql)) {
        echo "Group created!<br>Group ID: $group_id<br>PIN: $pin";
    } else {
        echo "Error: " . mysqli_error($con);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Group</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Create Group</h2>
    <form method="POST">
        <div class="mb-3">
            <label for="name" class="form-label">Group Name</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Create Group</button>
    </form>
</div>
</body>
</html>