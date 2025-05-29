<?php include "includes/header.php"; ?>
<?php
require_once 'includes/db.php';
include_once("./classes/Perfume.php");

$model    = new PerfumeModel($conn);
$durationType = $_GET['duration'] ?? '8 hours';
$perfumes     = $model->getPerfumesByCategory('durability', $durationType);

// all possible durability options
$durabilities = [
    '4 hours',
    '5 hours',
    '6 hours',
    '7 hours',
    '8 hours',
    '10 hours',
    '12 hours',
    '12+ hours'
];
?>

<section class="py-5">
    <div class="container">
        <div class="row">
             <div class="col-12 col-md-8 col-lg-9">
                <h2 class="section-title mb-4">
                    Perfumes by Durability: <?= htmlspecialchars($durationType) ?>
                </h2>
            </div>
            <!-- Sidebar Filter -->
            <aside class="col-sm-12 col-md-3 ">
                <div class="card border-0 shadow-sm filter-pad">
                    <h5 class="mb-3">Filter by Durability</h5>
                    <div class="list-group">
                        <?php foreach ($durabilities as $d): ?>
                            <a
                                href="?duration=<?= urlencode($d) ?>"
                                class="list-group-item list-group-item-action <?= $d === $durationType ? 'active' : '' ?>">
                                <?= htmlspecialchars($d) ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </aside>
             <?php if ($perfumes->num_rows === 0): ?>
                    <div class="alert alert-info">Niciun parfum disponibil.</div>
                <?php else: ?>
                  
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
                    
                <?php endif; ?>
           
        </div>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>