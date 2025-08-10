<?php

include 'connection.php';
$group_id = intval($_GET['group_id']);
$members = [];
$result = mysqli_query($con, "SELECT u.user_name, u.mbti, u.image FROM user_groups ug JOIN users u ON ug.user_id = u.user_id WHERE ug.group_id = $group_id");
while ($row = mysqli_fetch_assoc($result)) {
    $members[] = $row;
}
if ($members) {
    echo '<ul>';
    foreach ($members as $m) {
        $avatar = !empty($m['image']) ? '<img src="'.htmlspecialchars($m['image']).'" class="modal-member-avatar" />'
            : '<div class="modal-member-avatar">'.strtoupper(substr($m['user_name'],0,1)).'</div>';
        echo '<li>' . $avatar .
            '<span class="modal-member-name">' . htmlspecialchars($m['user_name']) . '</span>' .
            '<span class="modal-member-mbti">' . htmlspecialchars($m['mbti']) . '</span>' .
            '</li>';
    }
    echo '</ul>';
} else {
    echo '<div style="color:#aaa;">No members found.</div>';
}
?>