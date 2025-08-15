<?php

$db_host = 'dpg-d7zb1br1leoes73cnfv1g-a.singapore-postgres.render.com';
$db_user = 'login_db';
$db_pass = 'TeJnx0NksvJ1JIPtwtij8JevLuDK6xG';
$db_name = 'login_db_zu0j';
$db_port = '5432';

$dsn = "pgsql:host=$db_host;port=$db_port;dbname=$db_name;sslmode=require";
try {
    $conn = new PDO($dsn, $db_user, $db_pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>

