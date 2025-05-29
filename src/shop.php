<?php include "includes/header.php"; ?>
<?php
require_once 'includes/db.php';
include_once("./classes/Perfume.php");
$model    = new PerfumeModel($conn);
$perfumes = $model->getAll();

?>



<section id="content">
    <div class="container py-5">
        <h2 class="mb-4">Parfumuri Disponibile</h2>
        <?php if (!empty($_SESSION['flash_success'])): ?>
            <div class="alert alert-success">
                <?= htmlspecialchars($_SESSION['flash_success']) ?>
            </div>
            <?php unset($_SESSION['flash_success']); ?>
        <?php endif; ?>

        <?php if (!empty($_SESSION['flash_error'])): ?>
            <div class="alert alert-danger">
                <?= htmlspecialchars($_SESSION['flash_error']) ?>
            </div>
            <?php unset($_SESSION['flash_error']); ?>
        <?php endif; ?>

        <div class="row g-4">
            <?php foreach ($perfumes as $p): ?>
                <?php
                // pick actual image or fallback
                $img = !empty($p['image'])
                    ? 'uploads/' . htmlspecialchars($p['image'])
                    : '/media/noImage.png';
                ?>
                <div class="col-sm-12 col-md-3 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm">
                        <img src="<?= $img ?>"
                            class="card-img-top"
                            alt="<?= htmlspecialchars($p['name']) ?>">

                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?= htmlspecialchars($p['name']) ?></h5>
                            <p class="card-text text-muted small mb-2">
                                <?= htmlspecialchars($p['description']) ?>
                            </p>
                            <div class="mb-3">
                                <span class="badge bg-secondary me-1"><?= htmlspecialchars($p['size']) ?></span>
                                <span class="badge bg-secondary"><?= htmlspecialchars($p['durability']) ?></span>
                            </div>

                            <form method="POST"
                                action="auth/add-to-cart.php"
                                class="mt-auto d-flex">
                                <input type="hidden" name="perfume_id" value="<?= $p['id'] ?>">
                                <input type="number"
                                    name="quantity"
                                    min="1"
                                    value="1"
                                    class="form-control form-control-sm me-2"
                                    style="width:70px;">
                                <button type="submit" class="btn btn-sm btn-primary">
                                    <i class="fa fa-shopping-cart me-1"></i> Add
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

            <?php if (empty($perfumes)): ?>
                <div class="col-12">
                    <div class="alert alert-info">Niciun parfum disponibil.</div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php include "includes/footer.php"; ?>