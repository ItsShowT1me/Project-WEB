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
      <a href="index.php">
          <div class="sidebar-brand">
              <img src="images/Logo-nobg.png" alt="Logo" class="logo">
          </div>
      </a>
      <ul class="sidebar-menu">
          <li><a href="index.php"><i class="bx bx-home"></i><span class="text">Main</span></a></li>
          <li><a href="group.php"><i class="bx bxs-group"></i><span class="text">My Group</span></a></li>
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
            <!-- Left: Contact Info & Social -->
            <div class="contact" style="display: flex; flex-direction: column; align-items: center; justify-content: center; background: #f8f9fa;">
                <div class="frist-text" style="color: #3C5C9E;">Let's get in touch</div>
                <img src="pf_image/contact-us-img.png" alt="Contact illustration" class="image" style="margin: 20px 0; border-radius: 12px; box-shadow: 0 2px 12px rgba(60,91,158,0.08);">
                <div class="social-link" style="margin-top: 10px;">
                    <span class="secnd-text" style="color: #3C5C9E;">Connect with us:</span>
                    <ul class="social-media" style="display: flex; gap: 10px; margin-top: 10px;">
                        <li><a href="mailto:info@typetowork.com" title="Email"><i class='bx bx-envelope'></i></a></li>
                        <li><a href="tel:+1234567890" title="Phone"><i class='bx bx-phone'></i></a></li>
                        <li><a href="#" title="Facebook"><i class='bx bxl-facebook'></i></a></li>
                        <li><a href="#" title="Twitter"><i class='bx bxl-twitter'></i></a></li>
                        <li><a href="#" title="Instagram"><i class='bx bxl-instagram'></i></a></li>
                    </ul>
                </div>
                <div class="contact-details" style="margin-top: 20px; text-align: left; color: #333;">
                    <p><i class='bx bx-envelope'></i> info@typetowork.com</p>
                    <p><i class='bx bx-phone'></i> +1 234 567 890</p>
                    <p><i class='bx bx-map'></i> 123 Main St, City, Country</p>
                </div>
            </div>
            <!-- Right: Form -->
            <div class="submit-form" style="display: flex; flex-direction: column; justify-content: center;">
                <h4 class="thrid-text text-con" style="margin-bottom: 10px;">Contact Us</h4>
                <?php if ($message): ?>
                    <div class="message <?= strpos($message, 'Error') !== false ? 'error' : 'success' ?>" style="margin-bottom: 15px; padding: 10px; border-radius: 6px; background: <?= strpos($message, 'Error') !== false ? '#ffe5e5' : '#e5ffe5' ?>; color: <?= strpos($message, 'Error') !== false ? '#d32f2f' : '#388e3c' ?>; border: 1px solid <?= strpos($message, 'Error') !== false ? '#f44336' : '#4caf50' ?>;">
                        <?= $message ?>
                    </div>
                <?php endif; ?>
                <div class="user-info" style="background: rgba(255,255,255,0.7); border-radius: 8px; padding: 10px 15px; margin-bottom: 15px; box-shadow: 0 1px 4px rgba(0,0,0,0.04);">
                    <p style="margin: 0 0 5px 0;"><strong>Name:</strong> <?= htmlspecialchars($user['user_name']) ?></p>
                    <p style="margin: 0 0 5px 0;"><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
                    <p style="margin: 0;"><strong>Phone:</strong> <?= htmlspecialchars($user['phone']) ?></p>
                </div>
                <form method="POST" style="width: 100%;">
                    <div class="input-box-x" style="width: 100%;">
                        <textarea name="message" class="input" required id="message" cols="40" rows="7" placeholder="Type your message here..." aria-label="Message"></textarea>
                    </div>
                    <button type="submit" class="btn-submit-con" style="margin-top: 10px;">Send Feedback</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>