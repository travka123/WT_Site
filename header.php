<?php

function prepare_header($header) {
    if (isset($_SESSION['id'])) {
        $header = str_replace('{basket}', '<a href="login.php">Корзина</a>', $header);
    }
    else {
        $header = str_replace('{basket}', '<a href="login.php">Войти</a>', $header);
    }
    return $header;
}