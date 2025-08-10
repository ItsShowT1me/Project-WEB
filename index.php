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

  <div class="main">
    <!-- Header -->
    <header class="top-header" style="display: flex; align-items: center; justify-content: space-between; padding: 24px 32px 0 32px;">
      <div class="breadcrumbs" style="display: flex; align-items: center; gap: 16px;">
        <a href="index.php">MAIN</a>
      </div>
      <!-- Dark mode toggle in header, right side -->
      <label style="margin-left: auto; cursor: pointer;">
        <input class="slider" type="checkbox" id="themeToggle" style="display:none;">
        <div class="switch" style="transform: scale(0.85);">
          <div class="suns"></div>
          <div class="moons">
            <div class="star star-1"></div>
            <div class="star star-2"></div>
            <div class="star star-3"></div>
            <div class="star star-4"></div>
            <div class="star star-5"></div>
            <div class="first-moon"></div>
          </div>
          <div class="sand"></div>
          <div class="bb8">
            <div class="antennas">
              <div class="antenna short"></div>
              <div class="antenna long"></div>
            </div>
            <div class="head">
              <div class="stripe one"></div>
              <div class="stripe two"></div>
              <div class="eyes">
                <div class="eye one"></div>
                <div class="eye two"></div>
              </div>
              <div class="stripe detail">
                <div class="detail zero"></div>
                <div class="detail zero"></div>
                <div class="detail one"></div>
                <div class="detail two"></div>
                <div class="detail three"></div>
                <div class="detail four"></div>
                <div class="detail five"></div>
                <div class="detail five"></div>
              </div>
              <div class="stripe three"></div>
            </div>
            <div class="ball">
              <div class="lines one"></div>
              <div class="lines two"></div>
              <div class="ring one"></div>
              <div class="ring two"></div>
              <div class="ring three"></div>
            </div>
            <div class="shadow"></div>
          </div>
        </div>
      </label>
    </header>


  </div>


  <!-- Popup Recomend What u like it?  -->
<div class="popup-overlay" id="popup1">
  <div class="popup1">
    <h2>📢 Website Usage Notice – TypeToWork</h2>
    <p>
      Welcome to <strong>TypeToWork</strong>, a platform that helps you find work groups and job opportunities 
      based on your MBTI personality type.<br><br>
      1. <strong>Data Collection</strong> – We collect general usage data, your MBTI test results (if provided), and information you submit to recommend suitable groups or opportunities.<br>
      2. <strong>Cookies</strong> – We use cookies and similar technologies to store preferences and improve your browsing experience.<br>
      3. <strong>Data Sharing</strong> – Non-identifiable data may be used for analytics and improvements. We do not share personal information without your consent.<br>
      4. <strong>Security</strong> – We implement measures to protect your data from unauthorized access.<br>
      5. <strong>User Rights</strong> – You can request to access, edit, or delete your data as explained in our Privacy Policy.<br>
      6. <strong>Disclaimer</strong> – All recommendations are for informational purposes only.<br>
      7. <strong>Acceptance</strong> – By clicking “Accept and Continue” you agree to our Terms of Service and Privacy Policy.<br><br>
      💡 <strong>Tip:</strong> For the best experience, we recommend you take the MBTI test here: 
      <a href="https://www.16personalities.com" target="_blank">https://www.16personalities.com</a>
    </p>
    <button onclick="acceptUsage()">✅ Accept and Continue</button>
    
  </div>
</div>

<!-- Popup 2 -->
<div class="popup-overlay" id="popup2">
  <div class="popup2">
    <h2>what you interestes?</h2>
    <div class="options">
      <button class="option-btn" onclick="selectOption('music', 1)" > MUSIC</button>
      <button class="option-btn" onclick="selectOption('sport', 2)">SPORT</button>
      <button class="option-btn" onclick="selectOption('movie', 2)">MOVIE</button>
      <button class="option-btn" onclick="selectOption('game', 2)">GAME</button>
      <button class="option-btn" onclick="selectOption('other', 2)">OTHER</button>
    </div>
    <br>
    <!-- <button class="option-btn" onclick="closePopup(2)">X</button> -->
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
  // Dark mode toggle using the switch
  const themeToggle = document.getElementById('themeToggle');
  themeToggle.addEventListener('change', () => {
    document.body.classList.toggle('dark', themeToggle.checked);
  });
</script>












</body>
</html>