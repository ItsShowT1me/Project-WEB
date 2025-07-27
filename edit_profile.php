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

    $update = "UPDATE users SET 
        about = '$about',
        mbti = '$mbti',
        email = '$email',
        phone = '$phone',
        facebook = '$facebook',
        linkedin = '$linkedin'
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
</head>
<body>
<div class="container mt-5">
    <h2>Edit Profile</h2>
    <form method="POST" action="">
        <div class="mb-3">
            <label for="about" class="form-label">About Me</label>
            <textarea class="form-control" id="about" name="about" rows="3"><?php echo htmlspecialchars($user['about'] ?? ''); ?></textarea>
        </div>
        <div class="mb-3">
            <label for="mbti" class="form-label">MBTI</label>
            <input type="text" class="form-control" id="mbti" name="mbti" value="<?php echo htmlspecialchars($user['mbti']); ?>">
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
        <button type="submit" name="save_profile" class="btn btn-primary">Save</button>
        <a href="profile.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>
</body>
</html>