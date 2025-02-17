<?php
require_once '../includes/header.php';

if (!isset($_SESSION['id']) || $_SESSION['role'] !== "admin") {
    header("Location: ../login.php");
    exit;
}
?>


    <div id="main-part">
        <h2>Debts management</h2>
    </div>

<?php require '../includes/footer.php'; ?>