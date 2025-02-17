<?php
require_once '../includes/header.php';

if (!isset($_SESSION['id'])) {
    header("Location: ../login.php");
    exit;
}

?>

    <div id="main-part">
        <h2>My order history</h2>
    </div>

<?php include '../includes/footer.php'; ?>