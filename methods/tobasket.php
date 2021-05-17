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
        
        $sth = $dbh->prepare('SELECT * FROM `car` WHERE id=1');
        $sth->execute();
        if ($car = $sth->fetch(PDO::FETCH_ASSOC)) {
            $sth = $dbh->prepare("INSERT INTO backet (user_id, car_id) VALUES ({$_SESSION['id']}, {$_POST['id']})");
            $sth->execute();
        }
        else {
            http_response_code(404);
        }
    }
    else {
        http_response_code(401);
    }
}
else {
    http_response_code(404);
}