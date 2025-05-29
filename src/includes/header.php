<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Perfume Store</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <link rel="stylesheet" href="css/theme.css" />
    <link rel="stylesheet" href="css/styles.css" />
</head>

<body>
    <div id="page-wrapper">

        <section id="header">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h1>Perfume Store</h1>
                        <nav id="nav">
                            <a href="index.php">Home</a>
                            <a href="fragrance.php">By Fragrance</a>
                            <a href="size.php">By Size</a>
                            <a href="durability.php">By Durability</a>
                            <a href="shop.php">Shop</a>

                            <?php if (!isset($_SESSION['user_id'])): ?>
                                <!-- Guests see these -->
                                <a href="auth/login.php">Login</a>
                                <a href="auth/register.php">Register</a>

                            <?php else: ?>
                                <!-- Any logged-in user -->
                                <a href="my-order.php">My Order</a>

                                <?php if ($_SESSION['role'] === 'admin'): ?>
                                    <!-- Only admins -->
                                    <a href="admin/add-product.php">Add Product</a>
                                    <a href="orders.php">All Orders</a>
                                    <a href="admin/admin_orders.php">Dashboard</a>
                                    <a href="classes/manage-users.php">Manage Users</a>
                                <?php endif; ?>

                                <!-- Everyone signed in -->
                                <a href="auth/logout.php">Logout</a>
                            <?php endif; ?>
                        </nav>
                    </div>
                </div>
            </div>
        </section>

        <!-- …rest of page… -->