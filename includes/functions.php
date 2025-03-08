<?php
require_once __DIR__ . '/../config/db_connect.php';
require_once __DIR__ . '/../config/config.php';
use JetBrains\PhpStorm\NoReturn;

function getCsrfToken(): string {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function checkCsrfToken(): void {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("Invalid CSRF token.");
    }
}

function checkMethodPost() : void {
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        die("Invalid request method.");
    }
}

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
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== "admin") {
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

function restrictedAdminActions($user) : string {
    $userId = htmlspecialchars($user['id']);
    $csrfToken = getCsrfToken(); // 🔹 Stocker le token pour éviter plusieurs appels
    $lockIcon = !$user['locked'] ? '🔒' : '🔓';


    return sprintf('
        <td>
            <form action="user_details.php" method="POST" style="display:inline;">
                <input type="hidden" name="csrf_token" value="%s">
                <input type="hidden" name="id" value="%s">
                <button type="submit">🔎</button>
            </form>
            | <form action="lock_user.php" method="POST" style="display:inline;">
                <input type="hidden" name="csrf_token" value="%s">
                <input type="hidden" name="id" value="%s">
                <button type="submit">%s</button>
            </form>
            | <form action="bill_user.php" method="GET" style="display:inline;">
                <input type="hidden" name="csrf_token" value="%s">
                <input type="hidden" name="id" value="%s">
                <button type="submit">💲</button>
            </form>
        </td>',
        $csrfToken, $userId,
        $csrfToken, $userId, $lockIcon,
        $csrfToken, $userId
    );
}

// fonction de barre de gestion des users
function advancedAdminActions($user) : string {
    $userId = htmlspecialchars($user['id']);
    $csrfToken = getCsrfToken(); // 🔹 Stocker le token pour éviter plusieurs appels
    $lockIcon = !$user['locked'] ? '🔒' : '🔓';

    return sprintf('
        <div class="OEB">
             <form action="lock_user.php" method="POST" style="display:inline;">
                <input type="hidden" name="csrf_token" value="%s">
                <input type="hidden" name="id" value="%s">
                <button type="submit" title="Lock/Unlock user">%s</button>
            </form>
            | <form action="bill_user.php" method="GET" style="display:inline;">
                <input type="hidden" name="csrf_token" value="%s">
                <input type="hidden" name="id" value="%s">
                <button type="submit" title="Bill user">💲</button>
            </form>
            | <form action="edit_user.php" method="GET" style="display:inline;">
                <input type="hidden" name="csrf_token" value="%s">
                <input type="hidden" name="id" value="%s">
                <button type="submit" title="Edit user">✏️</button>
            </form>
            | <form action="delete_user.php" method="POST" style="display:inline;">
                <input type="hidden" name="csrf_token" value="%s">
                <input type="hidden" name="id" value="%s">
                <button type="submit" title="Delete user">❌</button>
              </form>
        </div>',
        $csrfToken, $userId, $lockIcon,
        $csrfToken, $userId,
        $csrfToken, $userId,
        $csrfToken, $userId
    );
}


function productAdminActions($product) : string{
    $productId = htmlspecialchars($product['id']);
    $editUrl = "edit_product.php?id=$productId";
    $deleteUrl = "delete_product.php?id=$productId";
    $restrictIcon = !$product['restricted'] ? '🛑' : '✅';
    $restrictUrl = "restrict_product.php?id=$productId";
    return sprintf('
    <td><a href="%s">✏️️️️</a>
    | <a href="%s">%s</a> 
    | <a href="%s">❌</a></td>', $editUrl, $restrictUrl,$restrictIcon, $deleteUrl);
}

function logAction($pdo, $user_id, $action, $description) {
    $ip = $_SERVER['REMOTE_ADDR'];
    $stmt = $pdo->prepare("INSERT INTO logs (user_id, action, description, ip_address) VALUES (?, ?, ?, ?)");
    $stmt->execute([$user_id, $action, $description, $ip]);
}



