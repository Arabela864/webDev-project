<?php
session_start();
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "admin") {
    header("Location: login.php");
    exit();
}
require_once 'includes/db.php';

if (isset($_GET["delete"])) {
    $user_id = $_GET["delete"];
    $conn->query("DELETE FROM users WHERE id = $user_id");
    header("Location: manage-users.php");
}
?>

<h2>Utilizatori Înregistrați</h2>
<table border="1">
    <tr>
        <th>ID</th><th>Username</th><th>Email</th><th>Rol</th><th>Acțiune</th>
    </tr>
    <?php
    $result = $conn->query("SELECT id, username, email, role FROM users");
    while ($row = $result->fetch_assoc()):
    ?>
    <tr>
        <td><?= $row["id"] ?></td>
        <td><?= $row["username"] ?></td>
        <td><?= $row["email"] ?></td>
        <td><?= $row["role"] ?></td>
        <td><a href="manage-users.php?delete=<?= $row["id"] ?>" onclick="return confirm('Ștergi utilizatorul?')">Șterge</a></td>
    </tr>
    <?php endwhile; ?>
</table>
