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
    <title>TypeToWork</title>

    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

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
        <div class="breadcrumbs" style="display: flex; align-items: center; gap: 16px; ">
          <a href="index.php">MAIN</a>
        </div>
          <!-- <div class="search-bar" style="display: flex; align-items: center; gap: 8px;">
            <form id="searchForm" style="display: flex; align-items: center; gap: 8px;">
              <input type="text" id="searchInput" class="form-control" placeholder="Search..." style="height:32px; font-size:1em;">
              <select id="searchType" class="form-select" style="height:32px; font-size:1em;">
                <option value="name">Name</option>
                <option value="mbti">MBTI</option>
              </select>
            </form>
          </div> -->
      </header>
  </div>

  <div class="container">
    <div class="content">
      <h1>Welcome to TypeToWork</h1>
      <p>Discover your ideal work group based on your MBTI personality type.</p>
    </div>
  </div>


  <!-- Sidebar -->
  <nav id="sidebar">
        <a href="index.php">
            <div class="sidebar-brand">
                <img src="images/Logo-nobg.png" alt="Logo" class="logo">
            </div>
        </a>
        <ul class="sidebar-menu">
            <li><a href="index.php"><i class="bx bx-home"></i><span class="text">Main</span></a></li>
            <li><a href="group.php"><i class="bx bxs-group"></i><span class="text">My Group</span></a></li>
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



<!-- Popup Recomend What u like it?  -->
<div class="popup-overlay" id="popup1">
  <div class="popup1">
    <h2>แจ้งเตือนการใช้งานเว็บไซต์</h2>
    <p>
      เว็บไซต์นี้ใช้คุกกี้และเทคโนโลยีต่าง ๆ เพื่อพัฒนาประสบการณ์ของคุณ<br>
      กรุณาอ่านและยอมรับข้อกำหนดการใช้งานก่อนใช้งานเว็บไซต์
    </p>
    <button class="btn-confirm" onclick="acceptUsage()">ยอมรับและดำเนินการต่อ</button>
  </div>
</div>

<!-- Popup 2 -->
<div class="popup-overlay" id="popup2">
  <div class="popup2">
    <h2>คุณชอบอะไร?</h2>
    <div class="options">
      <button class="option-btn" onclick="selectOption('music', 1)" > MUSIC</button>
      <button class="option-btn" onclick="selectOption('sport', 2)">SPORT</button>
      <button class="option-btn" onclick="selectOption('movie', 2)">MOVIE</button>
      <button class="option-btn" onclick="selectOption('game', 2)">GAME</button>
      <button class="option-btn" onclick="selectOption('other', 2)">OTHER</button>
    </div>
    <br>
    <button class="option-btn" onclick="closePopup(2)">X</button>
  </div>
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

function openPopup(num) {
  document.getElementById('popup' + num).style.display = 'flex';
}

function closePopup(num) {
  document.getElementById('popup' + num).style.display = 'none';
  if (num === 1) {
    openPopup(2);
  }
}

function acceptUsage() {
  closePopup(1); // ปิด popup1
  openPopup(2);  // เปิด popup2
}

function selectOption(choice, popupNum) {
  alert('คุณเลือก: ' + choice);
  closePopup(popupNum);
}

window.onload = function() {
  openPopup(1);
};

document.querySelectorAll('.popup-overlay').forEach(popup => {
  popup.addEventListener('click', e => {
    if (e.target === popup) {
      popup.style.display = 'none';
      if (popup.id === 'popup1') {
        openPopup(2);
      }
    }
  });
});

</script>
  
</body>
</html>