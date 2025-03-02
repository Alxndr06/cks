<?php
require_once '../includes/header.php';
require_once '../config/config.php';

checkConnect();
?>

    <div id="main-part">
        <h2>My profile</h2>
        <?= displayLockedStatus() ?>
        <?= backupLink('dashboard.php', '🔙back to dashboard') ?>
    </div>

<?php include '../includes/footer.php'; ?>