<?php
require_once '../includes/header.php';

if (!isset($_SESSION['id']) || $_SESSION['role'] !== "admin") {
    header("Location: ../login.php");
    exit;
}
?>

<div id="main-part">
    <h2>Admin dashboard</h2>
    <div id="nav_dashboard">
        <li><a title="Users management" href="users_management.php">👮Users management</a></li>
        <li><a title="Stock management" href="stock_management.php">📋Stock management</a></li>
        <li><a title="Debts management" href="debts_management.php">💵Debts management</a></li>
    </div>
</div>


<?php require '../includes/footer.php'; ?>