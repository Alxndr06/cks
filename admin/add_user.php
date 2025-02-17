<?php
require_once '../includes/header.php';
require_once '../config/db_connect.php';

if (!isset($_SESSION['id']) || $_SESSION['role'] !== "admin") {
    header("Location: ../login.php");
    exit;
}

//Insérer code backend ici

?>

<div id="main-part">
    <h2>Create an user</h2>
    <form method="POST">
        <label for="username">Username :</label>
        <input type="text" id="username" name="username" required><br><br>
        <label for="email">Email :</label>
        <input type="email" id="email" name="email" required><br><br>
        <label for="password">Password :</label>
        <input type="password" id="password" name="password" required><br><br>
        <select name="role">
            <option value="user">Utilisateur</option>
            <option value="admin">Administrateur</option>
        </select><br><br>
        <button type="submit">Create account</button><br><br>
    </form>
</div>

<?php include '../includes/footer.php' ?>
