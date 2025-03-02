<?php
require_once 'includes/header.php';
require_once 'config/db_connect.php';

$stmt = $pdo->prepare("SELECT id, name, description, price, stock_quantity FROM products");
$stmt->execute();
$products = $stmt->fetchAll();
?>

<div id="main-part">
    <h2>Snack list</h2>
    <?= displayLockedStatus(); ?>
    <table class="user-table">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Price</th>
            <th>Quantity available</th>
            <?php if (isset($_SESSION['id']) && (!$_SESSION['locked'])): ?>
            <th>Actions</th>
            <?php endif; ?>
        </tr>
        <?php foreach ($products as $product): ?>
            <tr>
                <td><?= $product['id'] ?></td>
                <td><?= htmlspecialchars(ucfirst(strtolower($product['name']))) ?></td>
                <td><?= htmlspecialchars($product['description']) ?></td>
                <td><?=$product['price'] ?> €</td>
                <td><?= ($product['stock_quantity']) ?></td>
                <?php if (isset($_SESSION['id']) && (!$_SESSION['locked'])): ?>
                    <td><a href="#">🛒 Order</a></td>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
    </table>

</div>

<?php require 'includes/footer.php'; ?>