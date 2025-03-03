<?php
require_once '../../config/db_connect.php';
require_once '../../config/config.php';
require_once '../../includes/functions.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("<div class='alert'>Access denied</div>");
}

//Vérification de la méthode POST
checkMethodPost();
// Vérification du token CSRF
checkCsrfToken();
// récupération de l'user
if (!isset($_POST['id'])) die('Unknown user');
$id = $_POST['id'];

$stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
$stmt->execute([$id]);
$user = $stmt->fetch();

if (!$user) die('Unknown user');

// Logique de lock à refactoriser
if (!$user['locked']) {
    $stmt = $pdo->prepare('UPDATE users SET locked = 1 WHERE id = ?');
    if ($stmt->execute([$id])) {
        $_SESSION['user_id_redirect'] = $id;
        $user['locked'] = true;
        session_write_close();
        logAction($pdo, $_SESSION['id'], 'lock_user', "Locked user " . $user['username'] . " (ID :  " . $user['id'] . ")" );
        header("Location: user_list.php");
        exit;
    } else {
        echo '<div class="error_message">Error when updating the user</div>';
    }
} else {
    $stmt = $pdo->prepare('UPDATE users SET locked = 0 WHERE id = ?');
    if ($stmt->execute([$id])) {
        $_SESSION['user_id_redirect'] = $id;
        $user['locked'] = false;
        session_write_close();
        logAction($pdo, $_SESSION['id'], 'unlock_user', "Unlocked user " . $user['username'] . " (ID :  " . $user['id'] . ")" );
        header("Location: user_list.php");
        exit;
    } else {
        echo '<div class="error_message">Error when updating the user</div>';
    }
}


