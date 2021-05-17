<?php 

session_start();

define('SUCCESS', 0);
define('UNABLE_TO_CONNECT_TO_DATABASE', 1);
define('WRONG_LOGIN_OR_PASSWORD', 2);
define('USER_ALREADY_EXISTS', 3);
define('INCORRECT_LOGIN', 4);

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
            $_SESSION['role']=$user['role'];
            return SUCCESS;
        }
        else {
            return WRONG_LOGIN_OR_PASSWORD;
        }
    }
    else {
        return WRONG_LOGIN_OR_PASSWORD;
    }

    return SUCCESS;
}

function register() {

    if(!(preg_match("/^[a-zA-Z0-9]+$/", $_POST['login']) && ((strlen($_POST['login']) > 3) && (strlen($_POST['login']) <= 30))))
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
    $sth = $dbh->prepare("INSERT INTO `user` (login, password_hash, role) VALUES ('{$_POST['login']}', '{$hash}', 0)");
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
        $err = authorize();
        if ($err == SUCCESS) {
            header("Location: http://localhost/index.php");
        }
        else {
            header("Location: http://localhost/login.php?error={$err}");
        }
    }
    else if (isset($_POST['registration'])) {
        $err = register();
        if ($err == SUCCESS) {
            header("Location: http://localhost/login.php?message={$err}");
        }
        else {
            header("Location: http://localhost/login.php?error={$err}");
        }
    }
    else {
        http_response_code(404);
    }
}
else {
    http_response_code(404);
}
