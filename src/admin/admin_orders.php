<?php


include_once("./../includes/db.php");

include_once("./backend/classes/OrderModel.php");

$orderModel = new OrderModel($conn);
$orders     = $orderModel->getAll();
$totalOrders= $orderModel->countAll();

include_once("./include/header.php");
include_once("./include/sidebar.php");
?>

<main class="flex-grow-1 px-4 py-5">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="m-0">All Orders</h2>
    <span class="badge bg-primary fs-5">
      Total: <?= $totalOrders ?>
    </span>
  </div>

  <?php if ($totalOrders): ?>
    <div class="card shadow-sm">
      <div class="table-responsive">
        <table class="table table-striped table-hover align-middle mb-0">
          <thead class="table-dark">
            <tr>
              <th>#</th>
              <th>User</th>
              <th>Product</th>
              <th>Quantity</th>
              <th>Date</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($orders as $o): ?>
              <tr>
                <th scope="row"><?= htmlspecialchars($o['id']) ?></th>
                <td><?= htmlspecialchars($o['username']) ?></td>
                <!-- <td><?= htmlspecialchars($o['product']) ?></td>
                <td><?= htmlspecialchars($o['quantity']) ?></td> -->
                <td>
  <?= isset($o['date']) && $o['date'] !== null
      ? date('Y-m-d H:i', strtotime($o['date']))
      : '-' ?>
</td>

              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  <?php else: ?>
    <div class="alert alert-info">No orders found.</div>
  <?php endif; ?>

</main>

<?php include_once("./../includes/db.php"); ?>
