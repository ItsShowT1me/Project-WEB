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
<script src="JS code/index.js?v=<?= $ver ?>"></script>
<script src="js/bootstrap.min.js?v=<?= $ver ?>"></script>
    
</head>
<body>
  <div class="container">
      <!-- Header -->
      <header class="top-header">
  <div class="breadcrumbs" style="display: flex; align-items: center; gap: 16px;">
    <a href="index.php">Home</a>
  </div>
  <div class="search-bar" style="display: flex; align-items: center; gap: 8px;">
    <form id="searchForm" style="display: flex; align-items: center; gap: 8px;">
      <input type="text" id="searchInput" class="form-control" placeholder="Search..." style="height:32px; font-size:1em;">
      <select id="searchType" class="form-select" style="height:32px; font-size:1em;">
        <option value="name">Name</option>
        <option value="mbti">MBTI</option>
      </select>
    </form>
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
            <li><a href="index.php"><i class="bx bx-home"></i><span class="text">Main</span></a></li>
            <li><a href="group.php"><i class="bx bxs-group"></i><span class="text">Group</span></a></li>
            <li><a href="about.php"><i class="bx bxs-group"></i><span class="text">About</span></a></li>
            <li><a href="contact-us.php"><i class="bx bxs-envelope"></i><span class="text">Contact us</span></a></li>
            <li><a href="profile.php"><i class="bx bx-user"></i><span class="text">Profile</span></a></li>
        </ul>
        <ul class="sidebar-menu">
            <li><a href="logout.php"><i class="bx bx-log-out"></i><span class="text">Logout</span></a></li>
        </ul>
    </nav>
  

  
  

  <?php
// Fetch all users except the current user
$current_user_id = $user_data['user_id'];
$users = [];
$result = mysqli_query($con, "SELECT user_name, mbti, image, email, phone FROM users WHERE user_id != '$current_user_id'");
while ($row = mysqli_fetch_assoc($result)) {
    $users[] = $row;
}
?>



<!-- User Grid -->
<div class="user-grid">
    <?php foreach ($users as $user): ?>
        <div class="user-card"
             data-name="<?= strtolower(htmlspecialchars($user['user_name'])) ?>"
             data-mbti="<?= strtolower(htmlspecialchars($user['mbti'])) ?>"
             data-email="<?= htmlspecialchars($user['email']) ?>"
             data-phone="<?= htmlspecialchars($user['phone'] ?? '') ?>"
             data-image="<?= !empty($user['image']) ? htmlspecialchars($user['image']) : 'images/default-user.png' ?>"
             style="cursor:pointer;">
            <div class="user-image">
                <img src="<?= !empty($user['image']) ? htmlspecialchars($user['image']) : 'images/default-user.png' ?>" alt="Profile" />
            </div>
            <div class="user-info">
                <div class="user-name"><?= htmlspecialchars($user['user_name']) ?></div>
                <div class="user-mbti">(<?= htmlspecialchars($user['mbti']) ?>)</div>
                <div class="user-email"><?= htmlspecialchars($user['email']) ?></div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<!-- User Detail Modal -->
<div id="userModal" class="modal">
  <div class="modal-content profile-modal-content">
    <span class="close" id="closeModal">&times;</span>
    <div class="profile-modal-image">
      <img src="" alt="Profile">
    </div>
    <div class="profile-modal-info">
      <div class="profile-modal-name" id="modalName"></div>
      <div class="profile-modal-label"><b>Phone:</b> <span id="modalPhone"></span></div>
      <div class="profile-modal-label"><b>Email:</b> <span id="modalEmail"></span></div>
      <div class="profile-modal-label"><b>MBTI:</b> <span id="modalMbti"></span></div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const searchType = document.getElementById('searchType');
    const userCards = document.querySelectorAll('.user-card');

    function filterUsers() {
        const query = searchInput.value.trim().toLowerCase();
        const type = searchType.value; // "name" or "mbti"

        userCards.forEach(card => {
            const value = card.dataset[type] || '';
            if (value.includes(query)) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });
    }

    searchInput.addEventListener('input', filterUsers);
    searchType.addEventListener('change', filterUsers);
});
</script>
  
</body>
</html>