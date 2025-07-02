<?php
$host = "localhost";
$user = "root"; // ถ้าใช้ XAMPP root ไม่มีรหัสผ่าน
$pass = "";
$dbname = "user";

$conn = ;

$conn = mysqli_connect($host, 
                       $user, 
                       $pass, 
                       $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// echo "เชื่อมต่อสำเร็จ";
?>