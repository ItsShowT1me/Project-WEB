<?php
session_start(); // <-- Always first!
include 'function.php';
include 'connection.php';

$user_data = check_login($con);

// Check if user is banned
if (!empty($user_data['banned_until']) && strtotime($user_data['banned_until']) > time()) {
    $ban_time = date('d M Y H:i', strtotime($user_data['banned_until']));
    echo "<div style='background:#ffeaea;color:#DB504A;padding:18px 24px;border-radius:12px;margin:32px auto;max-width:420px;text-align:center;font-size:1.15em;font-weight:600;box-shadow:0 2px 12px #DB504A22;'>
        <i class='bx bxs-error' style='font-size:2em;vertical-align:middle;'></i>
        <br>
        You are banned until <span style='color:#b92d23;'>$ban_time</span>.
        <br>
        Please contact support if you believe this is a mistake.<br><br>
        <button onclick=\"window.location.href='login_f1.php'\" style='background:#DB504A;color:#fff;border:none;border-radius:8px;padding:10px 32px;font-size:1em;font-weight:600;cursor:pointer;box-shadow:0 2px 8px #DB504A22;'>OK</button>
    </div>";
    exit();
}

// Handle join group action
if (isset($_GET['join']) && is_numeric($_GET['join']) && isset($_SESSION['user_id'])) {
    $group_id = intval($_GET['join']);
    $user_id = $_SESSION['user_id'];
    // Check if user already joined
    $check = mysqli_query($con, "SELECT * FROM user_groups WHERE user_id = '$user_id' AND group_id = '$group_id'");
    if (mysqli_num_rows($check) == 0) {
        mysqli_query($con, "INSERT INTO user_groups (user_id, group_id) VALUES ('$user_id', '$group_id')");
        echo "<script>alert('You have joined the group!');window.location='chat.php?group_id=$group_id';</script>";
        exit();
    } else {
        echo "<script>alert('You are already a member of this group.');window.location='chat.php?group_id=$group_id';</script>";
        exit();
    }
}

// Handle interest category selection and save to database
if (isset($_POST['interestCategory']) && isset($_SESSION['user_id'])) {
    $interest = mysqli_real_escape_string($con, $_POST['interestCategory']);
    $user_id = $_SESSION['user_id'];
    mysqli_query($con, "UPDATE users SET interested_category='$interest' WHERE user_id='$user_id'");
    $_SESSION['interested_category'] = $interest;
    $show_interest_modal = false;
}

// Get user's interested category
$interested_category = '';
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $result_interest = mysqli_query($con, "SELECT interested_category FROM users WHERE user_id='$user_id'");
    if ($row = mysqli_fetch_assoc($result_interest)) {
        $interested_category = $row['interested_category'];
    }
}

// Fetch only public groups, filtered by interest if set
$groups = [];
$group_sql = "SELECT id, group_id, name, color, description, category FROM groups WHERE is_private = 0";
if ($interested_category) {
    $group_sql .= " AND category = '" . mysqli_real_escape_string($con, $interested_category) . "'";
}
$group_sql .= " ORDER BY created_at DESC";
$result = mysqli_query($con, $group_sql);
while ($row = mysqli_fetch_assoc($result)) {
    $groups[] = $row;
}

// Check if user has joined any group
$show_interest_modal = false;
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $check_group = mysqli_query($con, "SELECT 1 FROM user_groups WHERE user_id = '$user_id' LIMIT 1");
    if (mysqli_num_rows($check_group) == 0) {
        $show_interest_modal = true;
    }
}
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
          <a href="index.php">Main</a>
        </div>
        <div class="search-bar" style="display: flex; align-items: center; gap: 8px;">
          <form id="searchForm" style="display: flex; align-items: center; gap: 8px;">
            <input type="text" id="searchInput" class="form-control" placeholder="Search group..." style="height:32px; font-size:1em;">
            <select id="searchType" class="form-select" style="height:32px; font-size:1em;">
              <option value="name">Name</option>
              <option value="category">Category</option>
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

