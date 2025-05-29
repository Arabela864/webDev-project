<section id="footer">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2>Welcome to the Perfume Store</h2>
                <p>Find the perfect scent for any occasion.</p>
            </div>
        </div>

        <!-- 🔗 Social Media Buttons -->
        <div class="row text-center mt-4">
            <div class="col">
                <h5>Urmărește-ne</h5>
                <a href="https://facebook.com" target="_blank" class="btn btn-outline-primary btn-sm mx-1">Facebook</a>
                <a href="https://instagram.com" target="_blank" class="btn btn-outline-danger btn-sm mx-1">Instagram</a>
                <a href="https://twitter.com" target="_blank" class="btn btn-outline-info btn-sm mx-1">Twitter</a>
            </div>
        </div>

        <!-- 💬 Comment Form -->
        <div class="row justify-content-center mt-4">
            <div class="col-md-6">
                <h5 class="text-center">Lasă un comentariu</h5>
                <?php
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['send_comment'])) {
                    $to = "youremail@example.com"; // ← înlocuiește cu adresa ta reală
                    $subject = "Comentariu nou de pe site";
                    $message = "Nume: " . htmlspecialchars($_POST['name']) . "\\n";
                    $message .= "Email: " . htmlspecialchars($_POST['email']) . "\\n";
                    $message .= "Comentariu:\\n" . htmlspecialchars($_POST['comment']);
                    $headers = "From: " . htmlspecialchars($_POST['email']);

                    if (mail($to, $subject, $message, $headers)) {
                        echo "<p class='text-success text-center'>Comentariul a fost trimis cu succes!</p>";
                    } else {
                        echo "<p class='text-danger text-center'>Eroare la trimiterea comentariului.</p>";
                    }
                }
                ?>
                <form method="post" action="#footer">
                    <div class="mb-2">
                        <input type="text" name="name" class="form-control" placeholder="Numele tău" required>
                    </div>
                    <div class="mb-2">
                        <input type="email" name="email" class="form-control" placeholder="Emailul tău" required>
                    </div>
                    <div class="mb-2">
                        <textarea name="comment" class="form-control" rows="3" placeholder="Comentariul tău" required></textarea>
                    </div>
                    <button type="submit" name="send_comment" class="btn btn-primary w-100">Trimite</button>
                </form>
            </div>
        </div>
    </div>
</section>

<section id="copyright">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <p>&copy; 2025 Perfume Store. All rights reserved.</p>
            </div>
        </div>
    </div>
</section>
</div>

</body>
</html>
