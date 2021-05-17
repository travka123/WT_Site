<?php

function prepare_header($header) {
    if (isset($_SESSION['id'])) {
        if ($_SESSION['role'] == 0) {
            $header = str_replace('{basket}', '<a href="backet.php">Корзина</a>', $header);
        }
        else {
            $header = str_replace('{basket}', '', $header);
        }  
    }
    else {
        $header = str_replace('{basket}', '<a href="login.php">Войти</a>', $header);
    }
    return $header;
}