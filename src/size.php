<?php include "includes/header.php"; ?>
<?php
require_once 'includes/db.php';
require_once 'classes/Perfume.php';

$model     = new PerfumeModel($conn);
$sizeType  = $_GET['size'] ?? '50ml';
$perfumes  = $model->getPerfumesByCategory('size', $sizeType);

// all possible size options
$sizes = ['30ml','50ml','75ml','100ml'];
?>
<section class="py-5">
  <div class="container">
    <div class="row">
      <!-- Heading -->
      <div class="col-12 col-md-8 col-lg-9">
        <h2 class="section-title mb-4">
          Perfumes by Size: <?= htmlspecialchars($sizeType) ?>
        </h2>
      </div>

      <!-- Sidebar Filter -->
      <aside class="col-sm-12 col-md-3">
        <div class="card border-0 shadow-sm filter-pad">
          <h5 class="mb-3">Filter by Size</h5>
          <div class="list-group">
            <?php foreach ($sizes as $s): ?>
              <a
                href="?size=<?= urlencode($s) ?>"
                class="list-group-item list-group-item-action <?= $s === $sizeType ? 'active' : '' ?>">
                <?= htmlspecialchars($s) ?>
              </a>
            <?php endforeach; ?>
          </div>
        </div>
      </aside>

      <!-- Products Grid -->
      <?php if ($perfumes->num_rows === 0): ?>
        <div class="alert alert-info">Niciun parfum disponibil.</div>
      <?php else: ?>
        <?php while ($p = $perfumes->fetch_assoc()): ?>
          <?php
            $img = !empty($p['image'])
               ? 'uploads/' . htmlspecialchars($p['image'])
               : '/media/noImage.png';
          ?>
          <div class="col-sm-12 col-md-3 col-lg-3">
            <div class="card h-100 border-0 shadow-sm">
              <img
                src="<?= $img ?>"
                class="card-img-top"
                alt="<?= htmlspecialchars($p['name']) ?>"
                style="height:200px;object-fit:cover;">
              <div class="card-body d-flex flex-column">
                <h5 class="card-title"><?= htmlspecialchars($p['name']) ?></h5>
                <p class="card-text text-muted small mb-2">
                  <?= htmlspecialchars($p['description']) ?>
                </p>
                <div class="mb-3">
                  <span class="badge bg-secondary me-1"><?= htmlspecialchars($p['size']) ?></span>
                  <span class="badge bg-secondary"><?= htmlspecialchars($p['durability']) ?></span>
                </div>
                <form
                  method="POST"
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
        <?php endwhile; ?>
      <?php endif; ?>
    </div>
  </div>
</section>
<?php include "includes/footer.php"; ?>
