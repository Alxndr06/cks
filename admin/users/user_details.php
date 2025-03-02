<?php
require_once '../../includes/header.php';
require_once '../../config/db_connect.php';

checkAdmin();

// Récupération des informations de l'utilisateur
if (!isset($_GET['id'])) die("Unknown user");
$id = $_GET['id'];

//On récupére l'utilisateur
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$id]);
$user = $stmt->fetch();

if (!$user) die("Unknown user");

?>

<div id="main-part">
    <h2><?= htmlspecialchars(strtoupper($user['username'])) ?></h2>
    <?php if ($user['locked'] == 1) : ?>
    <p class="alert">USER LOCKED</p>
    <?php endif; ?>
    <table class="user-table-vertical">
        <tr>
            <th>LASTNAME</th>
            <td><?= htmlspecialchars(ucfirst(strtolower($user['lastname']))) ?></td>
        </tr>
        <tr>
            <th>FIRSTNAME</th>
            <td><?= htmlspecialchars(ucfirst(strtolower($user['firstname']))) ?></td>
        </tr>
        <tr>
            <th>MAIL</th>
            <td><?= htmlspecialchars($user['email']) ?></td>
        </tr>
        <tr>
            <th>ROLE</th>
            <td><?= htmlspecialchars(ucfirst(strtolower($user['role']))) ?></td>
        </tr>
        <tr>
            <th>CREATED</th>
            <td><?= date("d/m/Y", strtotime($user['created_at'])) ?></td>
        </tr>
        <tr>
            <th>DEBT</th>
            <td><?= colorDebt($user['note']) ?> €</td>
        </tr>
        <tr>
            <th>LAST PAYMENT</th>
            <td>available soon</td>
        </tr>
        <tr>
            <th>TOTAL SPENT</th>
            <td>available soon</td>
        </tr>
    </table>
    <?= AdvancedAdminActions($user) ?>
    <br><br>
    <?= backupLink('user_list.php','🔙back to list'); ?>
</div>

<?php require '../../includes/footer.php'; ?>