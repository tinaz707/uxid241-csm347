<?php
declare(strict_types=1);

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Get database settings from config.php
$config = require 'config.php';

$host = $config['db_host'];
$user = $config['db_user'];
$pass = $config['db_pass'];
$db = $config['db_name'];

//connect to database
try {
  $conn = mysqli_connect($host, $user, $pass, $db);
  mysqli_set_charset($conn, 'utf8mb4');

} catch (mysqli_sql_exception $e) {
  exit('Connection failed: ' . $e->getMessage());
}

return $conn;

?>