<?php
require_once 'includes/header.php';
require_once 'config/db_connect.php';

$isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === "admin";

$query = "SELECT id, name, description, price, stock_quantity FROM products";
$query .= $isAdmin ? "" : " WHERE restricted = 0"; // Ajoute la condition seulement si ce n'est pas un admin

$stmt = $pdo->prepare($query);
$stmt->execute();
$products = $stmt->fetchAll();
?>

<div id="main-part">
    <h2>Snack shop</h2>
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
                <td>
                    <form>
                        <label for="quantity">Quantity :</label>
                        <input type="number" name="quantity" id="quantity" value="1">
                        <button>🛒 Order</button>
                    </form>
                </td>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
    </table>

</div>

<?php require 'includes/footer.php'; ?>