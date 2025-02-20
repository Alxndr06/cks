<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/functions.php';
?>
<!--DEBUT DE PAGE HTML-->
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <script src="../assets/js/script.js" defer></script>
    <title>Cks V0.5</title>
</head>
<body>
<!--HEADER-->
<header>
    <h1>Cks App v0.5</h1>
    <?php if ($isLoggedIn): ?>
    <a id="disconnect_button" title="Disconnect" href="<?= $base_url ?>logout.php">Disconnect (<?php echo $username ?>)</a>
    <?php else: ?>
    <a id="connect_button" title=Connect" href="<?= $base_url ?>logout.php">Connect</a>
    <?php endif; ?>
</header>
<!--BARRE DE NAVIGATION-->
<nav id="navbar-header">
    <ul>
        <li><a title="Home" href="<?= $base_url ?>index.php">Home</a></li>
        <li><a title="Snack shop" href="<?= $base_url ?>snacks_list.php">Buy a snack</a></li>
        <li><a title="User dashboard" href="<?= $base_url ?>user/dashboard.php">Dashboard</a> </li>
        <?php if ($isLoggedIn && $isAdmin): ?>
        <li><a title="Admin dashboard" href="<?= $base_url ?>admin/admin_dashboard.php">Admin</a> </li>
        <?php endif; ?>
    </ul>
</nav>



