  <!-- page‐specific content ends here -->
</main>
</div> <!-- /.d-flex -->

<footer class="bg-dark text-center text-white py-3 mt-auto">
  <div class="container">
    &copy; <?= date('Y') ?> Perfume Store. All Rights Reserved.
  </div>
</footer>

<!-- Bootstrap JS bundle (includes Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  // Toggle sidebar on mobile
  document.getElementById('sidebarToggle')?.addEventListener('click', function(){
    document.querySelector('.sidebar').classList.toggle('show');
  });
</script>
</body>
</html>
