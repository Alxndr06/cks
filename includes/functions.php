<?php

//Colorie la note en fonction de son montant
function colorDebt($note) : void  {
    if ($note <=5) {
        echo '<span style="color: green;">' . $note . '</span>';
    } else if ($note <=10) {
        echo '<span style="color: darkorange;">' . $note . '</span>';
    } else {
        echo '<span style="color: red;">' . $note . '</span>';
    }
}

function checkNoteIsNull() : void {
    if ($_SESSION['note'] == 0) {
        header("Location: ../user/dashboard.php");
        exit;
    }
}

// Vérifie si l'utilisateur est admin.
function checkAdmin() : void {
    if (!isset($_SESSION['id']) || $_SESSION['role'] !== "admin") {
        header("Location: ../login.php");
        exit;
    }
}

// Vérifie si l'utilisateur est connecté
function checkConnect() : void {
    if (!isset($_SESSION['id'])) {
        header("Location: ../login.php");
        exit;
    }
    require_once '../config/db_connect.php';

    // Si l'utilisateur n'existe plus en BDD, on le déconnecte.
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['id']]);
    $user = $stmt->fetch();

    if (!$user) {
        $_SESSION = [];
        session_unset();
        session_destroy();
        header("Location: ../login.php?message=Account deleted");
        exit;
    }
}

// fonction de bouton retour
function backupLink($default, $label) {
    $backupUrl = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : $default;
    echo '<a href="' . htmlspecialchars($backupUrl) . '" class="EOB">
            ' . htmlspecialchars($label) . '
          </a>';
}

// fonction de barre de gestion des users
function generateUserAdminActions($user) {
    $userId = htmlspecialchars($user['id']);
    $lockIcon = $user['locked'] == 0 ? '🔒 Lock' : '🔓 Unlock';
    $lockUrl = "lock_user.php?id=$userId";
    $editUrl = "edit_user.php?id=$userId";
    $deleteUrl = "delete_user.php?id=$userId";
    $billUrl = "bill_user.php?id=$userId";

    return '
    <div class="OEB">
        <a href="' . $lockUrl . '">' . $lockIcon . '</a> |
        <a href="' . $editUrl . '">✏️ Edit</a> |
        <a href="' . $deleteUrl . '" onclick="return confirm(\'Delete user ?\');">🗑️ Delete</a> |
        <a href="' . $billUrl . '">💲 Bill</a>
    </div>';
}
