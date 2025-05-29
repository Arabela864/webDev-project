<?php
session_start();
require_once "../includes/db.php";

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username      = trim($_POST['username'] ?? '');
    $password      = $_POST['password'] ?? '';
    $input_captcha = trim($_POST['captcha'] ?? '');
    $remember      = isset($_POST['remember']);

    if (
        $input_captcha === '' || !isset($_SESSION['captcha']) ||
        strcasecmp($input_captcha, $_SESSION['captcha']) !== 0
    ) {
        $error = 'Incorrect CAPTCHA code.';
    } elseif ($username === '' || $password === '') {
        $error = 'Please enter both username and password.';
    } else {
        $stmt = $conn->prepare("SELECT id, username, password, role FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res && $res->num_rows === 1) {
            $user = $res->fetch_assoc();

            if (password_verify($password, $user['password'])) {
                // Store in session
                $_SESSION['user_id']  = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role']     = $user['role'];

                // Remember-me cookies
                if ($remember) {
                    setcookie('user_id',  $user['id'],       time() + 86400 * 30, '/');
                    setcookie('username', $user['username'], time() + 86400 * 30, '/');
                    setcookie('role',     $user['role'],     time() + 86400 * 30, '/');
                }

                // Redirect based on role
                if ($_SESSION['role'] === 'admin') {
                    header("Location: ../admin/admin.php");
                } else {
                    header("Location: ../index.php");
                }
                exit;
            }
        }

        $error = 'Invalid username or password.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
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
                <h4 class="mb-4 text-center">Sign In</h4>

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
                        <label class="form-label">Password</label>
                        <input type="password"
                            name="password"
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

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input class="form-check-input"
                                type="checkbox"
                                name="remember"
                                id="remember" <?= isset($_POST['remember']) ? 'checked' : '' ?>>
                            <label class="form-check-label" for="remember">
                                Remember Me
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg w-100">Log In</button>
                </form>

                <p class="text-center mt-3 mb-0 small">
                    Don’t have an account?
                    <a href="./register.php">Register here</a>
                </p>
            </div>
        </div>
    </div>
</body>

</html>