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
    $portfolio = mysqli_real_escape_string($con, $_POST['portfolio']);
    $portfolio_file_path = $user['portfolio_file'] ?? null;

    if (isset($_FILES['portfolio_file']) && $_FILES['portfolio_file']['error'] === UPLOAD_ERR_OK) {
        $ext = strtolower(pathinfo($_FILES['portfolio_file']['name'], PATHINFO_EXTENSION));
        $allowed = ['pdf', 'doc', 'docx', 'ppt', 'pptx', 'zip', 'rar'];
        if (in_array($ext, $allowed)) {
            $upload_dir = 'uploads/';
            if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
            $filename = 'portfolio_' . $user_id . '_' . time() . '.' . $ext;
            $target = $upload_dir . $filename;
            if (move_uploaded_file($_FILES['portfolio_file']['tmp_name'], $target)) {
                $portfolio_file_path = $target;
            }
        }
    }

    $update = "UPDATE users SET 
        about = '$about',
        mbti = '$mbti',
        email = '$email',
        phone = '$phone',
        portfolio = '$portfolio',
        portfolio_file = " . ($portfolio_file_path ? "'$portfolio_file_path'" : "NULL") . ",
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
            <label for="portfolio" class="form-label">Portfolio</label>
            <div class="d-flex gap-2">
                <input type="url" class="form-control" id="portfolio" name="portfolio" placeholder="Portfolio Link (optional)" value="<?php echo htmlspecialchars($user['portfolio'] ?? ''); ?>">
                <input type="file" class="form-control" id="portfolio_file" name="portfolio_file" accept=".pdf,.doc,.docx,.ppt,.pptx,.zip,.rar">
            </div>
            <?php if (!empty($user['portfolio'])): ?>
                <div class="mt-2">
                    <a href="<?= htmlspecialchars($user['portfolio']) ?>" target="_blank">Current Portfolio Link</a>
                </div>
            <?php endif; ?>
            <?php if (!empty($user['portfolio_file'])): ?>
                <div class="mt-2">
                    <a href="<?= htmlspecialchars($user['portfolio_file']) ?>" target="_blank">Current Portfolio File</a>
                </div>
            <?php endif; ?>
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