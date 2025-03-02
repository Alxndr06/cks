<?php
require_once '../../includes/header.php';
require_once '../../config/db_connect.php';

checkAdmin();

// On récupère les commandes pour l'utilisateur
$stmt = $pdo->prepare("
    SELECT orders.id, orders.user_id, users.username, orders.total_amount, orders.status, orders.created_at, orders.updated_at
    FROM orders
    JOIN users ON orders.user_id = users.id
");
$stmt->execute();
$orders = $stmt->fetchAll();

?>

<div id="main-part">
    <h2>Order list</h2>
    <table class="user-table">
        <tr>
            <th>ID</th>
            <th>User</th>
            <th>Total amount</th>
            <th>Status</th>
            <th>Created at</th>
            <th>Updated at</th>
            <?php if ($_SESSION['role'] === "admin"): ?>
                <th>Quick actions</th>
            <?php endif; ?>

        </tr>
        <?php foreach ($orders as $order): ?>
            <tr>
                <td><?= $order['id'] ?></td>
                <td><?= $order['username'] ?></td>
                <td><?= $order['total_amount'] ?> €</td>
                <td><?= $order['status'] ?> </td>
                <td><?= $order['created_at'] ?></td>
                <td><?= $order['updated_at'] ?></td>
                <?php if ($_SESSION['role'] === "admin"): ?>
                    <td>
                        <a href="edit_order.php?id=<?= $order['id'] ?>">🔎 Open</a><br>
                        <a href="edit_order.php?id=<?= $order['id'] ?>">✏️ Edit</a><br>
                        <a href="delete_order.php?id=<?= $order['id'] ?>" onclick="return confirm('Are you sure?')">🗑️ Delete</a>
                    </td>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
