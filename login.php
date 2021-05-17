<?php

session_start();

define('SUCCESS', 0);
define('UNABLE_TO_CONNECT_TO_DATABASE', 1);
define('WRONG_LOGIN_OR_PASSWORD', 2);
define('USER_ALREADY_EXISTS', 3);
define('INCORRECT_LOGIN', 4);

$template = file_get_contents('template_base.html');

include('header.php');
$header = prepare_header(file_get_contents('header.html'));

$template = str_replace('{header}', $header, $template);
$template = str_replace('{footer}', file_get_contents('footer.html'), $template);
$template = str_replace('{page_css}',  file_get_contents('login.css'), $template);
$template = str_replace('{page_html}', file_get_contents('login.html'), $template);

if (isset($_GET['error'])) {
    switch ($_GET['error']) {
        case 1:
            $template = str_replace('{authorization_error}', "Ошибка сервера", $template);
            break;

        case 2:
            $template = str_replace('{authorization_error}', "Неверное имя пользователя или пароль", $template);
            break;

        case 3:
            $template = str_replace('{authorization_error}', "Имя пользователя занято", $template);
            break;

        case 4:
            $template = str_replace('{authorization_error}', "Логин должен быть не меньше 3-х символов и не больше 30, 
                состоять из букв английского алфавита и цифр", $template);
            break;
    }
}
else {
    $template = str_replace('{authorization_error}', "", $template);
}

if (isset($_GET['message'])) {
    switch ($_GET['message']) {
        case 0:
            $template = str_replace('{authorization_message}', "Регистрация прошла успешно", $template);
            break;
    }
}
else {
    $template = str_replace('{authorization_message}', "", $template);
}

echo $template;
