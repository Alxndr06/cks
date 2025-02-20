<?php
require_once '../includes/header.php';
require_once '../config/db_connect.php';

checkAdmin();

//LOGIQUE EDIT USER
// Récupérer l'utilisateur
if (!isset($_GET['id'])) die("Unknown user");
$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$id]);
$user = $stmt->fetch();

if (!$user) die("Unknown user");

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $lastName = $_POST['lastName'];
    $firstName = $_POST['firstName'];
    $email = $_POST['email'];
    $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : $user['password'];$password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : $user['password'];
    $role = $_POST['role'];


//Mise à jour de l'user sur la bdd
    $stmt = $pdo->prepare("UPDATE users SET username = ?, lastname = ?, firstname = ?, email = ?, password = ?, role = ? WHERE id = ?");
    if ($stmt->execute([$username, $lastName, $firstName, $email, $password, $role, $id])) {
        header('Location: user_list.php');
        exit;
    } else {
        echo '<div class="error_message">Error when updating the user</div>';
    }
}
?>

<div id="main-part">
    <h2>Edit user</h2>
    <form method="POST">
        <label for="username">Username :</label>
        <input type="text" id="username" name="username" value="<?= htmlspecialchars($user['username']) ?>" required><br><br>
        <label for="lastname">Lastname :</label>
        <input type="text" id="lastname" name="lastname" value="<?= htmlspecialchars($user['lastname']) ?>" required><br><br>
        <label for="firstname">Firstname :</label>
        <input type="text" id="firstname" name="firstname" value="<?= htmlspecialchars($user['firstname']) ?>" required><br><br>
        <label for="email">Email :</label>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required><br><br>
        <label for="password">Password :</label>
        <input type="password" id="password" name="password" required><br><br>
        <label for="role">Select role :</label>
        <select name="role" id="role" required>
            <option value="">--Select role--</option>
            <option value="user">User</option>
            <option value="admin">Admin</option>
        </select><br><br>
        <button type="submit">Edit user</button><br><br>
    </form>
    <a title="Back to users list" href="user_list.php">🔙back to list</a>
</div>

<?php include '../includes/footer.php' ?>
