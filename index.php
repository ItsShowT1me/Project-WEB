<?php
session_start(); // <-- Always first!
include 'function.php';
include 'connection.php';

$user_data = check_login($con);


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BUMBTI</title>

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <?php $ver = time() - (time() % 60); // changes every minute ?>
<link rel="stylesheet" href="css/bootstrap.min.css?v=<?= $ver ?>">
<link rel="stylesheet" href="CSS code/index.css?v=<?= $ver ?>">
<script src="index.js?v=<?= $ver ?>"></script>
<script src="test2.js?v=<?= $ver ?>"></script>
<script src="js/bootstrap.min.js?v=<?= $ver ?>"></script>
    
</head>
<body>
  <div class="container">
      <!-- Header -->
      <header class="top-header">
        <div class="breadcrumbs">
          <a href="index.php">Home</a> / <a href="#">About</a>
        </div>
        
        
        
      </header>
  </div>

  <!-- Sidebar -->
  <nav id="sidebar">
        <a href="#" class="brand">
            <i class="bx bxs-smile"></i>
            <span class="text">Menu</span>
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
  

  <!-- <div class="main">

    <div class="search-container">
      <input type="text" id="searchBox" class="search-input" placeholder="search MBTI...">
      <div id="results" class="search-results"></div>
    </div> -->

 <!-- Search box in main -->
    

  



  

  <!-- Toast -->
  

  <?php
// Fetch all users except the current user
$current_user_id = $user_data['user_id'];
$users = [];
$result = mysqli_query($con, "SELECT user_name, mbti, image, email FROM users WHERE user_id != '$current_user_id'");
while ($row = mysqli_fetch_assoc($result)) {
    $users[] = $row;
}
?>



<!-- User Grid -->
<div class="user-grid">
  
    <?php foreach ($users as $user): ?>
      
        <div class="user-card">
          
            <div class="user-image">
                <img src="<?= !empty($user['image']) ? htmlspecialchars($user['image']) : 'default-user.png' ?>" alt="Profile" />
            </div>
            <div class="user-info">
                <div class="user-name"><?= htmlspecialchars($user['user_name']) ?></div>
                <div class="user-mbti">(<?= htmlspecialchars($user['mbti']) ?>)</div>
                <div class="user-email"><?= htmlspecialchars($user['email']) ?></div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

  
</body>
</html>