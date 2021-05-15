<?php 

session_start();

define('SUCCESS', 0);
define('UNABLE_TO_CONNECT_TO_DATABASE', 1);
define('USER_NOT_FOUND', 2);
define('WRONG_PASSWORD', 3);
define('USER_ALREADY_EXISTS', 4);
define('INCORRECT_LOGIN', 5);

function authorize() {
    try {
        $dbh = new PDO('mysql:dbname=cars;host=localhost', 'root', '');
    }
    catch (PDOException $e) {
        return UNABLE_TO_CONNECT_TO_DATABASE;
    }

    $sth = $dbh->prepare("SELECT `id`, `password_hash` FROM `user` WHERE `login`='{$_POST['login']}'");
    $sth->execute();
    if ($user = $sth->fetch(PDO::FETCH_ASSOC)) {
        if ($user['password_hash'] == md5(md5($_POST['password']))) {
            $_SESSION['id']=$user['id'];
            return SUCCESS;
        }
        else {
            return WRONG_PASSWORD;
        }
    }
    else {
        return USER_NOT_FOUND;
    }

    return SUCCESS;
}

function register() {

    if(!(preg_match("/^[a-zA-Z0-9]+$/", $_POST['login']) && ((strlen($_POST['login']) > 3) || (strlen($_POST['login']) <= 30))))
    {
        return INCORRECT_LOGIN;
    }

    try {
        $dbh = new PDO('mysql:dbname=cars;host=localhost', 'root', '');
    }
    catch (PDOException $e) {
        return UNABLE_TO_CONNECT_TO_DATABASE;
    }

    $hash = md5(md5($_POST['password']));
    $sth = $dbh->prepare("INSERT INTO `user` (login, password_hash) VALUES ('{$_POST['login']}', '{$hash}')");
    try {
        $sth->execute();
    }
    catch (PDOException $e) {
        return USER_ALREADY_EXISTS;
    }
    return SUCCESS;
}

if ($_POST && (isset($_POST['login']) && isset($_POST['password']))) {
    if (isset($_POST['authorization'])) {
        echo authorize();
    }
    else if (isset($_POST['registration'])) {
        echo register();
    }
    else {
        http_response_code(404);
    }
}
else {
    http_response_code(404);
}
