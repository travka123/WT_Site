<?php

function prepare_header($header) {
    if (isset($_SESSION['id'])) {
        $header = str_replace('{basket_dropdown}', '<a id="logout" onclick="logout()">Выйти</a>', $header);
        if ($_SESSION['role'] == 0) {
            $header = str_replace('{basket}', '<a id="backet-link" href="backet.php">Корзина</a>', $header);
        }
        else {
            $header = str_replace('{basket}', '', $header);
        }  
    }
    else {
        $header = str_replace('{basket_dropdown}', '', $header);
        $header = str_replace('{basket}', '<a id="backet-link" href="login.php">Войти</a>', $header);
    }
    return $header . '<script src="\\methods\\logout\\logout.js"></script>';
}