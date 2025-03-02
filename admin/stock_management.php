<?php
require_once '../includes/header.php';

checkAdmin();
?>


    <div id="main-part">
        <h2>Stock management</h2>

        <?= backupLink('admin_dashboard.php', '🔙back to admin dashboard'); ?>
    </div>

<?php require '../includes/footer.php'; ?>