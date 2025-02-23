<?php
require_once '../../config/db_connect.php';

// récupération de l'user
if (!isset($_GET['id'])) die('Unknown user');

$id = $_GET['id'];

$stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
$stmt->execute([$id]);
$user = $stmt->fetch();

if (!$user) die('Unknown user');


// Logique de lock
if (!$user['locked']) {
    $stmt = $pdo->prepare('UPDATE users SET locked = 1 WHERE id = ?');
    if ($stmt->execute([$id])) {
        header("Location: user_details.php?id=$id");
        exit;
    } else {
        echo '<div class="error_message">Error when updating the user</div>';
    }
} else {
    $stmt = $pdo->prepare('UPDATE users SET locked = 0 WHERE id = ?');
    if ($stmt->execute([$id])) {
        header("Location: user_details.php?id=$id");
        exit;
    } else {
        echo '<div class="error_message">Error when updating the user</div>';
    }
}


