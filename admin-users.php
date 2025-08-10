<?php

session_start();
include 'connection.php';

// Only allow admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != 971221) {
    header("Location: index.php");
    exit();
}

// Pagination setup
$limit = 20;
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * $limit;

// Handle search
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$where = '';
if ($search !== '') {
    $safe_search = mysqli_real_escape_string($con, $search);
    $where = "WHERE user_name LIKE '%$safe_search%' OR mbti LIKE '%$safe_search%'";
}

// Get total users count (with search)
$total_result = mysqli_query($con, "SELECT COUNT(*) as total FROM users $where");
$total_users = mysqli_fetch_assoc($total_result)['total'];
$total_pages = ceil($total_users / $limit);

// Fetch users for current page (with search)
$users = [];
$result = mysqli_query($con, "SELECT * FROM users $where ORDER BY date DESC LIMIT $limit OFFSET $offset");
while ($row = mysqli_fetch_assoc($result)) {
    // Get group count for each user
    $group_count = 0;
    $group_result = mysqli_query($con, "SELECT COUNT(*) as cnt FROM user_groups WHERE user_id = " . intval($row['user_id']));
    if ($group_row = mysqli_fetch_assoc($group_result)) {
        $group_count = $group_row['cnt'];
    }
    $row['group_count'] = $group_count;
    $users[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Users</title>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="CSS code/admin-dashboard.css">
    <style>
        .users-table { width:100%; border-collapse:collapse; margin-top:24px; }
        .users-table th, .users-table td { padding:10px 14px; border-bottom:1px solid #eee; text-align:left; }
        .users-table th { background:#f6f8fa; }
        .user-avatar { width:32px; height:32px; border-radius:50%; object-fit:cover; background:#eee; }
        .mbti-badge { padding:2px 8px; border-radius:12px; background:#667eea; color:#fff; font-size:12px; }
        .pagination { margin:24px 0; text-align:center; }
        .pagination a, .pagination span {
            display:inline-block;
            padding:6px 12px;
            margin:0 2px;
            border-radius:4px;
            background:#f6f8fa;
            color:#333;
            text-decoration:none;
            transition:background 0.2s;
        }
        .pagination a:hover { background:#e0e7ff; }
        .pagination .active {
            background:#667eea;
            color:#fff;
            font-weight:bold;
            border:1px solid #667eea;
        }
        .pagination .disabled {
            color:#aaa;
            background:#f6f8fa;
            cursor:not-allowed;
        }
        .pagination .ellipsis {
            background:transparent;
            color:#aaa;
            cursor:default;
            padding:6px 0;
        }
        .search-bar-container {
            position: absolute;
            top: 32px;
            right: 48px;
            z-index: 10;
        }
        .search-bar-form {
            display: flex;
            align-items: center;
            gap: 0;
        }
        .search-bar-input {
            padding: 8px 14px;
            border-radius: 20px 0 0 20px;
            border: 1px solid #d0d7e2;
            font-size: 1em;
            outline: none;
            background: #f7f9fb;
            min-width: 180px;
        }
        .search-bar-btn {
            padding: 8px 18px;
            border-radius: 0 20px 20px 0;
            border: none;
            background: #667eea;
            color: #fff;
            font-size: 1em;
            cursor: pointer;
            transition: background 0.2s;
        }
        .search-bar-btn:hover {
            background: #3a7bd5;
        }
        @media (max-width: 900px) {
            .search-bar-container { position: static; margin-bottom: 16px; float: none; }
        }
    </style>
</head>
<body>
    <div class="container" style="position:relative;">
        <div class="sidebar">
            <!-- ...copy sidebar from admin-dashboard.php... -->
            <div class="logo">
                <div class="logo-icon">B</div>
                <div class="logo-text">BUMBTI</div>
            </div>
            <div class="admin-badge">
                <i class="bx bx-shield"></i> Admin Panel
            </div>
            <ul class="nav-menu">
                <li class="nav-item">
                    <a href="admin-dashboard.php" class="nav-link">
                        <i class="bx bx-grid-alt nav-icon"></i>
                        Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="admin-users.php" class="nav-link active">
                        <i class="bx bx-user nav-icon"></i>
                        Users
                    </a>
                </li>
                <li class="nav-item">
                    <a href="admin-groups.php" class="nav-link">
                        <i class="bx bxs-group nav-icon"></i>
                        Groups
                    </a>
                </li>
                <li class="nav-item">
                    <a href="admin-messages.php" class="nav-link">
                        <i class="bx bx-message-dots nav-icon"></i>
                        Messages
                    </a>
                </li>
                <li class="nav-item">
                    <a href="admin-analytics.php" class="nav-link">
                        <i class="bx bx-brain nav-icon"></i>
                        MBTI Analytics
                    </a>
                </li>
                <li class="nav-item">
                    <a href="admin-reports.php" class="nav-link">
                        <i class="bx bx-bar-chart-alt-2 nav-icon"></i>
                        Reports
                    </a>
                </li>
                <li class="nav-item">
                    <a href="admin-settings.php" class="nav-link">
                        <i class="bx bx-cog nav-icon"></i>
                        Settings
                    </a>
                </li>
                <li class="nav-item">
                    <a href="logout.php" class="nav-link">
                        <i class="bx bx-log-out nav-icon"></i>
                        Logout
                    </a>
                </li>
            </ul>
        </div>
        <div class="main-content">
            <div class="header" style="position:relative;">
                <h1>Users Management</h1>
                <div class="search-bar-container">
                    <form class="search-bar-form" method="get" action="admin-users.php">
                        <input type="text" name="search" class="search-bar-input" placeholder="Search name or MBTI..." value="<?= htmlspecialchars($search) ?>">
                        <button type="submit" class="search-bar-btn"><i class="bx bx-search"></i></button>
                    </form>
                </div>
            </div>
            <div class="content-wrapper">
                <table class="users-table">
                    <thead>
                        <tr>
                            <th>Avatar</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>MBTI</th>
                            <th>Groups</th>
                            <th>Joined</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                        <tr>
                            <td>
                                <?php if ($user['image']): ?>
                                    <img src="<?= htmlspecialchars($user['image']) ?>" class="user-avatar" alt="Avatar">
                                <?php else: ?>
                                    <span class="user-avatar"></span>
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($user['user_name']) ?></td>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                            <td>
                                <?php if ($user['mbti']): ?>
                                    <span class="mbti-badge"><?= htmlspecialchars($user['mbti']) ?></span>
                                <?php endif; ?>
                            </td>
                            <td><?= $user['group_count'] ?></td>
                            <td><?= date('M d, Y', strtotime($user['date'])) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="pagination">
                    <?php
                    // Previous button
                    if ($page > 1) {
                        echo '<a href="?page=' . ($page - 1) . '">&laquo; Prev</a>';
                    } else {
                        echo '<span class="disabled">&laquo; Prev</span>';
                    }

                    // Page numbers with ellipsis for large page counts
                    $max_display = 5;
                    if ($total_pages <= $max_display + 2) {
                        // Show all pages
                        for ($p = 1; $p <= $total_pages; $p++) {
                            if ($p == $page) {
                                echo '<span class="active">' . $p . '</span>';
                            } else {
                                echo '<a href="?page=' . $p . '">' . $p . '</a>';
                            }
                        }
                    } else {
                        // Show first, last, current, and neighbors
                        if ($page > 2) {
                            echo '<a href="?page=1">1</a>';
                            if ($page > 3) echo '<span class="ellipsis">...</span>';
                        }
                        $start = max(2, $page - 1);
                        $end = min($total_pages - 1, $page + 1);
                        for ($p = $start; $p <= $end; $p++) {
                            if ($p == $page) {
                                echo '<span class="active">' . $p . '</span>';
                            } else {
                                echo '<a href="?page=' . $p . '">' . $p . '</a>';
                            }
                        }
                        if ($page < $total_pages - 1) {
                            if ($page < $total_pages - 2) echo '<span class="ellipsis">...</span>';
                            echo '<a href="?page=' . $total_pages . '">' . $total_pages . '</a>';
                        }
                    }

                    // Next button
                    if ($page < $total_pages) {
                        echo '<a href="?page=' . ($page + 1) . '">Next &raquo;</a>';
                    } else {
                        echo '<span class="disabled">Next &raquo;</span>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>