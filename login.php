<?php
require_once 'includes/header.php';
require_once 'config/db_connect.php';

//On s'assure que l'user ne soit pas déjà log
if (isset($_SESSION['id'])) {
    header('Location: index.php');
    exit;
}

// On s'assure de la méthode post
if ($_SERVER["REQUEST_METHOD"] == "POST" ) {
    //Récupération des données du formulaire qui ne sont pas encore sécurisées contre les injections
    $username = $_POST["username"];
    $password = $_POST["password"];
    // On prépare notre requête SQL
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    // Vérification du mot de passe
    if ($user && password_verify($password, $user['password'])) {
        //Création de la session
        $_SESSION['id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['note'] = $user['note'];
        $_SESSION['role'] = $user['role'];
        header("Location: index.php");
        exit();
    } else {
        echo "Error : username or password is incorrect";
    }
}

?>

<div id="main-part">
    <h2>Login</h2>
    <form method="POST">
        <label for="username">Username :</label>
        <input type="text" id="username" name="username" required><br><br>
        <label for="password">Password :</label>
        <input type="password" id="password" name="password" required><br><br>
        <button type="submit">Connect</button><br><br>
    </form>
    <p>No account yet ? <a href="mailto:contact@aulong.fr">Contact me</a></p>
</div>

<?php require 'includes/footer.php'; ?>