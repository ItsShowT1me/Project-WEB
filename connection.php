

<?php
$db_host = 'dpg-d7zb1br1leoes73cnfv1g-a.singapore-postgres.render.com'; // Use external hostname
$db_user = 'login_db';                     // Username from Render
$db_pass = 'TeJnx0NksvJ1JIPtwtij8JevLuDK6xG'; // Password from Render
$db_name = 'login_db_ruj9';                // Database name from Render
$db_port = '5432';                         // Port from Render

// For PostgreSQL, use PDO or pg_connect instead of mysqli
$conn = pg_connect("host=$db_host port=$db_port dbname=$db_name user=$db_user password=$db_pass");
if (!$conn) {
    die("Connection failed: " . pg_last_error());
}
?>


