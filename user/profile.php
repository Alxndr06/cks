<?php
require_once '../includes/header.php';
require_once '../config/config.php';

checkConnect();
?>

    <div id="main-part">
        <h2>My profile</h2>
        <?= displayLockedStatus() ?>
        <ul id="nav_dashboard">
            <li><a title="Change username" href="#">Change username</a></li>
            <li><a title="Change password" href="#">Change password</a></li>
            <li><a title="Delete my account" href="#">Delete my account</a></li>
        </ul>
        <?= backupLink('dashboard.php', '🔙back to dashboard') ?>
    </div>

<?php include '../includes/footer.php'; ?>