<?php
session_start();
require_once "../includes/db.php";

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1) Grab & sanitize
    $username       = trim($_POST['username'] ?? '');
    $email          = trim($_POST['email'] ?? '');
    $password       = $_POST['password'] ?? '';
    $password_conf  = $_POST['password_confirm'] ?? '';
    $input_captcha  = trim($_POST['captcha'] ?? '');

    // 2) Validate
    if ($username === '' || $email === '' || $password === '' || $password_conf === '' || $input_captcha === '') {
        $error = 'All fields are required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } elseif ($password !== $password_conf) {
        $error = 'Passwords do not match.';
    } elseif (
        !isset($_SESSION['captcha']) ||
        strcasecmp($input_captcha, $_SESSION['captcha']) !== 0
    ) {
        $error = 'Incorrect CAPTCHA.';
    } else {
        // 3) Hash & insert
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $conn->prepare("
            INSERT INTO users (username, email, password)
            VALUES (?, ?, ?)
        ");
        $stmt->bind_param("sss", $username, $email, $hash);

        if ($stmt->execute()) {
            unset($_SESSION['captcha']);
            header("Location: login.php?registered=1");
            exit;
        } else {
            // if duplicate key on username or email
            $error = 'Registration failed. Username or email may already exist.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f5f7fa;
        }

        .card {
            border: none;
            border-radius: 1rem;
        }

        .logo {
            font-size: 2rem;
            font-weight: bold;
            color: #007bff;
            text-decoration: none;
        }
    </style>
</head>

<body class="d-flex align-items-center justify-content-center" style="min-height:100vh;">
    <div class="w-100" style="max-width: 400px;">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <h4 class="mb-4 text-center">Create Account</h4>

                <?php if ($error): ?>
                    <div class="alert alert-danger small mb-3"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>

                <form method="post" novalidate>
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text"
                            name="username"
                            class="form-control form-control-lg"
                            required
                            value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email"
                            name="email"
                            class="form-control form-control-lg"
                            required
                            value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password"
                            name="password"
                            class="form-control form-control-lg"
                            required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Confirm Password</label>
                        <input type="password"
                            name="password_confirm"
                            class="form-control form-control-lg"
                            required>
                    </div>

                    <div class="mb-3 text-center">
                        <img src="./captcha.php?rand=<?= time() ?>"
                            alt="CAPTCHA"
                            class="mb-2"
                            style="border:1px solid #ccc; border-radius:4px;">
                        <input type="text"
                            name="captcha"
                            class="form-control form-control-lg"
                            placeholder="Enter CAPTCHA"
                            required>
                    </div>

                    <button type="submit" class="btn btn-success btn-lg w-100">Register</button>
                </form>

                <p class="text-center mt-3 mb-0 small">
                    Already have an account?
                    <a href="./login.php">Log in here</a>
                </p>
            </div>
        </div>
    </div>
</body>

</html>