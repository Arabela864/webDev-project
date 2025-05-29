<?php include "./includes/header.php"; ?>
<?php

include_once("./includes/db.php");
include_once("./classes/OrderModel.php");
$model  = new OrderModel($conn);
$orders = $model->getByUser($_SESSION['user_id']);

?>



<section id="content">
    <div class="container">
        <h2 class="section-title">Comenzile mele</h2>

        <?php if (empty($orders)): ?>
            <p class="no-orders">Nu aveți comenzi înregistrate.</p>
        <?php else: ?>
            <div class="table-wrap">
                <table class="orders-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Parfum</th>
                            <th>Cantitate</th>
                            <th>Dată</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $row): ?>
                            <tr>
                                <td data-label="ID"><?= htmlspecialchars($row['order_id']) ?></td>
                                <td data-label="Parfum"><?= htmlspecialchars($row['product']) ?></td>
                                <td data-label="Cantitate"><?= htmlspecialchars($row['quantity']) ?></td>
                                <td data-label="Dată">
                                    <?= htmlspecialchars(date('Y-m-d H:i', strtotime($row['date']))) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>


    <?php include "includes/footer.php"; ?>