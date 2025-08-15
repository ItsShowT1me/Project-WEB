<?php
$db_host = 'dpg-d7zb1br1leoes73cnfv1g-a.singapore-postgres.render.com';
$db_user = 'login_db';
$db_pass = 'TeJnx0NksvJ1JIPtwtij8JevLuDK6xG';
$db_name = 'login_db_ruj9';
$db_port = '5432';

$conn = pg_connect("host=$db_host port=$db_port dbname=$db_name user=$db_user password=$db_pass sslmode=require");
if (!$conn) {
    die("Connection failed: " . pg_last_error($conn));
}
?>
