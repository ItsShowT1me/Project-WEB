<?php

session_start();
include("connection.php");

// --- DEFINE MBTI TYPES FIRST ---
$all_mbti_types = [
    "INTJ","INTP","ENTJ","ENTP",
    "INFJ","INFP","ENFJ","ENFP",
    "ISTJ","ISFJ","ESTJ","ESFJ",
    "ISTP","ISFP","ESTP","ESFP"
];

// Only allow admin (user_id = 971221)
if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != 971221) {
    header("Location: index.php");
    exit();
}

// MBTI distribution
$mbti_counts = [];
$res = mysqli_query($con, "SELECT mbti, COUNT(*) as cnt FROM users WHERE mbti IS NOT NULL AND mbti != '' GROUP BY mbti ORDER BY cnt DESC");
while ($row = mysqli_fetch_assoc($res)) {
    $mbti_counts[$row['mbti']] = $row['cnt'];
}

// Group analytics (latest 10 groups)
$group_analytics = [];
$res2 = mysqli_query($con, "
    SELECT g.name, ga.*
    FROM group_analytics ga
    LEFT JOIN groups g ON ga.group_id = g.id
    ORDER BY ga.date DESC
    LIMIT 10
");
while ($row = mysqli_fetch_assoc($res2)) {
    $group_analytics[] = $row;
}

// --- Group MBTI Compatibility Analytics ---
$group_mbti_compat = [];
$res_groups = mysqli_query($con, "SELECT id, name FROM groups");
while ($group = mysqli_fetch_assoc($res_groups)) {
    $group_id = $group['id'];
    $group_name = $group['name'];

    // Get MBTI types of members in this group
    $mbti_arr = [];
    $res_mbti = mysqli_query($con, "
        SELECT DISTINCT u.mbti FROM user_groups ug
        JOIN users u ON ug.user_id = u.user_id
        WHERE ug.group_id = '$group_id' AND u.mbti IS NOT NULL AND u.mbti != ''
    ");
    while ($row = mysqli_fetch_assoc($res_mbti)) {
        $mbti_arr[] = $row['mbti'];
    }

    // Generate all unique MBTI pairs present in this group
    $pairs = [];
    for ($i = 0; $i < count($mbti_arr); $i++) {
        for ($j = $i+1; $j < count($mbti_arr); $j++) {
            $type1 = $mbti_arr[$i];
            $type2 = $mbti_arr[$j];
            $pair = [$type1, $type2];
            sort($pair);
            $pair_key = $pair[0] . '-' . $pair[1];

            // Get theoretical compatibility from mbti_compatibility table
            $comp_res = mysqli_query($con, "SELECT compatibility_score, relationship_type FROM mbti_compatibility WHERE (type1='{$pair[0]}' AND type2='{$pair[1]}') OR (type1='{$pair[1]}' AND type2='{$pair[0]}') LIMIT 1");
            $comp = mysqli_fetch_assoc($comp_res);

            // Calculate real score: count messages sent by both types in this group
            $user_ids = [];
            $res_users = mysqli_query($con, "
                SELECT ug.user_id FROM user_groups ug
                JOIN users u ON ug.user_id = u.user_id
                WHERE ug.group_id = '$group_id' AND (u.mbti = '{$pair[0]}' OR u.mbti = '{$pair[1]}')
            ");
            while ($row_user = mysqli_fetch_assoc($res_users)) {
                $user_ids[] = $row_user['user_id'];
            }
            $real_score = 0;
            if ($user_ids) {
                $ids_str = implode(',', array_map('intval', $user_ids));
                $msg_res = mysqli_query($con, "
                    SELECT COUNT(*) AS cnt FROM messages
                    WHERE group_id = '$group_id'
                    AND user_id IN ($ids_str)
                ");
                $msg_row = mysqli_fetch_assoc($msg_res);
                $real_score = intval($msg_row['cnt']);
            }

            $pairs[$pair_key] = [
                'compat_pair' => $pair[0] . ' + ' . $pair[1],
                'compat_score' => $comp['compatibility_score'] ?? null,
                'compat_type' => $comp['relationship_type'] ?? '',
                'real_score' => $real_score
            ];
        }
    }

    // Sort pairs by real_score DESC, then by theoretical score
    usort($pairs, function($a, $b) {
        if ($b['real_score'] == $a['real_score']) {
            return $b['compat_score'] <=> $a['compat_score'];
        }
        return $b['real_score'] <=> $a['real_score'];
    });

    // Only keep top 8 pairs
    $pairs = array_slice($pairs, 0, 8);

    $group_mbti_compat[] = [
        'group_name' => $group_name,
        'pairs' => $pairs
    ];
}

// Summary of MBTI types in all groups
$mbti_group_summary = [];
foreach ($all_mbti_types as $type) {
    $res = mysqli_query($con, "
        SELECT COUNT(*) AS cnt
        FROM user_groups ug
        JOIN users u ON ug.user_id = u.user_id
        WHERE u.mbti = '$type'
    ");
    $row = mysqli_fetch_assoc($res);
    $mbti_group_summary[$type] = intval($row['cnt']);
}

$mbti_group_count = [];
foreach ($all_mbti_types as $type) {
    $res = mysqli_query($con, "
        SELECT COUNT(DISTINCT ug.group_id) AS cnt
        FROM user_groups ug
        JOIN users u ON ug.user_id = u.user_id
        WHERE u.mbti = '$type'
    ");
    $row = mysqli_fetch_assoc($res);
    $mbti_group_count[$type] = intval($row['cnt']);
}

$mbti_pair_counts = [];
foreach ($all_mbti_types as $i => $type1) {
    for ($j = $i+1; $j < count($all_mbti_types); $j++) {
        $type2 = $all_mbti_types[$j];
        $pair_key = $type1 . '-' . $type2;
        $mbti_pair_counts[$pair_key] = 0;
    }
}

// Loop through all groups and count pairs
$res_groups = mysqli_query($con, "SELECT id FROM groups");
while ($group = mysqli_fetch_assoc($res_groups)) {
    $group_id = $group['id'];
    $mbti_arr = [];
    $res_mbti = mysqli_query($con, "
        SELECT DISTINCT u.mbti FROM user_groups ug
        JOIN users u ON ug.user_id = u.user_id
        WHERE ug.group_id = '$group_id' AND u.mbti IS NOT NULL AND u.mbti != ''
    ");
    while ($row = mysqli_fetch_assoc($res_mbti)) {
        $mbti_arr[] = $row['mbti'];
    }
    // For each unique pair in this group, increment count
    for ($i = 0; $i < count($mbti_arr); $i++) {
        for ($j = $i+1; $j < count($mbti_arr); $j++) {
            $pair = [$mbti_arr[$i], $mbti_arr[$j]];
            sort($pair);
            $pair_key = $pair[0] . '-' . $pair[1];
            if (isset($mbti_pair_counts[$pair_key])) {
                $mbti_pair_counts[$pair_key]++;
            }
        }
    }
}

// Sort pairs by count DESC
arsort($mbti_pair_counts);

// Get top 8 pairs
$top_mbti_pairs = array_slice($mbti_pair_counts, 0, 8, true);

// MBTI Compatibility Analytics
$mbti_compat_analytics = [];
foreach ($all_mbti_types as $type) {
    // Find all group IDs where this MBTI is present
    $group_ids = [];
    $res = mysqli_query($con, "
        SELECT DISTINCT ug.group_id
        FROM user_groups ug
        JOIN users u ON ug.user_id = u.user_id
        WHERE u.mbti = '$type'
    ");
    while ($row = mysqli_fetch_assoc($res)) {
        $group_ids[] = $row['group_id'];
    }

    // Count co-occurrence with other MBTI types in those groups
    $co_mbti = [];
    if ($group_ids) {
        $group_ids_str = implode(',', array_map('intval', $group_ids));
        $res2 = mysqli_query($con, "
            SELECT u.mbti, COUNT(DISTINCT ug.group_id) AS cnt
            FROM user_groups ug
            JOIN users u ON ug.user_id = u.user_id
            WHERE ug.group_id IN ($group_ids_str) AND u.mbti != '$type'
            GROUP BY u.mbti
            ORDER BY cnt DESC
        ");
        while ($row2 = mysqli_fetch_assoc($res2)) {
            $co_mbti[$row2['mbti']] = intval($row2['cnt']);
        }
    }
    // Take top 3 co-occurring MBTI types
    $top_co_mbti = array_slice($co_mbti, 0, 3, true);

    $mbti_compat_analytics[$type] = [
        'group_count' => $mbti_group_count[$type],
        'top_co_mbti' => $top_co_mbti
    ];
}

// Get top 3 compatible MBTI types for each MBTI
$mbti_top_compat = [];
foreach ($all_mbti_types as $type) {
    $res = mysqli_query($con, "
        SELECT type2, compatibility_score
        FROM mbti_compatibility
        WHERE type1 = '$type'
        ORDER BY compatibility_score DESC
        LIMIT 3
    ");
    $top_types = [];
    while ($row = mysqli_fetch_assoc($res)) {
        $top_types[] = $row['type2'];
    }
    $mbti_top_compat[$type] = $top_types;
}

$user_mbti = $user_data['mbti'] ?? '';
$recommended_groups = [];

if ($user_mbti && isset($mbti_top_compat[$user_mbti])) {
    $top_compat_types = $mbti_top_compat[$user_mbti];
    $group_sql = "
        SELECT g.id, g.group_id, g.name, g.color, g.image, g.description, g.category, g.allowed_mbti
        FROM groups g
        JOIN user_groups ug1 ON g.id = ug1.group_id
        JOIN users u1 ON ug1.user_id = u1.user_id
        WHERE g.is_private = 0
        AND u1.mbti = '$user_mbti'
        GROUP BY g.id
        ORDER BY g.created_at DESC
    ";
    $result = mysqli_query($con, $group_sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $group_id = $row['id'];
        // Check if group has actual members of compatible MBTI types
        $has_compat = false;
        $best_pair = '';
        $best_score = 0;
        $best_type = '';
        $count1 = 0;
        $count2 = 0;
        foreach ($top_compat_types as $compat_mbti) {
            // Count members of compatible MBTI in this group
            $res2 = mysqli_query($con, "
                SELECT COUNT(*) AS cnt FROM user_groups ug
                JOIN users u ON ug.user_id = u.user_id
                WHERE ug.group_id = '$group_id' AND u.mbti = '$compat_mbti'
            ");
            $row2 = mysqli_fetch_assoc($res2);
            $compat_count = intval($row2['cnt']);
            if ($compat_count > 0) {
                $has_compat = true;
                // Get theoretical compatibility score
                $comp_res = mysqli_query($con, "
                    SELECT compatibility_score, relationship_type
                    FROM mbti_compatibility
                    WHERE (type1='$user_mbti' AND type2='$compat_mbti') OR (type1='$compat_mbti' AND type2='$user_mbti')
                    LIMIT 1
                ");
                $comp = mysqli_fetch_assoc($comp_res);
                $best_pair = "$user_mbti + $compat_mbti";
                $best_score = $comp['compatibility_score'] ?? 0;
                $best_type = $comp['relationship_type'] ?? '';
                // Count members of user MBTI in this group
                $res3 = mysqli_query($con, "
                    SELECT COUNT(*) AS cnt FROM user_groups ug
                    JOIN users u ON ug.user_id = u.user_id
                    WHERE ug.group_id = '$group_id' AND u.mbti = '$user_mbti'
                ");
                $row3 = mysqli_fetch_assoc($res3);
                $count1 = intval($row3['cnt']);
                $count2 = $compat_count;
                break; // Only need one compatible MBTI per group
            }
        }
        if ($has_compat) {
            $recommended_groups[] = [
                'name' => $row['name'],
                'pair' => $best_pair,
                'score' => $best_score,
                'type' => $best_type,
                'count1' => $count1,
                'count2' => $count2
            ];
        }
        if (count($recommended_groups) >= 6) break; // Limit to 6
    }
}

// Calculate MBTI member counts and compatibility pairs for each group
$group_mbti_members = [];
$group_compat_pairs = [];

$res_groups = mysqli_query($con, "SELECT id, name FROM groups");
while ($group = mysqli_fetch_assoc($res_groups)) {
    $group_id = $group['id'];
    $group_name = $group['name'];

    // Count MBTI members in this group
    $mbti_counts = [];
    $res_mbti = mysqli_query($con, "
        SELECT u.mbti, COUNT(*) as cnt
        FROM user_groups ug
        JOIN users u ON ug.user_id = u.user_id
        WHERE ug.group_id = '$group_id' AND u.mbti IS NOT NULL AND u.mbti != ''
        GROUP BY u.mbti
    ");
    while ($row = mysqli_fetch_assoc($res_mbti)) {
        $mbti_counts[$row['mbti']] = intval($row['cnt']);
    }
    $group_mbti_members[$group_id] = [
        'name' => $group_name,
        'mbti_counts' => $mbti_counts
    ];

    // Calculate MBTI pairs and compatibility
    $mbti_types = array_keys($mbti_counts);
    $pairs = [];
    for ($i = 0; $i < count($mbti_types); $i++) {
        for ($j = $i+1; $j < count($mbti_types); $j++) {
            $type1 = $mbti_types[$i];
            $type2 = $mbti_types[$j];
            // Get compatibility info
            $comp_res = mysqli_query($con, "
                SELECT compatibility_score, relationship_type
                FROM mbti_compatibility
                WHERE (type1='$type1' AND type2='$type2') OR (type1='$type2' AND type2='$type1')
                LIMIT 1
            ");
            $comp = mysqli_fetch_assoc($comp_res);
            $pairs[] = [
                'pair' => "$type1 + $type2",
                'score' => $comp['compatibility_score'] ?? null,
                'type' => $comp['relationship_type'] ?? 'unknown',
                'count1' => $mbti_counts[$type1],
                'count2' => $mbti_counts[$type2]
            ];
        }
    }
    $group_compat_pairs[$group_id] = [
        'pairs' => $pairs
    ];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin MBTI Analytics</title>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="CSS code/admin-dashboard.css">
    <style>
        body {background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);}
        .main-content {
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 6px 32px #342e3720;
            padding: 36px 36px 28px 36px;
            margin: 36px 0;
            min-height: 80vh;
        }
        .analytics-title {
            color: #3a7bd5;
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 24px;
            text-align: center;
        }
        .mbti-chart {
            display: flex;
            flex-wrap: wrap;
            gap: 18px;
            justify-content: center;
            margin-bottom: 36px;
        }
        .mbti-card {
            background: #f8faff;
            border-radius: 14px;
            box-shadow: 0 2px 8px #3a7bd510;
            padding: 1.2rem 1.2rem 1rem 1.2rem;
            text-align: center;
            width: 120px;
            display: flex;
            flex-direction: column;
            align-items: center;
            font-weight: 600;
            color: #3a7bd5;
            font-size: 1.18em;
            border: 2px solid #eaf3ff;
        }
        .mbti-card .mbti-type {
            font-size: 1.3em;
            font-weight: 700;
            margin-bottom: 0.3rem;
        }
        .mbti-card .mbti-count {
            color: #222;
            font-size: 1.1em;
        }
        .analytics-section-title {
            color: #667eea;
            font-size: 1.2em;
            font-weight: 700;
            margin-bottom: 14px;
            margin-top: 32px;
        }
        .analytics-table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 12px #342e3720;
            overflow: hidden;
            margin-bottom: 24px;
        }
        .analytics-table th, .analytics-table td {
            padding: 14px 18px;
            border-bottom: 1px solid #f0f4fa;
            text-align: left;
            font-size: 1.05em;
        }
        .analytics-table th {
            background: #f6f8fa;
            font-weight: 600;
            color: #3a7bd5;
            letter-spacing: 0.5px;
        }
        .analytics-table tr:last-child td { border-bottom: none; }
        .compat-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 18px;
        }
        .compat-table th, .compat-table td {
            padding: 10px 14px;
            border-bottom: 1px solid #f0f4fa;
            text-align: left;
            font-size: 1em;
        }
        .compat-table th {
            background: #f6f8fa;
            font-weight: 600;
            color: #3a7bd5;
        }
        .compat-table tr:last-child td { border-bottom: none; }
        .compat-pair {
            font-weight: 600;
            color: #667eea;
        }
        .compat-score {
            font-weight: 700;
            color: #3a7bd5;
        }
        .compat-type {
            font-size: 0.98em;
            color: #888;
        }
        @media (max-width: 900px) {
            .main-content { padding: 14px 4px; }
            .mbti-card { width: 90px; font-size: 1em; }
            .analytics-table th, .analytics-table td { padding: 8px 6px; }
        }
        @media (max-width: 700px) {
            .sidebar { display: none; }
            .main-content { padding: 12px 2vw; border-radius: 0; margin: 0; }
            .mbti-chart { gap: 8px; }
            .mbti-card { width: 70px; font-size: 0.92em; }
        }
        @media print {
    .sidebar {
        display: none !important;
    }
    .main-content {
        margin-left: 0 !important;
        width: 100% !important;
        border-radius: 0 !important;
        box-shadow: none !important;
    }
    body {
        background: #fff !important;
    }
}
    </style>
</head>
<body>
    <div class="container" style="position:relative;">
        <div class="sidebar">
            <div class="logo" style="display: flex; align-items: center; justify-content: center; padding: 18px 0;">
                <img src="images/Logo-nobg.png" alt="BUMBTI Logo" class="logo-img" style="height:80px; width:80px; display:block;">
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
                    <a href="admin-users.php" class="nav-link">
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
                    <a href="admin-analytics.php" class="nav-link active">
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
                    <a href="logout.php" class="nav-link">
                        <i class="bx bx-log-out nav-icon"></i>
                        Logout
                    </a>
                </li>
            </ul>
        </div>
        <div class="main-content">
            <div class="analytics-title"><i class="bx bx-brain"></i> MBTI Analytics</div>
            
            <div style="text-align:right; margin-bottom:18px;">
                <button onclick="window.print()" style="
                    background: linear-gradient(90deg,#3a7bd5 0%,#764ba2 100%);
                    color: #fff;
                    border: none;
                    border-radius: 8px;
                    padding: 10px 28px;
                    font-size: 1.08em;
                    font-weight: 600;
                    cursor: pointer;
                    box-shadow: 0 2px 8px #3a7bd522;
                    transition: background 0.2s;
                ">
                    <i class="bx bx-printer"></i> Print Report
                </button>
            </div>
<div class="analytics-section-title">Total Users by MBTI Type</div>
<div class="mbti-chart">
    <?php foreach ($all_mbti_types as $type): ?>
        <div class="mbti-card">
            <div class="mbti-type"><?= htmlspecialchars($type) ?></div>
            <div class="mbti-count">
                <?php
                $res = mysqli_query($con, "SELECT COUNT(*) AS cnt FROM users WHERE mbti = '$type'");
                $row = mysqli_fetch_assoc($res);
                echo intval($row['cnt']);
                ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>
            
            

    



<div class="analytics-section-title">Top MBTI Compatibility Pairs (by group co-membership)</div>
<table class="compat-table">
    <thead>
        <tr>
            <th>Pair</th>
            <th>Groups Together</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($top_mbti_pairs as $pair => $count): ?>
            <tr>
                <td class="compat-pair"><?= htmlspecialchars(str_replace('-', ' + ', $pair)) ?></td>
                <td class="compat-score"><?= $count ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div class="analytics-section-title">MBTI Compatibility Analytics (Group Presence & Co-occurrence)</div>
<table class="compat-table">
    <thead>
        <tr>
            <th>MBTI Type</th>
            <th>Groups Present In</th>
            <th>Top Co-Occurring MBTI Types</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($mbti_compat_analytics as $type => $data): ?>
            <tr>
                <td class="compat-pair"><?= htmlspecialchars($type) ?></td>
                <td class="compat-score"><?= $data['group_count'] ?></td>
                <td>
                    <?php if ($data['top_co_mbti']): ?>
                        <?php foreach ($data['top_co_mbti'] as $co_type => $cnt): ?>
                            <span style="color:#3a7bd5;font-weight:600;"><?= htmlspecialchars($co_type) ?></span>
                            <span style="color:#888;">(<?= $cnt ?> groups)</span>
                            &nbsp;
                        <?php endforeach; ?>
                    <?php else: ?>
                        <span style="color:#aaa;">-</span>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div class="analytics-section-title">Top 3 Compatible MBTI Types for Each MBTI</div>
<table class="compat-table">
    <thead>
        <tr>
            <th>MBTI Type</th>
            <th>Top 3 Compatible Types</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($mbti_top_compat as $type => $top_types): ?>
            <tr>
                <td class="compat-pair"><?= htmlspecialchars($type) ?></td>
                <td class="compat-pair">
                    <?php if ($top_types): ?>
                        <?php foreach ($top_types as $top_type): ?>
                            <span style="color:#3a7bd5;font-weight:600;"><?= htmlspecialchars($top_type) ?></span>
                            &nbsp;
                        <?php endforeach; ?>
                    <?php else: ?>
                        <span style="color:#aaa;">-</span>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>



<?php
echo '<div class="analytics-section-title">Groups with High MBTI Compatibility Pairs (0.95, 0.90)</div>';
$res_groups = mysqli_query($con, "SELECT id, name, category FROM groups WHERE is_private = 0");
while ($group = mysqli_fetch_assoc($res_groups)) {
    $group_id = $group['id'];
    // Find MBTI types in this group
    $mbti_arr = [];
    $res_mbti = mysqli_query($con, "
        SELECT DISTINCT u.mbti FROM user_groups ug
        JOIN users u ON ug.user_id = u.user_id
        WHERE ug.group_id = '$group_id' AND u.mbti IS NOT NULL AND u.mbti != ''
    ");
    while ($row = mysqli_fetch_assoc($res_mbti)) {
        $mbti_arr[] = $row['mbti'];
    }
    // Find compatible pairs
    $pairs = [];
    for ($i = 0; $i < count($mbti_arr); $i++) {
        for ($j = $i+1; $j < count($mbti_arr); $j++) {
            $type1 = $mbti_arr[$i];
            $type2 = $mbti_arr[$j];
            $comp_res = mysqli_query($con, "
                SELECT compatibility_score, relationship_type
                FROM mbti_compatibility
                WHERE ((type1='$type1' AND type2='$type2') OR (type1='$type2' AND type2='$type1'))
                AND compatibility_score IN (0.95, 0.90)
                LIMIT 1
            ");
            $comp = mysqli_fetch_assoc($comp_res);
            if ($comp) {
                $pairs[] = [
                    'pair' => "$type1 + $type2",
                    'score' => $comp['compatibility_score'],
                    'type' => $comp['relationship_type']
                ];
            }
        }
    }
    if ($pairs) {
        echo '<div class="analytics-group-card">';
        echo '<div class="group-name">' . htmlspecialchars($group['name']) . ' <span style="color:#888;">(' . htmlspecialchars($group['category']) . ')</span></div>';
        echo '<table class="compat-table"><thead><tr><th>MBTI Pair</th><th>Score</th><th>Type</th></tr></thead><tbody>';
        foreach ($pairs as $pair) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($pair['pair']) . '</td>';
            echo '<td>' . number_format($pair['score'],2) . '</td>';
            echo '<td>' . htmlspecialchars($pair['type']) . '</td>';
            echo '</tr>';
        }
        echo '</tbody></table></div>';
    }
}
?>



        </div>
    </div>
</body>
</html>