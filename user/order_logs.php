<?php
require_once '../includes/header.php';

checkConnect();

?>

    <div id="main-part">
        <h2>My order history</h2>

        <?= backupLink('dashboard.php', '🔙back to dashboard') ?>
    </div>

<?php include '../includes/footer.php'; ?>