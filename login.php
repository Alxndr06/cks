<?php
require_once 'includes/header.php';
require_once 'config/db_connect.php';

// Si pas de token CSRF,  on en génère un
getCsrfToken();

//On s'assure que l'user ne soit pas déjà log
if (isset($_SESSION['id'])) {
    header('Location: index.php');
    exit;
}

// Traitement du formulaire (On s'assure de la méthode post)
if ($_SERVER["REQUEST_METHOD"] == "POST" ) {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("Invalid CSRF token"); // On bloque la requête si le token ne correspond pas
    }
    //Récupération de manière sécurisée pour éviter toute injection d'html du seigneur dans mes variables
    $username = trim(htmlspecialchars($_POST["username"]));
    $password = trim($_POST["password"]);

    // On prépare notre requête SQL
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    // Vérification du mot de passe
    if ($user && password_verify($password, $user['password'])) {
        // Génére un nouvel ID pour éviter le session fixation
        session_regenerate_id(true);

        //Création de la session
        $_SESSION['id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['lastname'] = $user['lastname'];
        $_SESSION['firstname'] = $user['firstname'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['note'] = $user['note'];
        $_SESSION['total_spent'] = $user['total_spent'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['locked'] = $user['locked'];

        // Régénérer le token CSRF pour la prochaine requête
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

        header("Location: user/dashboard.php");
        exit();
    } else {
        echo "<div class='error_message'>Error : username or password is incorrect</div>";
    }
}

?>

<div id="main-part">
    <h2>Login</h2>
    <form method="POST">
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
        <label for="username">Username :</label>
        <input type="text" id="username" name="username" required><br><br>
        <label for="password">Password :</label>
        <input type="password" id="password" name="password" required><br><br>
        <button type="submit">Login</button><br><br>
    </form>
    <p>No account yet ? <a href="mailto:contact@aulong.fr">Contact me</a></p>
</div>

<?php require 'includes/footer.php'; ?>