<?php

session_start();
include("connection.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login_f1.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE user_id = '$user_id' LIMIT 1";
$result = mysqli_query($con, $query);
$user = mysqli_fetch_assoc($result);

if (isset($_POST['save_profile'])) {
    $about = mysqli_real_escape_string($con, $_POST['about']);
    $mbti = mysqli_real_escape_string($con, $_POST['mbti']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $phone = mysqli_real_escape_string($con, $_POST['phone']);
    $facebook = mysqli_real_escape_string($con, $_POST['facebook']);
    $linkedin = mysqli_real_escape_string($con, $_POST['linkedin']);

    $image_path = $user['image'] ?? null;
    // Handle file upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        if (in_array($ext, $allowed)) {
            $upload_dir = 'uploads/';
            if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
            $filename = 'profile_' . $user_id . '_' . time() . '.' . $ext;
            $target = $upload_dir . $filename;
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                $image_path = $target;
            }
        }
    }

    $update = "UPDATE users SET 
        about = '$about',
        mbti = '$mbti',
        email = '$email',
        phone = '$phone',
        facebook = '$facebook',
        linkedin = '$linkedin',
        image = " . ($image_path ? "'$image_path'" : "NULL") . "
        WHERE user_id = '$user_id' LIMIT 1";
    mysqli_query($con, $update);
    header("Location: profile.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="CSS code/join_group.css">
</head>
<body>
<div class="container mt-5">
    <h2>Edit Profile</h2>
    <form method="POST" action="" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="about" class="form-label">About Me</label>
            <textarea class="form-control" id="about" name="about" rows="3"><?php echo htmlspecialchars($user['about'] ?? ''); ?></textarea>
        </div>
        <div class="mb-3">
            <label for="mbti" class="form-label" style="text-transform: uppercase;">MBTI</label>
            <select class="form-control" id="mbti" name="mbti" style="text-transform: uppercase;">
                <?php
                $mbti_types = [
                    "INTJ","INTP","ENTJ","ENTP",
                    "INFJ","INFP","ENFJ","ENFP",
                    "ISTJ","ISFJ","ESTJ","ESFJ",
                    "ISTP","ISFP","ESTP","ESFP"
                ];
                foreach ($mbti_types as $type) {
                    $selected = (strtoupper($user['mbti']) == $type) ? 'selected' : '';
                    echo "<option value=\"$type\" $selected>$type</option>";
                }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>">
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Phone Number</label>
            <input type="text" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>">
        </div>
        <div class="mb-3">
            <label for="facebook" class="form-label">Facebook URL</label>
            <input type="url" class="form-control" id="facebook" name="facebook" value="<?php echo htmlspecialchars($user['facebook'] ?? ''); ?>">
        </div>
        <div class="mb-3">
            <label for="linkedin" class="form-label">LinkedIn URL</label>
            <input type="url" class="form-control" id="linkedin" name="linkedin" value="<?php echo htmlspecialchars($user['linkedin'] ?? ''); ?>">
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Profile Image</label><br>
            <?php if (!empty($user['image'])): ?>
                <img src="<?= htmlspecialchars($user['image']) ?>" alt="Profile Image" style="width:100px;height:100px;border-radius:50%;object-fit:cover;margin-bottom:10px;">
            <?php endif; ?>
            <input type="file" class="form-control" id="image" name="image" accept="image/*">
        </div>
        <button type="submit" name="save_profile" class="btn btn-primary">Save</button>
        <a href="profile.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>
</body>
</html>