<?php

session_start();
include("connection.php");

function generatePin($length = 4) {
    $length = max(4, min(5, $length)); // Ensure length is 4 or 5
    return str_pad(mt_rand(0, pow(10, $length)-1), $length, '0', STR_PAD_LEFT);
}

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $group_name = mysqli_real_escape_string($con, $_POST['group_name']);
    $color = mysqli_real_escape_string($con, $_POST['color']);
    $pin = generatePin(rand(4,5));
    $user_id = $_SESSION['user_id'];

    // Insert group
    $sql = "INSERT INTO groups (name, color, pin) VALUES ('$group_name', '$color', '$pin')";
    if (mysqli_query($con, $sql)) {
        $group_id = mysqli_insert_id($con);
        // Add user to group
        mysqli_query($con, "INSERT INTO user_groups (user_id, group_id) VALUES ('$user_id', '$group_id')");
        // Redirect to group page after creation
        header("Location: group.php");
        exit();
    } else {
        $message = "Error creating group.";
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
    <?php if ($message): ?>
        <div class="alert alert-info"><?= $message ?></div>
    <?php endif; ?>
    <form method="POST" action="">
        <div class="mb-3">
            <label for="group_name" class="form-label">Group Name</label>
            <input type="text" class="form-control" id="group_name" name="group_name" required>
        </div>
        <div class="mb-3">
            <label for="color" class="form-label">Group Color</label>
            <input type="color" class="form-control form-control-color" id="color" name="color" value="#3498db">
        </div>
        <button type="submit" class="btn btn-primary">Create</button>
    </form>
</div>
</body>
</html>