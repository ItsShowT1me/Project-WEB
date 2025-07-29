<?php

session_start();
include("connection.php");

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pin = mysqli_real_escape_string($con, $_POST['pin']);
    $user_id = $_SESSION['user_id'];

    // Find group by pin
    $result = mysqli_query($con, "SELECT id FROM groups WHERE pin = '$pin' LIMIT 1");
    if ($row = mysqli_fetch_assoc($result)) {
        $group_id = $row['id'];
        // Check if user already in group
        $check = mysqli_query($con, "SELECT id FROM user_groups WHERE user_id = '$user_id' AND group_id = '$group_id'");
        if (mysqli_num_rows($check) == 0) {
            // Add user to group
            mysqli_query($con, "INSERT INTO user_groups (user_id, group_id) VALUES ('$user_id', '$group_id')");
            header("Location: group.php");
            exit();
        } else {
            $message = "You are already a member of this group.";
        }
    } else {
        $message = "Invalid PIN code.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Join Group</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Join Group</h2>
    <?php if ($message): ?>
        <div class="alert alert-info"><?= $message ?></div>
        <?php if (strpos($message, 'Successfully joined group') !== false): ?>
            <a href="group.php" class="btn btn-success">Go to My Groups</a>
        <?php endif; ?>
    <?php endif; ?>
    <form method="POST" action="">
        <div class="mb-3">
            <label for="pin" class="form-label">Enter Group PIN</label>
            <input type="text" class="form-control" id="pin" name="pin" required maxlength="5" minlength="4">
        </div>
        <button type="submit" class="btn btn-primary">Join</button>
    </form>
</div>
<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>