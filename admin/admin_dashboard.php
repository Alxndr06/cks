<?php
require_once '../includes/header.php';
checkAdmin();
?>

<div id="main-part">
    <h2>Admin dashboard</h2>
    <div id="nav_dashboard">
        <li><a title="News manager" href="#">📰News management</a></li>
        <li><a title="Users management" href="users/user_management.php">👮User management</a></li>
        <li><a title="Stock management" href="stock/stock_management.php">📋Stock management</a></li>
        <li><a title="Debts management" href="users/debts_management.php">💵Debts management</a></li>
        <li><a title="Order management" href="orders/order_management.php">📜Order management</a></li>
        <li><a title="Server logs" href="logs.php">📜Server logs</a></li>
    </div>
</div>


<?php require '../includes/footer.php'; ?>