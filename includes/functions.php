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
}
