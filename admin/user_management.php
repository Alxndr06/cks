<?php
require_once '../includes/header.php';

checkAdmin();
?>

    <div id="main-part">
        <h2>User management</h2>
        <div id="nav_dashboard">
            <li><a title="Show all users" href="user_list.php">📋Show all users</a></li>
            <li><a title="Create a new user" href="add_user.php">➕Create new user</a></li>
        </div>
    </div>

<?php require '../includes/footer.php'; ?>