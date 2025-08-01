<?php
session_start();
include("connection.php");

$group_id = isset($_GET['group_id']) ? intval($_GET['group_id']) : 1;

// Fetch group info
$group = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM groups WHERE id = '$group_id'"));

// Fetch members
$members = [];
if ($group) {
    $res = mysqli_query($con, "
        SELECT u.user_name, u.mbti 
        FROM user_groups ug
        JOIN users u ON ug.user_id = u.id
        WHERE ug.group_id = '$group_id'
    ");
    while ($row = mysqli_fetch_assoc($res)) {
        $members[] = $row;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Group Chat</title>
    <link rel="stylesheet" href="CSS code/chat.css">
    <link rel="stylesheet" href="CSS code/group.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .return-btn {
            position: absolute;
            top: 24px;
            left: 24px;
            background: #3a7bd5;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 8px 18px;
            font-size: 1em;
            cursor: pointer;
            z-index: 100;
            box-shadow: 0 2px 8px #3a7bd540;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .return-btn i {
            font-size: 1.2em;
        }
    </style>
</head>
<body>
<!-- Sidebar from group.php -->
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
<a href="group.php" class="return-btn"><i class="bx bx-arrow-back"></i> Return</a>
<div class="container">
    <?php if ($group): ?>
    <div class="sidebar">
        <h4>Detail Group</h4>
        <div class="detail-label">Group Name:</div>
        <div class="detail-value"><?= htmlspecialchars($group['name']) ?></div>
        <div class="detail-label">Created:</div>
        <div class="detail-value"><?= date('d/m/Y') ?></div>
        <div class="detail-label">Group Pin:</div>
        <div class="detail-value"><?= htmlspecialchars($group['pin']) ?></div>
    </div>
    <div class="chat-area">
        <h4>Chat</h4>
        <div id="chat-box"></div>
        <form id="chat-form">
            <input type="hidden" name="group_id" value="<?= $group_id ?>">
            <input type="text" name="message" placeholder="Type your message..." required>
            <button type="submit" class="send-btn">&#9658;</button>
        </form>
    </div>
    <div class="member-list">
        <h4>Members in this Group</h4>
        <?php if (count($members) > 0): ?>
            <?php foreach ($members as $m): ?>
                <div class="member-item">
                    <div class="member-avatar"><?= strtoupper($m['user_name'][0]) ?></div>
                    <div>
                        <div class="member-name"><?= htmlspecialchars($m['user_name']) ?></div>
                        <div class="member-mbti"><?= htmlspecialchars($m['mbti']) ?></div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="no-member">No members in this group yet.</div>
        <?php endif; ?>
    </div>
    <?php else: ?>
    <div style="padding:40px;">
        <h2 style="color:#3a7bd5;">Group not found.</h2>
        <p>Please check the group ID or create a new group.</p>
    </div>
    <?php endif; ?>
</div>
<script src="JS code/chat.js"></script>
</body>
</html>