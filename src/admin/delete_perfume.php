<?php

include_once("./../includes/db.php");

include_once("./backend/classes/perfume.php");

$model = new Perfume($conn);
$id    = (int)($_GET['id'] ?? 0);

if ($id > 0 && $model->delete($id)) {
    header('Location: ./admin.php?deleted=1');
} else {
    header('Location: ./admin.php?error=delete');
}
exit;
