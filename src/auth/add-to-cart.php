<?php
// auth/add-to-cart.php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

include_once("./../includes/db.php");
include_once("./../classes/OrderModel.php");

$model = new OrderModel($conn);

$userId    = $_SESSION['user_id'];
$perfumeId = (int)($_POST['perfume_id'] ?? 0);
$quantity  = max(1, (int)($_POST['quantity'] ?? 1));

if ($perfumeId > 0) {
    if ($model->add($userId, $perfumeId, $quantity)) {
        $_SESSION['flash_success'] = 'Added to cart!';
    } else {
        $_SESSION['flash_error']   = 'Could not add to cart. Please try again.';
    }
}

header('Location: ../shop.php'); 
exit;
