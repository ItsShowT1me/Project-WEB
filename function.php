<?php
<?php

function check_login($con)
{
    if (isset($_SESSION['user_id'])) {
        $id = $_SESSION['user_id'];
        $query = "SELECT * FROM users WHERE user_id = :id LIMIT 1";

        $stmt = $con->prepare($query);
        $stmt->execute(['id' => $id]);
        $user_data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user_data) {
            return $user_data;
        }
    }

    // Redirect to login page if not logged in
    header("Location: login.php");
    die;
}

function random_num($length)
{
    $text = "";
    if ($length < 5) {
        $length = 5;
    }

    $len = rand(4, $length);

    for ($i = 0; $i < $len; $i++) {
        $text .= rand(0, 9);
    }

    return $text;
}
