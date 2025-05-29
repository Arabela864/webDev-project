<?php
include_once("./../includes/db.php");
include_once("./backend/classes/DashboardStats.php");

header('Content-Type: application/json');

$keyword = $_GET['q'] ?? '';

$statsModel = new DashboardStats($conn);
if ($keyword !== '') {
    $perfumes = $statsModel->searchPerfumes($keyword);
} else {
    $res = $conn->query("SELECT * FROM perfumes ORDER BY id DESC");
    $perfumes = $res->fetch_all(MYSQLI_ASSOC);
}

echo json_encode($perfumes);
