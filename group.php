<?php
session_start(); // <-- Always first!
include 'function.php';
include 'connection.php';

$user_data = check_login($con);
$user_id = $_SESSION['user_id'];

// Check if the user is banned
if (!empty($user_data['banned_until']) && strtotime($user_data['banned_until']) > time()) {
    $ban_time = date('d M Y H:i', strtotime($user_data['banned_until']));
    echo "<div style='background:#ffeaea;color:#DB504A;padding:24px 32px;border-radius:16px;margin:64px auto 0 auto;max-width:440px;text-align:center;font-size:1.18em;font-weight:600;box-shadow:0 4px 18px #DB504A22;'>
        <i class='bx bxs-error' style='font-size:2.4em;vertical-align:middle;'></i>
        <div style='margin:18px 0 8px 0;'>You are banned until <span style='color:#b92d23;'>$ban_time</span>.</div>
        <div style='font-size:0.98em;font-weight:400;margin-bottom:18px;'>Please contact support if you believe this is a mistake.</div>
        <button onclick=\"window.location.href='login_f1.php'\" style='background:linear-gradient(135deg,#DB504A 0%,#b92d23 100%);color:#fff;border:none;border-radius:10px;padding:12px 38px;font-size:1.08em;font-weight:600;cursor:pointer;box-shadow:0 2px 8px #DB504A22;transition:background 0.2s;'>
            OK
        </button>
    </div>";
    exit();
}

// Fetch only groups the user has joined
$groups = [];
$result = mysqli_query($con, "
    SELECT g.* FROM groups g
    JOIN user_groups ug ON g.id = ug.group_id
    WHERE ug.user_id = '$user_id'
");
while ($row = mysqli_fetch_assoc($result)) {
    $groups[] = $row;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BUMBTI</title>

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="CSS code/group.css">
    <style>
    /* New group card styles */
    .group-card {
        background: linear-gradient(180deg, #6A11CB 0%, #3a7bd5 60%, #bfc1c2 100%);/* Dark background for cards */
        border-radius: 12px; /* Rounded corners */
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2); /* Subtle shadow */
        width: 200px; /* Fixed width for cards */
        height: 150px; /* Fixed height for cards */
        padding: 16px; /* Padding inside the card */
        display: flex;
        flex-direction: column;
        justify-content: space-between; /* Space between elements */
        color: #fff; /* White text color */
        position: relative;
        transition: transform 0.2s, box-shadow 0.2s; /* Smooth hover effect */
    }
    .group-card:hover {
        transform: scale(1.05); /* Slight zoom on hover */
        box-shadow: 0 8px 24px rgba(255, 255, 255, 0.3); /* Enhanced shadow on hover */
    }
    .group-card-row {
        display: flex;
        align-items: center;
        gap: 12px; /* Space between elements */
    }
    .group-color {
        width: 50px;
        height: 50px;
        border-radius: 50%; /* Circular shape */
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        font-weight: bold;
        color: #fff;
        background: #3a7bd5; /* Default color */
    }
    .group-title {
        font-size: 1.2rem;
        font-weight: 600;
        color: #fff;
    }
    .group-actions {
        display: flex;
        gap: 16px;
        font-size: 1.2rem;
        color: #fff;
        opacity: 0.8;
    }
    .group-actions i:hover {
        color: #ffce26; /* Highlight color on hover */
        cursor: pointer;
        opacity: 1;
    }
    .group-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr); /* 3 cards per row */
        gap: 24px;
        margin: 100px 0 32px 0; /* 100px top, 0 left for sidebar alignment */
        justify-items: center;
        max-width: 1400px;
    }
    </style>
    
</head>
<body>
  

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

    
<div class="header-bar">
    <h2>Groups</h2>
    <div class="header-title">
        
    </div>
    <div class="header-actions">
        <a href="join_group.php" class="btn btn-primary">Join Group</a>
        <a href="create_group.php" class="btn btn-info">Create Group</a>
    </div>
</div>

<div class="group-grid">
    <?php foreach ($groups as $group): ?>
        <a href="chat.php?group_id=<?= $group['id'] ?>" class="group-card-link" style="text-decoration:none;">
            <div class="group-card">
                <div class="group-card-row">
                    <div class="group-color" style="background:<?= htmlspecialchars($group['color'] ?? '#3a7bd5') ?>;">
                        <?= strtoupper(substr($group['name'], 0, 2)) ?>
                    </div>
                    <div class="group-info">
                        <div class="group-title"><?= htmlspecialchars($group['name']) ?></div>
                    </div>
                </div>
                
            </div>
        </a>
    <?php endforeach; ?>
</div>
    </div>

    
</body>
</html>