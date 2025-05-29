<?php

include_once("./../includes/db.php");

include_once("./backend/classes/perfume.php");

$model = new Perfume($conn);
$id    = (int)($_GET['id'] ?? 0);
$perfume = $model->getById($id);
if (!$perfume) {
    header('Location: manage_perfumes.php');
    exit;
}

$error = '';
$success = false;

// Handle submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
      'name'        => trim($_POST['name']),
      'description' => trim($_POST['description']),
      'fragrance'   => $_POST['fragrance'],
      'size'        => $_POST['size'],
      'durability'  => $_POST['durability'],
    ];

    // Optional image upload
    if (!empty($_FILES['image']['name']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $ext      = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $newName  = uniqid('perf_', true) . '.' . $ext;
        $target   = './../uploads/' . $newName;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            $data['image'] = $newName;
        } else {
            $error = 'Failed to upload new image.';
        }
    }

    if (!$error && $model->update($id, $data)) {
        $success = true;
        $perfume = $model->getById($id); // refresh
    } elseif (!$error) {
        $error = 'Database error updating perfume.';
    }
}

include_once('./include/header.php');
include_once('./include/sidebar.php');
?>

<main class="flex-grow-1 p-4">
  <h2 class="mb-4">Edit Perfume #<?= $perfume['id'] ?></h2>

  <?php if ($success): ?>
    <div class="alert alert-success">Updated successfully!</div>
  <?php elseif ($error): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>

  <form method="POST" enctype="multipart/form-data" class="card p-4 shadow-sm">
    <div class="mb-3">
      <label class="form-label">Name</label>
      <input type="text"
             name="name"
             class="form-control"
             required
             value="<?= htmlspecialchars($perfume['name']) ?>">
    </div>

    <div class="mb-3">
      <label class="form-label">Description</label>
      <textarea name="description"
                class="form-control"
                rows="3"
                required><?= htmlspecialchars($perfume['description']) ?></textarea>
    </div>

    <div class="row mb-3">
      <div class="col-md-4">
        <label class="form-label">Fragrance</label>
        <select name="fragrance" class="form-select" required>
          <?php foreach (['Floral','Citrus','Woody'] as $f): ?>
            <option <?= $perfume['fragrance']===$f ? 'selected':'' ?>><?= $f ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-md-4">
        <label class="form-label">Size</label>
        <select name="size" class="form-select" required>
          <?php foreach (['30ml','50ml','100ml'] as $s): ?>
            <option <?= $perfume['size']===$s ? 'selected':'' ?>><?= $s ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-md-4">
        <label class="form-label">Durability</label>
        <select name="durability" class="form-select" required>
          <?php foreach (['4h','8h','12h+'] as $d): ?>
            <option <?= $perfume['durability']===$d ? 'selected':'' ?>><?= $d ?></option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>

    <div class="mb-4">
      <label class="form-label">Current Image</label><br>
      <img src="../uploads/<?= htmlspecialchars($perfume['image']) ?>"
           style="height:80px; border-radius:4px;" alt="">
    </div>

    <div class="mb-4">
      <label class="form-label">Change Image (optional)</label>
      <input type="file" name="image" class="form-control" accept="image/*">
    </div>

    <button class="btn btn-primary"><i class="fa fa-save me-1"></i> Save Changes</button>
    <a href="manage_perfumes.php" class="btn btn-secondary ms-2">Cancel</a>
  </form>
</main>

<?php include_once('./include/footer.php'); ?>
