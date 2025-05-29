<?php
$mysqli = new mysqli("localhost", "root", "", "perfume_store");

if ($mysqli->connect_error) {
    die("Eroare conexiune: " . $mysqli->connect_error);
}

$sql = file_get_contents("perfume_store.sql");

if ($mysqli->multi_query($sql)) {
    echo "Baza de date și tabelele au fost create!";
} else {
    echo "Eroare SQL: " . $mysqli->error;
}
?>
