<?php
function colorDebt($note) {
    if ($note <=5) {
        echo '<span style="color: green;">' . $note . '</span>';
    } else if ($note <=10) {
        echo '<span style="color: darkorange;">' . $note . '</span>';
    } else {
        echo '<span style="color: red;">' . $note . '</span>';
    }
}