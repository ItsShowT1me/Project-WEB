<?php
session_start();
include("connection.php");

// ถ้าไม่ได้ login ให้กลับไปที่ login
if (!isset($_SESSION['user_id'])) {
    header("Location: login_f1.php");
    exit();
}

// ดึงข้อมูลผู้ใช้
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE user_id = '$user_id' LIMIT 1";
$result = mysqli_query($con, $query);
$user = mysqli_fetch_assoc($result);
?>


<!DOCTYPE html>
<html>
<head>

  <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="index.css">
</head>
<body>
  <h1>Welcome, <?php echo $user['user_name']; ?></h1>
  <p><strong>Name:</strong> <?php echo $user['user_name']; ?></p>
  <p><strong>Email:</strong> <?php echo $user['email']; ?></p>
  <p><strong>Phone Number:</strong> <?php echo $user['phone']; ?></p>

  <a href="logout.php">Logout</a>
</body>
</html>
