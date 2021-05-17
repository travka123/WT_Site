<?php 

session_start();

if ($_POST) {
    if (isset($_POST['id']) && isset($_SESSION['id']) && ($_SESSION['role'] == 0)) {
        try {
            $dbh = new PDO('mysql:dbname=cars;host=localhost', 'root', '');
        }
        catch (PDOException $e) {
            http_response_code(500);
        }
        
        $sth = $dbh->prepare("DELETE FROM `backet` WHERE id={$_POST['id']} AND user_id={$_SESSION['id']}");
        $sth->execute();
    }
    else {
        http_response_code(401);
    }
}
else {
    http_response_code(404);
}