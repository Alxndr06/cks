<?php
require_once '../../includes/header.php';
require_once '../../config/db_connect.php';
checkAdmin();

if (!isset($_GET['id'])) die('Unknown product');

$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch();

if(!$product) die('Unknown product');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock_quantity = $_POST['stock_quantity'];
    $restricted = $_POST['restricted'];

    $stmt = $pdo->prepare("UPDATE products SET name = ?, description = ?, price = ?, stock_quantity = ?, restricted = ? WHERE id = ?");
    if ($stmt->execute([$name, $description, $price, $stock_quantity, $restricted, $id])) {
        header("location: stock_management.php");
        exit;
    } else {
        echo '<div class="error_message">Error when updating the product</div>';
    }

}

?>

<div id="main-part">
    <h2>Edit product</h2>
    <form method="POST">
    <label for="name">Product name :</label>
    <input type="text" id="name" name="name" value="<?= htmlspecialchars($product['name']) ?>"><br><br>
    <label for="description">Description :</label>
    <input type="text" id="description" name="description" value="<?= htmlspecialchars($product['description']) ?>"><br><br>
    <label for="price">Price :</label>
    <input type="number" id="price" name="price" value="<?= htmlspecialchars($product['price']) ?>"><br><br>
    <label for="stock_quantity">Stock quantity :</label>
    <input type="number" id="stock_quantity" name="stock_quantity" value="<?= htmlspecialchars($product['stock_quantity']) ?>"><br><br>
        <select name="restricted" id="restricted" required>
            <option value="0">Unrestricted</option>
            <option value="1">Restricted</option>
        </select><br><br>
        <button type="submit">Edit product</button><br><br>
    </form>
    <?= backupLink("stock_management.php?id=$id", '🔙back to product list'); ?>
</div>

<?php require '../../includes/footer.php'; ?>
