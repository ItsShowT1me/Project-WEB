<?php
session_start();
include("connection.php");

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login_f1.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Get user information
$user_query = "SELECT user_name, email, phone FROM users WHERE user_id = '$user_id'";
$user_result = mysqli_query($con, $user_query);
$user = mysqli_fetch_assoc($user_result);

$message = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $feedback_message = mysqli_real_escape_string($con, $_POST['message']);
    
    if (!empty($feedback_message)) {
        $insert_query = "INSERT INTO feedback (user_id, message) VALUES ('$user_id', '$feedback_message')";
        
        if (mysqli_query($con, $insert_query)) {
            $message = "Thank you for your feedback! We'll get back to you soon.";
        } else {
            $message = "Error sending feedback. Please try again.";
        }
    } else {
        $message = "Please enter your message.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TypeToWork Contact Us</title>
    <link rel="stylesheet" href="CSS code\contact-us.css">
    <link rel="stylesheet" href="CSS code\index.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <!-- Sidebar Menu -->
    <nav id="sidebar">
        <a href="index.php" class="brand">
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

    <div class="contact-main">
        <div class="item">
            <div class="contact">
                <div class="frist-text">Let's get in touch</div>
                <img src="pf_image/contact-us-img.png" alt="" class="image">
                <div class="social-link">
                    <span class="secnd-text">Connect with us :</span>
                </div>
            </div>
            <div class="submit-form">
                <h4 class="thrid-text text-con">Contact Us</h4>
                
                <?php if ($message): ?>
                    <div class="message <?= strpos($message, 'Error') !== false ? 'error' : 'success' ?>">
                        <?= $message ?>
                    </div>
                <?php endif; ?>

                <!-- Display user info (read-only) -->
                <div class="user-info">
                    <p><strong>Name:</strong> <?= htmlspecialchars($user['user_name']) ?></p>
                    <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
                    <p><strong>Phone:</strong> <?= htmlspecialchars($user['phone']) ?></p>
                </div>

                <form method="POST">
                    <div class="input-box-x">
                        <textarea name="message" class="input" required id="message" cols="40" rows="10"></textarea>
                        <label for="message">Message</label>
                    </div>
                    
                    <button type="submit" class="btn-submit-con">Send Feedback</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>