<?php

require_once '../../includes/header.php';
require_once '../../config/db_connect.php';

checkAdmin();

// On récupère l'user
if (!isset($_GET['id']))  die('Unknown user');
$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$id]);
$user = $stmt->fetch();

if (!$user) die('Unknown user');

//On s'assure de la méthode post du formulaire
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $note = $user['note'];
    $billAmount = $_POST['billAmount'];
    $updatedNote = $note + $billAmount;

    $stmt = $pdo->prepare("UPDATE users SET note = ? WHERE id = ?");
    if($stmt->execute([($note + $billAmount), $id])){
        header('Location: user_details.php?id='.$id);
        exit;
    } else {
        echo 'Something went wrong';
    }
}

?>

<div id="main-part">
    <h2>Bill <?= ucfirst(strtolower($user['username'])) ?></h2>
    <form method="POST">
        <label for="billUser">Amount to bill :</label>
        <input type="number" id="billAmount" name="billAmount"><br><br>
        <label for="reasonForBilling" id="reasonForBilling" name="reasonForBilling">Reason :</label>
        <input type="text" id="reasonForBilling" name="reasonForBilling"><br><br>
        <button type="submit">Bill user</button>
    </form>
    <br><br><br>
   </div>


<?php require '../../includes/footer.php'; ?>
