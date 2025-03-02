<?php
require_once '../../includes/header.php';
require_once '../../config/db_connect.php';
checkAdmin();

$stmt = $pdo->prepare("SELECT * FROM products");
$stmt->execute();
$products = $stmt->fetchAll();
?>
    <div id="main-part">
        <h2>Stock management</h2>
        <table class="user-table">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Quantity available</th>
                <th>Access</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><?= $product['id'] ?></td>
                    <td><?= htmlspecialchars(ucfirst(strtolower($product['name']))) ?></td>
                    <td><?= htmlspecialchars($product['description']) ?></td>
                    <td><?=$product['price'] ?> €</td>
                    <td><?= ($product['stock_quantity']) ?></td>
                    <td><?php if (!$product['restricted']): ?>Unrestricted<?php else: ?>Restricted<?php endif; ?></td>
                    <?= productAdminActions($product) ?>
                </tr>
            <?php endforeach; ?>
        </table>
        <?= backupLink('admin_dashboard.php', '🔙back to admin dashboard'); ?>
    </div>

<?php require '../../includes/footer.php'; ?>