<?php
require_once '../includes/header.php';
require_once '../config/db_connect.php';

if (!isset($_SESSION['id']) || $_SESSION['role'] !== "admin") {
    header("Location: ../login.php");
    exit;
}

//Récupération de la liste des utilisateurs
$stmt = $pdo->query("SELECT id, username, email, note, role FROM users");
$users = $stmt->fetchAll();
?>

<div id="main-part">
    <h2>Users list</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Note</th>
            <th>Role</th>
            <?php if ($_SESSION['role'] === "admin"): ?>
                <th>Actions</th>
            <?php endif; ?>

        </tr>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= $user['id'] ?></td>
                <td><?= htmlspecialchars($user['username']) ?></td>
                <td><?= htmlspecialchars($user['email']) ?></td>
                <td><?= colorDebt($user['note']) ?> €</td>
                <td><?= $role ?></td>
                <?php if ($_SESSION['role'] === "admin"): ?>
                    <td><a href="#">🔎infos</a></td>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
    </table>
</div>


<?php require '../includes/footer.php'; ?><?php
