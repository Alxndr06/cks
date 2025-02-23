<?php
require_once '../../includes/header.php';
require_once '../../config/db_connect.php';

checkAdmin();

//Récupération de la liste des utilisateurs
$stmt = $pdo->query("SELECT id, username, email, note, role, locked FROM users");
$users = $stmt->fetchAll();
?>

<div id="main-part">
    <h2>User list</h2>
    <table class="user-table">
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Note</th>
            <th>Role</th>
            <th>Status</th>
            <?php if ($_SESSION['role'] === "admin"): ?>
                <th>Actions</th>
            <?php endif; ?>

        </tr>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= $user['id'] ?></td>
                <td><?= htmlspecialchars(ucfirst(strtolower($user['username']))) ?></td>
                <td><?= htmlspecialchars($user['email']) ?></td>
                <td><?= colorDebt($user['note']) ?> €</td>
                <td><?= htmlspecialchars(ucfirst(strtolower($user['role']))) ?></td>
                <td><?php if (!$user['locked']): ?>Active<?php else: ?>Locked<?php endif; ?></td>
                <?php if ($_SESSION['role'] === "admin"): ?>
                <td><a href="user_details.php?id=<?= $user['id'] ?>">🔎open</a> | <a href="edit_user.php?id=<?= $user['id'] ?>">✏️edit</a> | <a href="bill_user.php?id=<?= $user['id'] ?>">💲bill</a></td>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
    </table>
    <a title="Create a new user" href="add_user.php">➕Create new user</a>
</div>


<?php require '../../includes/footer.php'; ?>
