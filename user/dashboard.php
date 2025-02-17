<?php
require_once '../includes/header.php';

//Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['id'])) {
    header("Location: ../login.php");
    exit;
}
?>

<div id="main-part">
    <h2>User dashboard</h2>
    <div id="user_resume">
        <p>Welcome <?= $username ?>. You owe <?= colorDebt($note) ?> €.</p>
        <p>Role : <?= $role ?></p>
    </div>
    <div id="nav_dashboard">
        <li><a title="My profile" href="user_infos.php">🙋‍♂️️My profile</a></li>
        <li><a title="Orders logs" href="order_logs.php">🧺My orders</a></li>
        <li><a title="Pay my bill" href="#">💵Pay my bill</a></li>
    </div>

</div>

<?php require '../includes/footer.php'; ?>