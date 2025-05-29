<?php
$host = 'mysql_db'; // sau 'db' dacă ești în Docker
$user = 'root';
$password = 'toor';
$database = 'perfume_store';

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Conexiune eșuată: " . $conn->connect_error);
}
?>
