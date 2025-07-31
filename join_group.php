<?php
session_start();
include("connection.php");

$message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pin = mysqli_real_escape_string($con, $_POST['pin']);
    $user_id = $_SESSION['user_id'];

    // Find group by PIN
    $group_result = mysqli_query($con, "SELECT id FROM groups WHERE pin = '$pin' LIMIT 1");
    if ($group = mysqli_fetch_assoc($group_result)) {
        $group_id = $group['id'];
        // Check if user already joined
        $check = mysqli_query($con, "SELECT * FROM user_groups WHERE user_id = '$user_id' AND group_id = '$group_id'");
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
    <link rel="stylesheet" href="CSS code/join_group.css">
</head>
<body style="position:relative;">
<div class="container" style="max-width:400px;margin:60px auto;padding:32px;background:#222;border-radius:16px;box-shadow:0 4px 24px #0003;">
    <h2 style="color:#3a7bd5;text-align:center;margin-bottom:32px;">Project group</h2>
    <?php if ($message): ?>
        <p class="error" style="color:#ff4d4f;text-align:center;margin-bottom:16px;">
            <?= $message ?>
        </p>
    <?php endif; ?>
    <form method="POST" action="" style="display:flex;flex-direction:column;gap:16px;">
        <input type="text" id="gamePin" name="pin" class="form-control"
               placeholder="Group PIN" required maxlength="5" minlength="4"
               style="font-size:1.2em;padding:12px 16px;border-radius:8px;border:1px solid #3a7bd5;">
        <button type="submit" id="enterBtn" class="btn btn-primary"
                style="background:#3a7bd5;border:none;padding:12px 0;font-size:1.1em;border-radius:8px;">
            Enter
        </button>
    </form>
</div>

<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>