<?php if ($show_interest_modal): ?>
    <div class="interest-box">
        <button onclick="document.getElementById('interestCategoryBox').style.display='block';this.style.display='none';"
            class="interest-btn">
            <i class="bx bxs-star"></i> Looking for group
        </button>
        <div id="interestCategoryBox" class="interest-category-box" style="display:none;margin-top:24px;">
            <form id="interestForm" method="POST">
                <label for="interestCategory">
                    What group category are you interested in?
                </label>
                <select id="interestCategory" name="interestCategory" required>
                    <option value="">Select category...</option>
                    <option value="game">Game</option>
                    <option value="music">Music</option>
                    <option value="movie">Movie</option>
                    <option value="sport">Sport</option>
                    <option value="tourism">Tourism</option>
                    <option value="other">Other</option>
                </select>
                <button type="submit">OK</button>
            </form>
        </div>
    </div>
<?php endif; ?>

<!-- Group Grid -->
<div class="user-grid">
    <?php foreach ($groups as $group): ?>
        <?php
        // Check if user already joined this group
        $already_joined = false;
        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];
            $check = mysqli_query($con, "SELECT 1 FROM user_groups WHERE user_id = '$user_id' AND group_id = '{$group['id']}' LIMIT 1");
            $already_joined = mysqli_num_rows($check) > 0;
        }
        ?>
        <div class="user-card"
           data-name="<?= strtolower(htmlspecialchars($group['name'])) ?>"
           data-category="<?= strtolower(htmlspecialchars($group['category'])) ?>"
           style="cursor:pointer;text-decoration:none;">
            <div class="user-image" style="background:<?= htmlspecialchars($group['color'] ?? '#eaf3ff') ?>;">
                <i class="bx bxs-group" style="font-size:2.8em;color:#fff;"></i>
            </div>
            <div class="user-info">
                <div class="user-name"><?= htmlspecialchars($group['name']) ?></div>
                <div class="user-mbti"><?= ucfirst(htmlspecialchars($group['category'])) ?></div>
                <div class="user-email"><?= htmlspecialchars($group['description']) ?></div>
            </div>
            <?php if ($already_joined): ?>
                <a href="chat.php?group_id=<?= $group['id'] ?>" class="go-group-btn"
                   style="margin-top:14px;width:100%;background:#3a7bd5;color:#fff;border:none;border-radius:8px;padding:10px 0;font-size:1em;font-weight:600;cursor:pointer;text-align:center;display:block;text-decoration:none;transition:background 0.2s;">
                    <i class="bx bx-chat"></i> Go to Group
                </a>
            <?php else: ?>
                <button class="join-btn"
                    onclick="confirmJoin(<?= $group['id'] ?>)"
                    style="margin-top:14px;width:100%;background:#667eea;color:#fff;border:none;border-radius:8px;padding:10px 0;font-size:1em;font-weight:600;cursor:pointer;transition:background 0.2s;">
                    <i class="bx bx-log-in"></i> Join Group
                </button>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>

<script>
function confirmJoin(groupId) {
    if (confirm('Do you want to join this group?')) {
        window.location.href = 'index.php?join=' + groupId;
    }
}
function closeInterestModal() {
    document.getElementById('interestModal').style.display = 'none';
}
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const searchType = document.getElementById('searchType');
    const groupCards = document.querySelectorAll('.user-card');

    function filterGroups() {
        const query = searchInput.value.trim().toLowerCase();
        const type = searchType.value; // "name" or "category"

        groupCards.forEach(card => {
            const value = card.dataset[type] || '';
            if (value.includes(query)) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });
    }

    searchInput.addEventListener('input', filterGroups);
    searchType.addEventListener('change', filterGroups);

    <?php if ($show_interest_modal): ?>
    document.getElementById('interestModal').style.display = 'flex';
    <?php endif; ?>
});
</script>
</body>
</html>