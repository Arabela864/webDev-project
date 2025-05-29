<?php

include_once("./../includes/db.php");

include_once("./backend/classes/perfume.php");
// instantiate model
$perfumeModel = new Perfume($conn);

$error   = '';
$success = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1) Validate & sanitize form fields
    $name        = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $category    = trim($_POST['category'] ?? '');
    $size    = trim($_POST['size'] ?? '');
 $durability    = trim($_POST['durability'] ?? '');
    if (!$name || !$description || !$category) {
        $error = 'All text fields are required.';
    }
    // 2) Handle upload
    elseif (empty($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        $error = 'Please choose an image to upload.';
    } else {
        // save file
        $ext      = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $filename = uniqid('perf_', true) . ".{$ext}";
        $dest     =  './../uploads/' . $filename;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $dest)) {
            // 3) Call the class method (DB logic lives there)
            $success = $perfumeModel->create([
                'name'        => $name,
                'description' => $description,
                'category'    => $category,
                'image'       => $filename,
                'size'        => $size,
                'durability'  => $durability
            ]);

            if (!$success) {
                $error = 'DB error: ' . $conn->error;
            }
        } else {
            $error = 'Upload failed.';
        }
    }
}

include_once("./include/header.php");
include_once("./include/sidebar.php");
?>

<main class="flex-grow-1 p-4">
    <h2 class="mb-4">Add New Perfume</h2>

    <?php if ($success): ?>
        <div class="alert alert-success">Perfume added successfully!</div>
    <?php elseif ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data" class="card p-4 shadow-sm">
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input name="name"
                class="form-control"
                required
                value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description"
                class="form-control"
                rows="3"
                required><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <label class="form-label">Category</label>
                <select name="category" class="form-select" required>
                    <option value="">— Select —</option>
                    <option <?= (($_POST['category'] ?? '') === 'Floral') ? 'selected' : '' ?>>Floral</option>
                    <option <?= (($_POST['category'] ?? '') === 'Citrus') ? 'selected' : '' ?>>Citrus</option>
                    <option <?= (($_POST['category'] ?? '') === 'Woody') ? 'selected' : '' ?>>Woody</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Size</label>
                <select name="size" class="form-select" required>
                    <option value="">— Select —</option>
                    <option <?= (($_POST['size'] ?? '') === '30ml') ? 'selected' : '' ?>>30ml</option>
                    <option <?= (($_POST['size'] ?? '') === '50ml') ? 'selected' : '' ?>>50ml</option>
                    <option <?= (($_POST['size'] ?? '') === '75ml') ? 'selected' : '' ?>>75ml</option>
                    <option <?= (($_POST['size'] ?? '') === '100ml') ? 'selected' : '' ?>>100ml</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Durability</label>
                <select name="durability" class="form-select" required>
                    <option value="">— Select —</option>
                    <option <?= (($_POST['durability'] ?? '') === '4 hours') ? 'selected' : '' ?>>4 hours</option>
                    <option <?= (($_POST['durability'] ?? '') === '6 hours') ? 'selected' : '' ?>>6 hours</option>
                    <option <?= (($_POST['durability'] ?? '') === '8 hours') ? 'selected' : '' ?>>8 hours</option>
                    <option <?= (($_POST['durability'] ?? '') === '12+ hours') ? 'selected' : '' ?>>12+ hours</option>
                </select>
            </div>
        </div>

        <div class="mb-4">
            <label class="form-label">Image</label>
            <input type="file"
                name="image"
                class="form-control"
                accept="image/*"
                required>
        </div>

        <button class="btn btn-primary">
            <i class="fa fa-plus-circle me-1"></i> Add Perfume
        </button>
    </form>

</main>

<?php
include_once("./../includes/db.php");
?>