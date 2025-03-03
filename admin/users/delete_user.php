<?php
session_start();
require_once '../../config/db_connect.php';
require_once '../../includes/functions.php';

checkAdmin();
//Vérification de la méthode POST
checkMethodPost();
// Vérification du token CSRF
checkCsrfToken();
// récupération de l'user
if (!isset($_POST['id'])) die('Unknown user');
$id = $_POST['id'];

$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$id]);
$user = $stmt->fetch();

// vérification que le compte supprimé ne soit pas celui d'un admin
if ($user['role'] !== 'admin') {
    // On éclate la session de l'user supprimé
    if (isset($_SESSION['id']) && $_SESSION['id'] == $id) {
        $_SESSION = [];
        session_unset();
        session_destroy();
    }

    // logique de suppression de la bdd
    $stmt = $pdo->prepare('DELETE FROM users WHERE id = ?');
    if ($stmt->execute([$id])) {
        logAction($pdo, $_SESSION['id'], 'delete_user', "Deleted user " . $user['username'] . " (ID :  " . $user['id'] . ")" );
        header('Location: user_list.php');
        exit;
    } else {
        echo "<div class='alert'>Error deleting user</div>";
    }
} else {
    echo "<div class='alert'>Cannot delete user with Admin perms</div>";
}