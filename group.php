<?php
session_start();

include 'function.php';
include 'connection.php';

$user_data = check_login($con);
$user_id = $_SESSION['user_id'];

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
        body { background: #222; color: #fff; }
        .group-grid { display: flex; flex-wrap: wrap; gap: 24px; margin: 32px; }
        .group-card {
            background: #222;
            border-radius: 12px;
            box-shadow: 0 2px 8px #0004;
            width: 260px;
            min-height: 120px;
            padding: 24px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            color: #fff;
            position: relative;
        }
        .group-card .group-color {
            width: 40px; height: 40px; border-radius: 8px; margin-bottom: 12px;
            display: flex; align-items: center; justify-content: center; font-size: 1.5em;
        }
        .group-card .group-title { font-size: 1.1em; font-weight: bold; margin-bottom: 8px; }
        .group-card .group-actions { position: absolute; right: 16px; bottom: 16px; display: flex; gap: 12px; }
        .top-bar { display: flex; justify-content: space-between; align-items: center; margin: 32px; }
        .top-bar h2 { margin: 0; }
        .btn { margin-left: 8px; }
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
            <li><a href="index.php"><i class="bx bxs-user-detail"></i><span class="text">Main</span></a></li>
            <li><a href="group.php"><i class="bx bxs-group"></i><span class="text">My Group</span></a></li>
            <li><a href="#"><i class="bx bx-history"></i><span class="text">History</span></a></li>
            <li><a href="profile.php"><i class="bx bx-profile"></i><span class="text">Profile</span></a></li>
        </ul>
        <ul class="sidebar-menu">
            <li><a href="logout.php"><i class="bx bx-log-out"></i><span class="text">Logout</span></a></li>
        </ul>
    </nav>

    <div class="container-main">
        <div class="header-bar">
    <div class="header-title">
        <h2>Groups</h2>
    </div>
    <div class="header-actions">
        <a href="join_group.php" class="btn btn-primary">Join Group</a>
        <a href="create_group.php" class="btn btn-info">Create Group</a>
    </div>
</div>
<div class="group-grid">
            <?php foreach ($groups as $group): ?>
                <div class="group-card">
                    <div class="group-color" style="background:<?= htmlspecialchars($group['color'] ?? '#3498db') ?>">
                        <?= strtoupper(substr($group['name'], 0, 2)) ?>
                    </div>
                    <div class="group-title"><?= htmlspecialchars($group['name']) ?></div>
                    <div class="group-actions">
                        <a href="view_group.php?id=<?= $group['id'] ?>" title="View"><i class='bx bx-show'></i></a>
                        <a href="#" title="Lock"><i class='bx bx-lock'></i></a>
                        <a href="edit_group.php?id=<?= $group['id'] ?>" title="Edit"><i class='bx bx-edit'></i></a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <footer class="footer">
        <p>© 2025 Find You — Discover careers that match your MBTI type. All rights reserved.</p>
    </footer>
</body>
</html>