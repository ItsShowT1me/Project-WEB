<?php
session_start();
include("connection.php");

$group_id = isset($_GET['group_id']) ? intval($_GET['group_id']) : 1;

// Fetch group info
$group = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM groups WHERE id = '$group_id'"));

// Fetch members and group creator
$members = [];
$creator_id = null;
if ($group) {
    $creator_res = mysqli_query($con, "SELECT user_id FROM user_groups WHERE group_id = '$group_id' ORDER BY id ASC LIMIT 1");
    if ($creator_row = mysqli_fetch_assoc($creator_res)) {
        $creator_id = $creator_row['user_id'];
    }
    $res = mysqli_query($con, "
        SELECT u.user_id, u.user_name, u.mbti 
        FROM user_groups ug
        JOIN users u ON ug.user_id = u.user_id
        WHERE ug.group_id = '$group_id'
    ");
    while ($row = mysqli_fetch_assoc($res)) {
        $members[] = $row;
    }
}

// Handle leave group action
if (isset($_GET['leave']) && isset($_SESSION['user_id']) && $group) {
    $leave_id = intval($_SESSION['user_id']);
    // Prevent group creator from leaving
    if ($leave_id != $creator_id) {
        mysqli_query($con, "DELETE FROM user_groups WHERE user_id='$leave_id' AND group_id='$group_id'");
        header("Location: group.php");
        exit();
    }
}

// Check if user is banned
$user_id = $_SESSION['user_id'] ?? null;
$user_data = null;
if ($user_id) {
    $user_data = mysqli_fetch_assoc(mysqli_query($con, "SELECT banned_until FROM users WHERE user_id = '$user_id'"));
}
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
        .color-badge {
            display: inline-block;
            width: 22px;
            height: 22px;
            border-radius: 6px;
            border: 2px solid #eee;
            margin-right: 8px;
            vertical-align: middle;
        }
        .group-description {
            background: #f7f9fb;
            border-radius: 10px;
            padding: 12px 16px;
            color: #222;
            margin-bottom: 18px;
            font-size: 1em;
            box-shadow: 0 2px 8px #3a7bd510;
        }
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
        .profile-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 16px #3a7bd520;
            width: 340px;
            margin: 60px auto 0 auto;
            padding: 32px 28px 24px 28px;
            display: flex;
            flex-direction: column;
            align-items: center;
            font-family: 'Poppins', Arial, sans-serif;
        }

        .profile-image {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            overflow: hidden;
            margin-bottom: 18px;
            border: 4px solid #3a7bd5;
            box-shadow: 0 2px 8px #3a7bd520;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .profile-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
            display: block;
        }

        .profile-info {
            width: 100%;
            text-align: left;
        }

        .profile-name {
            font-size: 1.4em;
            font-weight: 600;
            color: #222;
            margin-bottom: 12px;
            text-align: left;
            word-break: break-word;
        }

        .profile-detail {
            font-size: 1em;
            color: #222;
            margin-bottom: 6px;
            word-break: break-word;
        }

        .pdf-link {
            display: inline-flex;
            align-items: center;
            color: #e74c3c;
            font-weight: 500;
            text-decoration: none;
            font-size: 1em;
        }
        .pdf-link i {
            margin-right: 6px;
            font-size: 1.2em;
        }
        .chat-message {
            display: flex;
            align-items: flex-end;
            margin-bottom: 18px;
            transition: background 0.2s;
        }
        .chat-message.left { justify-content: flex-start; }
        .chat-message.right { justify-content: flex-end; }
        .chat-avatar {
            width: 36px;
            height: 36px;
            background: #3a7bd5;
            color: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1.1em;
            margin: 0 10px;
            box-shadow: 0 2px 8px #3a7bd510;
        }
        .chat-avatar img { width:100%; height:100%; border-radius:50%; }
        .chat-bubble {
            max-width: 380px;
            padding: 14px 18px;
            border-radius: 16px;
            box-shadow: 0 2px 8px #3a7bd510;
            transition: box-shadow 0.2s;
        }
        .bubble-mine {
            background: linear-gradient(135deg, #6A11CB 0%, #2575FC 100%);
            color: #fff;
            border-bottom-right-radius: 4px;
        }
        .bubble-other {
            background: #eaf3ff;
            color: #222;
            border-bottom-left-radius: 4px;
        }
        .chat-bubble:hover { box-shadow: 0 4px 16px #3a7bd520; }
        #chat-form {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 8px;
            background: #fff;
            border-radius: 12px;
            padding: 10px 16px;
            box-shadow: 0 2px 8px #3a7bd510;
        }
        #chat-form input[type="text"] {
            flex: 1 1 0;
            padding: 12px 16px;
            border-radius: 8px;
            border: 1px solid #d0d7e2;
            font-size: 1.1em;
            outline: none;
            background: #f7f9fb;
            transition: border 0.2s;
        }
        #chat-form input[type="text"]:focus { border-color: #3a7bd5; }
        #attach-btn, .send-btn {
            background: #3a7bd5;
            color: #fff;
            border: none;
            border-radius: 8px;
            width: 44px;
            height: 44px;
            font-size: 1.5em;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.2s;
        }
        #attach-btn:hover, .send-btn:hover { background: #2575FC; }
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
<a href="group.php" class="return-btn"><i class="bx bx-arrow-back"></i> Return</a>
<div class="container">
    <?php if ($group): ?>
    <div class="sidebar">
        <h4 style="text-align:center;">Group Details</h4>
        <div class="detail-label">Group Name:</div>
        <div class="detail-value">
            <span class="color-badge" style="background:<?= htmlspecialchars($group['color']) ?>"></span>
            <?= htmlspecialchars($group['name']) ?>
            <span class="group-type" style="background:#eaf3ff;color:#3a7bd5;padding:4px 12px;border-radius:10px;font-weight:500;margin-left:8px;">
                <?= $group['is_private'] ? 'Private' : 'Public' ?>
            </span>
            <span class="group-category" style="background:#f7f9fb;color:#764ba2;padding:4px 12px;border-radius:10px;font-weight:500;margin-left:8px;">
                <?= ucfirst($group['category']) ?>
            </span>
            <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $creator_id): ?>
                <a href="edit_group.php?group_id=<?= $group_id ?>" class="edit-group-btn" style="
                    background: #667eea;
                    color: #fff;
                    border: none;
                    border-radius: 8px;
                    padding: 6px 18px;
                    font-size: 1em;
                    margin-left: 16px;
                    cursor: pointer;
                    text-decoration: none;
                    display: inline-flex;
                    align-items: center;
                    gap: 6px;
                    box-shadow: 0 2px 8px #667eea22;
                    transition: background 0.2s;
                " onmouseover="this.style.background='#3a7bd5'" onmouseout="this.style.background='#667eea'">
                    <i class="bx bx-edit"></i> Edit Group
                </a>
            <?php endif; ?>
        </div>
        <div class="detail-label">Created:</div>
        <div class="detail-value"><?= date('d/m/Y', strtotime($group['created_at'])) ?></div>
        <div class="detail-label">Group Pin:</div>
        <div class="detail-value"><?= htmlspecialchars($group['pin']) ?></div>
        <div class="detail-label">Project Detail:</div>
        <div class="group-description"><?= nl2br(htmlspecialchars($group['description'])) ?></div>
        <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] != $creator_id): ?>
            <a href="chat.php?group_id=<?= $group_id ?>&leave=1" class="leave-group-btn" style="
                background: #DB504A;
                color: #fff;
                border: none;
                border-radius: 8px;
                padding: 8px 18px;
                font-size: 1em;
                margin-top: 18px;
                cursor: pointer;
                text-decoration: none;
                display: inline-flex;
                align-items: center;
                gap: 8px;
                font-weight: 600;
                box-shadow: 0 2px 8px #DB504A22;
                transition: background 0.2s;
            " onclick="return confirm('Are you sure you want to leave this group?');">
                <i class="bx bx-log-out"></i> Leave Group
            </a>
        <?php endif; ?>
    </div>
    <div class="chat-area">
        <h4><i class="bx bx-chat"></i> Group Chat</h4>
        <div id="chat-box"></div>
        <form id="chat-form" enctype="multipart/form-data">
            <input type="hidden" name="group_id" value="<?= $group_id ?>">
            <input type="text" name="message" placeholder="Type your message..." required autocomplete="off">
            <input type="file" name="file" id="file-input" style="display:none;">
            <button type="button" id="attach-btn" title="Attach file"><i class="bx bx-paperclip"></i></button>
            <button type="submit" class="send-btn" title="Send"><i class="bx bx-send"></i></button>
        </form>
    </div>
    <div class="member-list">
        <h4><i class="bx bx-group"></i> Members</h4>
        <?php if (count($members) > 0): ?>
            <?php foreach ($members as $m): ?>
                <div class="member-item">
                    <div class="member-avatar"><?= strtoupper($m['user_name'][0]) ?></div>
                    <div>
                        <div class="member-name">
                            <?= htmlspecialchars($m['user_name']) ?>
                            <?php if ($m['user_id'] == $creator_id): ?>
                                <span title="Group Creator" style="margin-left:6px;font-size:1.2em;color:#ffce26;">🛠️</span>
                            <?php endif; ?>
                        </div>
                        <div class="member-mbti" style="background:#eaf3ff;padding:2px 8px;border-radius:8px;display:inline-block;margin-top:2px;">
                            <?= htmlspecialchars($m['mbti']) ?>
                        </div>
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
<script>
$(function(){
    function renderMessage(msg) {
        var isMine = msg.user_id == <?= json_encode($_SESSION['user_id']) ?>;
        var align = isMine ? 'right' : 'left';
        var bubble = isMine ? 'bubble-mine' : 'bubble-other';
        var avatar = msg.image ? `<img src="${msg.image}" class="chat-avatar">` : `<div class="chat-avatar">${msg.user_name.charAt(0).toUpperCase()}</div>`;
        return `
        <div class="chat-message ${align}">
            ${!isMine ? avatar : ''}
            <div class="chat-bubble ${bubble}">
                <div class="chat-header">
                    <span class="chat-user">${msg.user_name}</span>
                    <span class="chat-mbti">(${msg.mbti})</span>
                    <span class="chat-time">${msg.time}</span>
                </div>
                <div class="chat-text">${msg.text}</div>
            </div>
            ${isMine ? avatar : ''}
        </div>`;
    }
    // Example: Load messages (replace with AJAX)
    // $('#chat-box').html(renderMessage({user_id:1,user_name:'Alice',mbti:'INTJ',text:'Hello!',time:'10:00',image:''}));
});
</script>
</body>
</html>