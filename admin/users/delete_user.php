<?php
session_start();
require_once '../../config/db_connect.php';
require_once '../../includes/functions.php';

checkAdmin();

// On vérifie que l'ID soit bien un entier et pas autre chose
if (!isset($_GET['id']) || !filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
    die("<div class='alert'>Invalid user ID</div>");
}

// Récupération de l'utilisateur
if (!isset($_GET['id'])) die('Unknown user');

// Conversion en Int pour être sûr le reuf
$id = (int) $_GET['id'];

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
        header('Location: user_list.php');
        exit;
    } else {
        echo "<div class='alert'>Error deleting user</div>";
    }
} else {
    echo "<div class='alert'>Cannot delete user with Admin perms</div>";
}