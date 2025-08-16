<?php
$db_host = 'dpg-d2fpib7diees73cnfvlg-a.singapore-postgres.render.com';
$db_user = 'login_db';
$db_pass = 'IoJndXlNSuvJJIJIPwttdj10vzLuDKGr';
$db_name = 'login_db_zu0j';
$db_port = '5432';

// $dsn = "pgsql:host=$db_host;port=$db_port;dbname=$db_name;sslmode=require";
// try {
//     $con = new PDO($dsn, $db_user, $db_pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
// } catch (PDOException $e) {
//     exit; // No message, no output
// }

$con = pg_connect("host=localhost dbname=your_db user=your_user password=your_password");
