<?php
session_start();

define('DB_HOST', 'proiect1htmlnota1-mysql_db-1');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'perfume_store');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
