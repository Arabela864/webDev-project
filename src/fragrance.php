<?php include "includes/header.php"; ?>
<?php
require_once 'includes/db.php';
require_once 'classes/Perfume.php';

$model          = new PerfumeModel($conn);
$fragranceType  = $_GET['type'] ?? 'Floral';
$perfumes       = $model->getPerfumesByCategory('fragrance', $fragranceType);

// all possible fragrance options
$fragrances = ['Floral','Citrus','Woody','Fresh','Musk','Herbal','Amber','Gourmand'];
?>
<section class="py-5">
  <div class="container">
    <div class="row">
      <!-- Page Title -->
      <div class="col-12 col-md-8 col-lg-9">
        <h2 class="section-title mb-4">
          Perfumes by Fragrance: <?= htmlspecialchars($fragranceType) ?>
        </h2>
      </div>

      <!-- Sidebar Filter -->
      <aside class="col-sm-12 col-md-3 mb-4">
        <div class="card border-0 shadow-sm filter-card">
          <h5 class="mb-3">Filter by Fragrance</h5>
          <div class="list-group">
            <?php foreach ($fragrances as $f): ?>
              <a href="?type=<?= urlencode($f) ?>"
                 class="list-group-item list-group-item-action <?= $f === $fragranceType ? 'active' : '' ?>">
                <?= htmlspecialchars($f) ?>
              </a>
            <?php endforeach; ?>
          </div>
        </div>
      </aside>

      <!-- Products Grid -->
      <?php if ($perfumes->num_rows === 0): ?>
        <div class="col-12">
          <div class="alert alert-info">Niciun parfum disponibil.</div>
        </div>
      <?php else: ?>
        <?php while ($p = $perfumes->fetch_assoc()): ?>
          <?php
            $img = !empty($p['image'])
                 ? 'uploads/' . htmlspecialchars($p['image'])
                 : '/media/noImage.png';
          ?>
          <div class="col-sm-12 col-md-3 col-lg-3">
            <div class="card h-100 border-0 shadow-sm">
              <img src="<?= $img ?>"
                   class="card-img-top"
                   alt="<?= htmlspecialchars($p['name']) ?>"
                   style="height:200px; object-fit:cover;">

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
        <?php endwhile; ?>
      <?php endif; ?>
    </div>
  </div>
</section>
<?php include "includes/footer.php"; ?>
