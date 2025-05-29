<?php include "includes/header.php";?>

<section id="content">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2>Welcome to the Perfume Store</h2>
                <p>Find the perfect scent for any occasion.</p>
            </div>
        </div>
    </div>
</section>

<!-- Secțiune video și audio -->
<?php include __DIR__ . '/media/video.php'; ?>

<!-- Secțiune hartă Google fără API -->
<section class="container my-5">
    <h3 class="text-center">Găsește-ne pe hartă</h3>
    <div class="d-flex justify-content-center">
        <iframe 
            src="https://www.google.com/maps?q=Universitatea+Alexandru+Ioan+Cuza+din+Iași&output=embed"
            width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
            referrerpolicy="no-referrer-when-downgrade">
        </iframe>
    </div>
</section>

<?php include "includes/footer.php";?>
