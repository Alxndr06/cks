<?php
require_once '../../includes/header.php';
require_once '../../config/db_connect.php';

checkAdmin();

//LOGIQUE ADD USER
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $lastname = $_POST['lastname'];
    $firstname = $_POST['firstname'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $stmt = $pdo->prepare("INSERT INTO users (username, lastname, firstname, email, password, role) VALUES (?, ?, ?, ?, ?, ?)");
    if ($stmt->execute([$username, $lastname, $firstname, $email, $password, $role])) {
        header('Location: user_list.php');
        exit;
    } else {
        echo "Something went wrong";
    }
}
?>

<div id="main-part">
    <h2>Create an user</h2>
    <form method="POST">
        <label for="username">Username :</label>
        <input type="text" id="username" name="username" required><br><br>
        <label for="lastname">Lastname :</label>
        <input type="text" id="lastname" name="lastname" required><br><br>
        <label for="firstname">Firstname :</label>
        <input type="text" id="firstname" name="firstname" required><br><br>
        <label for="email">Email :</label>
        <input type="email" id="email" name="email" required><br><br>
        <label for="password">Password :</label>
        <input type="password" id="password" name="password" required><br><br>
        <label for="role">Select role :</label>
        <select name="role" id="role" required>
            <option value="">--Select role--</option>
            <option value="user">User</option>
            <option value="admin">Admin</option>
        </select><br><br>
        <button type="submit">Create account</button><br><br>
    </form>
</div>

<?php require '../../includes/footer.php'; ?>
