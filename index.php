<?php
session_start();

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

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="CSS code/index.css">
    
</head>
<body>
  <div class="container">
      <!-- Header -->
      <header class="top-header">
        <div class="breadcrumbs">
          <a href="index.html">Home</a> / <a href="#">About</a>
        </div>
        
        <button class="new-btn" onclick="openModal()">+ New</button>
        
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
    <div class="search-container">
        <input type="text" placeholder="ค้นหา..." class="search-input" />
        <!-- <button type="submit" class="search-button">🔍</button>
    </div> -->

  <!-- Content (Card List) -->
  <main id="content">
    <div class="card-container" id="item-list"></div>
    <!-- <img id="image"> -->
  </main>
        
<!-- Footer -->
  <footer class="footer">
    <p>© 2025 Find You — Discover careers that match your MBTI type. All rights reserved.</p>
  </footer>



  <!-- Modal Form -->
  <div class="modal" id="formModal">
    <div class="modal-content">
      <span class="close" onclick="closeModal()">&times;</span>
      <h2>Personal Information</h2>
      <form id="personalForm" onsubmit="submitForm(event)">

        <input type="text" id="fullName" placeholder="Full Name" required />
        <input type="date" id="dob" required />
        <input type="text" id="address" placeholder="Address" required />
        <input type="text" id="phone" placeholder="Phone Number" required />
        <input type="email" id="email" placeholder="Email" required />
       
        <label for="mbti">MBTI</label>
            <select id="mbti" name="mbti" required>
            <option value="">-- select your MBTI --</option>
            <option value="INTJ">INTJ</option>
            <option value="INTP">INTP</option>
            <option value="ENTJ">ENTJ</option>
            <option value="ENTP">ENTP</option>
            <option value="INFJ">INFJ</option>
            <option value="INFP">INFP</option>
            <option value="ENFJ">ENFJ</option>
            <option value="ENFP">ENFP</option>
            <option value="ISTJ">ISTJ</option>
            <option value="ISFJ">ISFJ</option>
            <option value="ESTJ">ESTJ</option>
            <option value="ESFJ">ESFJ</option>
            <option value="ISTP">ISTP</option>
            <option value="ISFP">ISFP</option>
            <option value="ESTP">ESTP</option>
            <option value="ESFP">ESFP</option>
            </select>
        
        <label for="image">Upload Your Portfolio</label>
        <input type="file" id="image" name="image" accept="image/*" required /><br /><br />
        <img id="preview" src="" alt="Image Preview" style="max-width: 200px; display: none;" />

        <button type="submit" class="save-btn">Save</button>
      </form>
    </div>
  </div>

  <!-- Toast -->
  <div id="toast" class="toast">Saved successfully!</div>

  <script src="index.js"></script>
  <script src="test2.js"></script>
  <script src="js/bootstrap.min.js"></script>
</body>
</html>