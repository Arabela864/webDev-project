<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
    if (!($_SESSION['user_id'] ?? false) || ($_SESSION['role'] ?? '') !== 'admin') {
        header('Location: ../auth/login.php');
        exit;
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Admin - Perfume Store</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS + FontAwesome for icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            min-height: 100vh;
        }

        .sidebar {
            width: 220px;
        }

        @media (max-width: 767px) {
            .sidebar {
                position: fixed;
                z-index: 1000;
                left: -220px;
                top: 0;
                height: 100%;
                transition: .3s;
            }

            .sidebar.show {
                left: 0;
            }
        }
    </style>
</head>

<body class="d-flex flex-column">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <button class="btn btn-outline-light d-lg-none me-2" id="sidebarToggle">
                <i class="fa fa-bars"></i>
            </button>
            <a class="navbar-brand" href="../admin/admin.php">Perfume Store Admin</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <?php if (isset($_SESSION['username'])): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userMenu" role="button"
                                data-bs-toggle="dropdown"><?= htmlspecialchars($_SESSION['username']) ?></a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
                                <li><a class="dropdown-item" href="../auth/logout.php"><i class="fa fa-sign-out-alt me-1"></i> Logout</a></li>
                            </ul>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="d-flex flex-grow-1">