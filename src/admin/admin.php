<?php


include_once("./../includes/db.php");
include_once("./backend/classes/DashboardStats.php");
include_once("./backend/classes/perfume.php");

$perfumeModel = new Perfume($conn);
$statsModel   = new DashboardStats($conn);

// fetch data
$totalPerfumes  = $perfumeModel->countAll();
$totalOrders    = $statsModel->countOrders();
$totalUsers     = $statsModel->countUsers();
$perfumeList    = $perfumeModel->getAll();

include_once('./include/header.php');
include_once('./include/sidebar.php');
?>

<main class="flex-grow-1 px-4 py-5">

  <!-- Metrics row -->
  <div class="row g-4 mb-5">
    <?php 
    $cards = [
      ['Perfumes','primary',$totalPerfumes,'fa-flask'],
      ['Orders','success',$totalOrders,'fa-shopping-cart'],
      ['Users','info',$totalUsers,'fa-users'],
    ];
    foreach ($cards as $c): ?>
      <div class="col-sm-6 col-lg-4">
        <div class="card text-white bg-<?= $c[1] ?> h-100">
          <div class="card-body d-flex align-items-center">
            <i class="fa <?= $c[3] ?> fa-2x me-3"></i>
            <div>
              <h5 class="card-title mb-1"><?= $c[0] ?></h5>
              <p class="display-6 mb-0"><?= $c[2] ?></p>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
<!-- Search input -->
<div class="d-flex justify-content-end mb-3">
  <input type="text" id="searchInput" class="form-control" style="width: 300px;" placeholder="Caută parfumuri..." onkeyup="searchPerfumes()">
</div>

  <!-- Perfumes table -->
  <div class="card shadow-sm">
    <div class="card-header bg-dark text-white">
      <h4 class="mb-0">All Perfumes</h4>
    </div>
    <div class="table-responsive">
      <table class="table table-striped table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th>#</th><th>Name</th><th>Description</th><th>Fragrance</th>
            <th>Size</th><th>Durability</th><th>Image</th><th>Created</th><th></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($perfumeList as $row): ?>
          <tr>
            <th scope="row"><?= $row['id'] ?></th>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['description']) ?></td>
            <td><?= htmlspecialchars($row['fragrance']) ?></td>
            <td><?= htmlspecialchars($row['size']) ?></td>
            <td><?= htmlspecialchars($row['durability']) ?></td>
            <td>
              <img src="../uploads/<?= htmlspecialchars($row['image']) ?>"
                   style="height:40px; border-radius:4px;" alt="">
            </td>
            <td><?= date('Y-m-d H:i', strtotime($row['created_at'])) ?></td>
            <td class="text-end">
              <a href="edit_perfume.php?id=<?= $row['id'] ?>" 
                 class="btn btn-sm btn-outline-primary me-1" 
                 title="Edit">
                <i class="fa fa-edit"></i>
              </a>
              <a href="delete_perfume.php?id=<?= $row['id'] ?>" 
                 class="btn btn-sm btn-outline-danger"
                 onclick="return confirm('Delete this perfume?')" 
                 title="Delete">
                <i class="fa fa-trash"></i>
              </a>
            </td>
          </tr>
          <?php endforeach; ?>

          <?php if (empty($perfumeList)): ?>
          <tr>
            <td colspan="9" class="text-center py-4">
              <em>No perfumes found.</em>
            </td>
          </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

</main>
<script>
function searchPerfumes() {
  const keyword = document.getElementById('searchInput').value;

  fetch('search_perfumes.php?q=' + encodeURIComponent(keyword))
    .then(response => response.json())
    .then(data => {
      const tbody = document.querySelector('table tbody');
      tbody.innerHTML = '';

      if (data.length === 0) {
        tbody.innerHTML = `<tr><td colspan="9" class="text-center py-4"><em>No perfumes found.</em></td></tr>`;
        return;
      }

      data.forEach(row => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
          <th scope="row">${row.id}</th>
          <td>${row.name}</td>
          <td>${row.description}</td>
          <td>${row.fragrance}</td>
          <td>${row.size}</td>
          <td>${row.durability}</td>
          <td><img src="../uploads/${row.image}" style="height:40px; border-radius:4px;" alt=""></td>
          <td>${new Date(row.created_at).toISOString().slice(0, 16).replace('T', ' ')}</td>
          <td class="text-end">
            <a href="edit_perfume.php?id=${row.id}" class="btn btn-sm btn-outline-primary me-1" title="Edit">
              <i class="fa fa-edit"></i>
            </a>
            <a href="delete_perfume.php?id=${row.id}" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this perfume?')" title="Delete">
              <i class="fa fa-trash"></i>
            </a>
          </td>
        `;
        tbody.appendChild(tr);
      });
    });
}
</script>

<?php include_once('./include/footer.php'); ?>
