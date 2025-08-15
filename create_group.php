<?php

session_start();
include("connection.php");

function generatePin($length = 4) {
    return str_pad(rand(0, pow(10, $length)-1), $length, '0', STR_PAD_LEFT);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $color = mysqli_real_escape_string($con, $_POST['color']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $category = mysqli_real_escape_string($con, $_POST['category']);
    $is_private = isset($_POST['is_private']) ? intval($_POST['is_private']) : 0;
    $pin = '';
    if ($is_private) {
        $pin = mysqli_real_escape_string($con, $_POST['pin']);
        if (!$pin) $pin = generatePin(rand(4,5));
    } else {
        $pin = generatePin(rand(4,5)); // Still generate for consistency
    }
    $group_id = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);

    // Handle file upload
    $image_path = '';
    if (isset($_FILES['group_image']) && $_FILES['group_image']['error'] == UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['group_image']['name'], PATHINFO_EXTENSION);
        $image_path = 'uploads/group_' . time() . '_' . rand(1000,9999) . '.' . $ext;
        move_uploaded_file($_FILES['group_image']['tmp_name'], $image_path);
        mysqli_query($con, "UPDATE groups SET image='$image_path' WHERE id='$group_id'");
    }

    // Handle allowed MBTI types
    $allowed_mbti = '';
    if (isset($_POST['allowed_mbti']) && is_array($_POST['allowed_mbti'])) {
        $allowed_mbti = implode(',', array_map('mysqli_real_escape_string', array_fill(0, count($_POST['allowed_mbti']), $con), $_POST['allowed_mbti']));
    }

    $sql = "INSERT INTO groups (group_id, name, pin, color, image, description, category, is_private, allowed_mbti) VALUES ('$group_id', '$name', '$pin', '$color', '$image_path', '$description', '$category', '$is_private', '$allowed_mbti')";
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
        <form method="POST" enctype="multipart/form-data">
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
            <div class="input-group">
                <label for="description">Project Detail</label>
                <textarea name="description" id="description" rows="3" placeholder="Enter details..." required style="width:100%;padding:12px 16px;border:2px solid #e3e8f0;border-radius:12px;font-size:1rem;"></textarea>
            </div>
            <div class="input-group">
                <label for="category">Category</label>
                <select name="category" id="category" required style="width:100%;padding:12px 16px;border:2px solid #e3e8f0;border-radius:12px;font-size:1rem;">
                    <option value="game">Game</option>
                    <option value="music">Music</option>
                    <option value="movie">Movie</option>
                    <option value="sport">Sport</option>
                    <option value="tourism">Tourism</option>
                    <option value="other">Other</option>
                </select>
            </div>
            <div class="input-group">
                <label for="is_private">Group Type</label>
                <select name="is_private" id="is_private" required style="width:100%;padding:12px 16px;border:2px solid #e3e8f0;border-radius:12px;font-size:1rem;">
                    <option value="0">Public</option>
                    <option value="1">Private (Require PIN)</option>
                </select>
            </div>
            <div class="input-group" id="pin-group" style="display:none;">
                <label for="pin">Group PIN (4-5 digits)</label>
                <input type="text" name="pin" id="pin" pattern="\d{4,5}" maxlength="5" minlength="4" placeholder="Enter PIN or leave blank for auto" style="width:100%;padding:12px 16px;border:2px solid #e3e8f0;border-radius:12px;font-size:1rem;">
            </div>
            <div class="input-group">
                <label for="group_image">Group Image</label>
                <?php if (!empty($group['image'])): ?>
                    <img src="<?= htmlspecialchars($group['image']) ?>" alt="Group Image" style="max-width:120px;max-height:120px;border-radius:12px;border:2px solid #e3e8f0;margin-bottom:8px;">
                <?php endif; ?>
                <input type="file" name="group_image" id="group_image" accept="image/png, image/jpeg, image/jpg, image/gif, image/webp">
                <small style="color:#666;">
                    Allowed types: PNG, JPG, JPEG, GIF, WEBP. Max size: 2MB
                </small>
                <div id="imagePreview" style="margin-top:10px;"></div>
                <div id="imageError" style="color:#DB504A;margin-top:6px;"></div>
            </div>
            <div class="input-group">
                <label for="allowed_mbti">Allowed MBTI Types (leave blank for all)</label>
                <<div style="display:flex;flex-wrap:wrap;gap:10px;">
                <?php
                $mbti_types = ['INTJ','INTP','ENTJ','ENTP','INFJ','INFP','ENFJ','ENFP','ISTJ','ISFJ','ESTJ','ESFJ','ISTP','ISFP','ESTP','ESFP'];
                $selected_mbti = isset($group['allowed_mbti']) ? explode(',', $group['allowed_mbti']) : [];
                foreach ($mbti_types as $type):
                ?>
                    <label class="mbti-checkbox-label">
                        <input type="checkbox" name="allowed_mbti[]" value="<?= $type ?>" <?= in_array($type, $selected_mbti) ? 'checked' : '' ?>>
                        <?= $type ?>
                    </label>
                <?php endforeach; ?>
            </div>
            <small style="color:#666;">Check MBTI types allowed to join. Leave all unchecked for no restriction.</small>
            </div>
            <button type="submit" class="create-btn">Create Group</button>
        </form>
    </div>
</div>

<script>
document.getElementById('color').addEventListener('input', function() {
    document.getElementById('colorPreview').style.background = this.value;
});
document.getElementById('is_private').addEventListener('change', function() {
    document.getElementById('pin-group').style.display = this.value == "1" ? "" : "none";
});
document.getElementById('group_image').addEventListener('change', function(e) {
    const preview = document.getElementById('imagePreview');
    const error = document.getElementById('imageError');
    preview.innerHTML = '';
    error.innerHTML = '';
    const file = e.target.files[0];
    if (file) {
        if (file.size > 2 * 1024 * 1024) { // 2MB
            error.innerHTML = 'File size exceeds 2MB limit.';
            e.target.value = '';
            return;
        }
        if (file.type.match('image.*')) {
            const reader = new FileReader();
            reader.onload = function(evt) {
                preview.innerHTML = '<img src="' + evt.target.result + '" style="max-width:120px;max-height:120px;border-radius:12px;border:2px solid #e3e8f0;" />';
            };
            reader.readAsDataURL(file);
        }
    }
});
</script>

</body>
</html>