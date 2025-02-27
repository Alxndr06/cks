<?php
//Colorie la note en fonction de son montant
function colorDebt($note) : string  {
    if ($note <=5) {
        return '<span style="color: green;">' . htmlspecialchars($note) . '</span>';
    } elseif ($note <= 10) {
        return '<span style="color: darkorange;">' . htmlspecialchars($note) . '</span>';
    } else {
        return '<span style="color: red;">' . htmlspecialchars($note) . '</span>';
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

// fonction de lien retour
function backupLink(string $default, string $label) : string {
    $backupUrl = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : $default;
    return sprintf('<a href="%s" class="EOB">%s</a>', htmlspecialchars($backupUrl), htmlspecialchars($label));

}


// fonction de barre de gestion des users
function AdvancedAdminActions($user) : string {
    $userId = htmlspecialchars($user['id']);
    $lockIcon = !$user['locked'] ? '🔒 Lock' : '🔓 Unlock';
    $lockUrl = "lock_user.php?id=$userId";
    $orderListUrl = "../orders/order_list.php?userId=$userId";
    $editUrl = "edit_user.php?id=$userId";
    $deleteUrl = "delete_user.php?id=$userId";
    $billUrl = "bill_user.php?id=$userId";

    return '
    <div class="OEB">
        <a href="' . $lockUrl . '">' . $lockIcon . '</a> |
        <a href="' . $orderListUrl . '">📜 Orders</a> |
        <a href="' . $editUrl . '">✏️ Edit</a> |
        <a href="' . $deleteUrl . '" onclick="return confirm(\'Delete user ?\');">🗑️ Delete</a> |
        <a href="' . $billUrl . '">💲 Bill</a>
    </div>';
}

function restrictedAdminActions($user) : string{
    $userId = htmlspecialchars($user['id']);
    $openUrl = "user_details.php?id=$userId";
    $lockIcon = !$user['locked'] ? '🔒 Lock' : '🔓 Unlock';
    $lockUrl = "lock_user.php?id=$userId";
    $billUrl = "bill_user.php?id=$userId";
    return sprintf('<td><a href="%s">🔎open</a>
    | <a href="%s">%s</a> 
    | <a href="%s">💲bill</a></td>', $openUrl, $lockUrl, $lockIcon, $billUrl);
}

function displayLockedMessage(bool $isLocked) : string {
    return $isLocked ? '<p class="alert">Your account is locked. You cannot place order.</p>' : '';
}
