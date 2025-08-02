<?php
session_start();
include("connection.php");



// ดึงข้อมูลผู้ใช้
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE user_id = '$user_id' LIMIT 1";
$result = mysqli_query($con, $query);
$user = mysqli_fetch_assoc($result);

if (!$user) {
    echo "<!DOCTYPE html><html><head><title>Profile</title></head><body>";
    echo "<div style='padding:40px;'><h2 style='color:#3a7bd5;'>User not found.</h2><p>Please check your account or contact support.</p></div>";
    echo "</body></html>";
    exit();
}
?>


<!DOCTYPE html>
<html>
<style>
    .profile-image img {
      border-radius: 50%;
      width: 150px;
      height: 150px;
      object-fit: cover;
    }
    #sidebar {
      z-index: 1 !important; /* Make sure sidebar is under modal */
    }
    @media (max-width: 768px) {
    .profile-box {
        flex-direction: column;
        align-items: center;
        padding: 16px;
        gap: 16px;
    }
}
</style>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profile</title>
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="CSS code/index.css">
</head>
<body>
  <!-- Sidebar -->
  <nav id="sidebar">
        <a href="#" class="brand">
            <i class="bx bxs-smile"></i>
            <span class="text" >Menu</span>
        </a>
        <ul class="sidebar-menu">
            <li><a href="index.php"><i class="bx bxs-user-detail"></i><span class="text">Main</span></a></li>
            <li><a href="group.php"><i class="bx bxs-group"></i><span class="text">My Group</span></a></li>
            <li><a href="#"><i class="bx bx-history"></i><span class="text">History</span></a></li>
            <li><a href="profile.php"><i class="bx bx-profile"></i><span class="text">Profile</span></a></li>
        </ul>
        <ul class="sidebar-menu">
            <li><a href="logout.php"><i class="bx bx-log-out"></i><span class="text">Logout</span></a></li>
        </ul>
    </nav>
  <div class="container">
    <h1>Hello!</h1>
    <p class="subtitle">Hi My name is <?php echo htmlspecialchars($user['user_name']); ?>.</p>

    <div class="profile-box">
      <div class="profile-image">
        <img src="<?= !empty($user['image']) ? htmlspecialchars($user['image']) : 'https://img.freepik.com/free-photo/happy-young-man-holding-laptop-standing-against-beige-background_176420-21783.jpg?w=360' ?>" alt="<?php echo htmlspecialchars($user['user_name']); ?>">
      </div>

      <div class="about">
        <h3>About me</h3>
        <p><?php echo nl2br(htmlspecialchars($user['about'] ?? '')); ?></p>
        <p>My MBTI is <strong><?php echo strtoupper(htmlspecialchars($user['mbti'])); ?></strong></p>
      </div>

      <div class="details">
        <h3>Contact</h3>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
        <p><strong>Phone Number:</strong> <?php echo htmlspecialchars($user['phone']); ?></p>
        <div class="social-icons">
          <?php if (!empty($user['facebook'])): ?>
            <a href="<?php echo htmlspecialchars($user['facebook']); ?>" title="Facebook" target="_blank"><i class='bx bxl-facebook'></i></a>
          <?php endif; ?>
          <?php if (!empty($user['linkedin'])): ?>
            <a href="<?php echo htmlspecialchars($user['linkedin']); ?>" title="LinkedIn" target="_blank"><i class='bx bxl-linkedin'></i></a>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <!-- Edit Button -->
    <a href="edit_profile.php" class="btn btn-primary" style="margin-top:24px;">Edit Profile</a>
  
  </div>

  <!-- Bootstrap JS (for modal) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <footer class="footer">
    <p>© 2025 Find You — Discover careers that match your MBTI type. All rights reserved.</p>
  </footer>
</body>
</html>
