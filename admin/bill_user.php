<?php

require_once '../includes/header.php';
require_once '../config/db_connect.php';

checkAdmin();

// On récupère l'user
if (!isset($_GET['id']))  die('Unknown user');
$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$id]);
$user = $stmt->fetch();

if (!$user) die('Unknown user');

?>

<div id="main-part">
    <h2>Bill <?= ucfirst(strtolower($user['username'])) ?></h2>
    <form>
        <label for="cashIn">Cash in :</label>
        <input type="number" id="cashIn" name="cashIn">
        <button type="submit">Cash in</button>
    </form
    <br><br><br>
   </div>


<?php require '../includes/footer.php'; ?>
