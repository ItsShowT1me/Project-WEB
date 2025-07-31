<?php

session_start();
include("connection.php");

function generatePin($length = 4) {
    return str_pad(rand(0, pow(10, $length)-1), $length, '0', STR_PAD_LEFT);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $color = mysqli_real_escape_string($con, $_POST['color']);
    $group_id = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT); // Numeric only
    $pin = generatePin(rand(4,5)); // 4 or 5 digit pin

    $sql = "INSERT INTO groups (group_id, name, pin, color) VALUES ('$group_id', '$name', '$pin', '$color')";
    if (mysqli_query($con, $sql)) {
        // Get the inserted group's id
        $group_row = mysqli_query($con, "SELECT id FROM groups WHERE group_id = '$group_id' LIMIT 1");
        $group = mysqli_fetch_assoc($group_row);
        $user_id = $_SESSION['user_id'];
        // Add creator to user_groups
        if (mysqli_query($con, "INSERT INTO user_groups (user_id, group_id) VALUES ('$user_id', '{$group['id']}')")) {
            header("Location: group.php");
            exit();
        } else {
            echo "Error adding creator to group: " . mysqli_error($con);
        }
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
    <link rel="stylesheet" href="CSS code/create_group.css">
    
</head>
<body>
<div class="container mt-5">
    <button class="btn btn-secondary mb-3" onclick="window.history.back();">Return</button>
    <h2>Create Group</h2>
    <form method="POST">
        <div class="mb-3">
            <label for="name" class="form-label">Group Name</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="color" class="form-label">Group Icon Color</label>
            <input type="color" name="color" id="color" class="form-control form-control-color" value="#3a7bd5" title="Choose your color">
        </div>
        <button type="submit" class="btn btn-primary">Create Group</button>
    </form>
</div>
</body>
</html>