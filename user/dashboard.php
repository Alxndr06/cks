<?php
require_once '../includes/header.php';

checkConnect();

?>

<div id="main-part">
    <h2>User dashboard</h2>
    <div id="user_resume">
        <?= displayLockedMessage($isLocked); ?>
        <p>Hello <?= $username ?>. <?php if (!$noteIsNull): ?>You owe <?= colorDebt($note) ?> € <?php else: ?> You have no debt <?php endif; ?>.</p>
    </div>
    <div id="nav_dashboard">
        <li><a title="My profile" href="profile.php">🙋‍♂️️My profile</a></li>
        <li><a title="Orders logs" href="order_logs.php">🧺My orders</a></li>
        <?php if (!$noteIsNull): ?><li><a title="Pay my bill" href="payment.php">💵Pay my bill</a></li><?php endif; ?>
    </div>
</div>

<?php require '../includes/footer.php'; ?>