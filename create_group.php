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
        // Get the inserted group's id using mysqli_insert_id for reliability
        $inserted_id = mysqli_insert_id($con);
        $user_id = $_SESSION['user_id'];
        // Add creator to user_groups
        if (mysqli_query($con, "INSERT INTO user_groups (user_id, group_id) VALUES ('$user_id', '$inserted_id')")) {
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
<div class="modal-overlay">
    <div class="create-group-modal">
        <div class="modal-header">
            <button class="close-btn" onclick="window.history.back();" aria-label="Close" style="background:none;border:none;font-size:1.5em;color:#fff;opacity:0.8;cursor:pointer;">&times;</button>
            <div class="modal-title">
                <span class="group-icon">👥</span>
                <span>Create Group</span>
            </div>
        </div>
        <form method="POST">
            <div class="input-group">
                <label for="name">Project Name</label>
                <input type="text" name="name" id="name" placeholder="Enter project name..." required>
            </div>
            <div class="input-group">
                <label for="color">Group Color</label>
                <!-- Move input and preview below the label -->
                <div class="color-container" style="display: flex; gap: 12px; margin-top: 8px; ">
                    <input type="color" name="color" id="color" class="form-control form-control-color" value="#3a7bd5" title="Choose your color"  >
                    <span id="colorPreview" style="display:inline-block;width:32px;height:32px;border-radius:8px;border:2px solid #e3e8f0;background:#3a7bd5;"></span>
                </div>
            </div>
            <button type="submit" class="create-btn">Create Group</button>
        </form>
    </div>
</div>

<script>
document.getElementById('color').addEventListener('input', function() {
    document.getElementById('colorPreview').style.background = this.value;
});
</script>

</body>
</html>