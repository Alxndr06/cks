<?php
require_once '../includes/header.php';

checkConnect();
?>

    <div id="main-part">
        <h2>My profile</h2>
        <?= displayLockedMessage($isLocked); ?>
        <?= backupLink('dashboard.php', '🔙back to dashboard') ?>
    </div>

<?php include '../includes/footer.php'; ?>