<?php
require_once __DIR__ . '/../config/db_connect.php';
require_once __DIR__ . '/../config/config.php';
use JetBrains\PhpStorm\NoReturn;

function getUserById(PDO $pdo, int $id): ?array {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC) ?: null; // Si aucun utilisateur n'est trouvé, retourne `null`
}

#[NoReturn] function redirectToLogin() : void {
    global $base_url;
    header("Location: " . $base_url . "login.php");
    exit;
}

#[NoReturn] function logoutAndRedirect(string $message): void {
    session_unset();
    session_destroy();
    header("Location: ../login.php?message=" . urlencode($message));
    exit;
}

//Colorie la note en fonction de son montant
function colorDebt(float $note): string {
    $color = $note <= 5 ? 'green' : ($note <= 10 ? 'darkorange' : 'red');
    return sprintf('<span style="color: %s;">%s</span>', $color, htmlspecialchars($note));
}

function checkNoteIsNull() : void {
    if ($_SESSION['note'] == 0) {
    header("Location: ../user/dashboard.php");
    exit;
    }
}

// Vérifie si l'utilisateur est connecté
function checkConnect() : void {
    global $pdo;

    if (!isset($_SESSION['id'])) {
        redirectToLogin();
    }

    $user = getUserById($pdo, $_SESSION['id']);

    if (!$user) {
        logoutAndRedirect('Account deleted');
    }
    $_SESSION['username'] = $user['username']; // Met à jour le bon nom d'utilisateur
    $_SESSION['note'] = $user['note'];
    $_SESSION['locked'] = $user['locked']; // Update l'état de lock
}

// Vérifie si l'utilisateur est admin.
function checkAdmin() : void {
    checkConnect();
    if ($_SESSION['role'] !== "admin") {
    redirectToLogin();
    }
}

function displayLockedStatus() : string {
    if (isset($_SESSION['id']) && isset($_SESSION['locked']) && $_SESSION['locked']) {
        return '<p class="alert">Your account is locked. You cannot place an order.</p>';
    }
    return '';
}

// fonction de lien retour
function backupLink(string $default, string $label): string {
    $backupUrl = $default;

    // Vérifier si HTTP_REFERER est présent et appartient à notre domaine
    if (!empty($_SERVER['HTTP_REFERER'])) {
        $parsedUrl = parse_url($_SERVER['HTTP_REFERER']);

        // Vérifier que le domaine du REFERER est bien celui du site
        if (!empty($parsedUrl['host']) && $parsedUrl['host'] === $_SERVER['SERVER_NAME']) {
            $backupUrl = $_SERVER['HTTP_REFERER'];
        }
    }

    return sprintf('<a href="%s" class="backupLink">%s</a>', htmlspecialchars($backupUrl, ENT_QUOTES, 'UTF-8'), htmlspecialchars($label, ENT_QUOTES, 'UTF-8'));
}

// fonction de barre de gestion des users
function AdvancedAdminActions($user) : string {
    $userId = htmlspecialchars($user['id']);
    $lockIcon = !$user['locked'] ? '🔒 Lock' : '🔓 Unlock';
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

function restrictedAdminActions($user) : string{
    $userId = htmlspecialchars($user['id']);
    $openUrl = "user_details.php?id=$userId";
    $lockIcon = !$user['locked'] ? '🔒 Lock' : '🔓 Unlock';
    $lockUrl = "lock_user.php?id=$userId";
    $billUrl = "bill_user.php?id=$userId";
    return sprintf('<td><a href="%s">🔎 Open</a>
    | <a href="%s">%s</a> 
    | <a href="%s">💲Bill</a></td>', $openUrl, $lockUrl, $lockIcon, $billUrl);
}

function productAdminActions($product) : string{
    $productId = htmlspecialchars($product['id']);
    $editUrl = "edit_product.php?id=$productId";
    $deleteUrl = "delete_product.php?id=$productId";
    $restrictIcon = !$product['restricted'] ? ' Restrict' : ' Allow';
    $restrictUrl = "restrict_product.php?id=$productId";
    return sprintf('
    <td><a href="%s"> Edit </a>
    | <a href="%s">%s</a> 
    | <a href="%s"> Delete </a></td>', $editUrl, $restrictUrl,$restrictIcon, $deleteUrl);
}





