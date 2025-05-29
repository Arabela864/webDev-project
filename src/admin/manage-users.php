<?php
include_once("./../includes/db.php");

include_once("./backend/classes/UserModel.php");

$model = new UserModel($conn);

// Handle deletion if requested
if (isset($_GET['delete_id'])) {
    $id = (int)$_GET['delete_id'];
    $model->delete($id);
    header('Location: ./manage_users.php?deleted=1');
    exit;
}

$users = $model->getAllRegular();

include_once("./include/header.php");
include_once("./include/sidebar.php");
?>

<main class="flex-grow-1 p-4">
  <h2 class="mb-4">Manage Users</h2>

  <?php if (isset($_GET['deleted'])): ?>
    <div class="alert alert-success">User deleted successfully.</div>
  <?php endif; ?>

  <?php if (count($users)): ?>
    <div class="table-responsive">
      <table class="table table-striped table-hover align-middle">
        <thead class="table-light">
          <tr>
            <th>#</th>
            <th>Username</th>
            <th>Email</th>
            <th>Joined</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($users as $u): ?>
            <tr>
              <th scope="row"><?= htmlspecialchars($u['id']) ?></th>
              <td><?= htmlspecialchars($u['username']) ?></td>
              <td><?= htmlspecialchars($u['email']) ?></td>
              <td><?= htmlspecialchars(date('Y-m-d H:i', strtotime($u['created_at']))) ?></td>
              <td class="text-end">
                <a href="manage_users.php?delete_id=<?= $u['id'] ?>"
                   class="btn btn-sm btn-outline-danger"
                   onclick="return confirm('Delete user <?= htmlspecialchars($u['username']) ?>?')">
                  <i class="fa fa-trash"></i>
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <div class="alert alert-info">No regular users found.</div>
  <?php endif; ?>
</main>

<?php include_once("./../includes/db.php"); ?>
