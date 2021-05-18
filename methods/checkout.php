<?php

session_start();

if ($_POST && isset($_SESSION['id']) && isset($_POST['email'])) {

    try {
        $dbh = new PDO('mysql:dbname=cars;host=localhost', 'root', '');
    }
    catch (PDOException $e) {
        die($e->getMessage());
    }

    $sth = $dbh->prepare("SELECT `name`, `brand`, `price` FROM `backet` INNER JOIN `car` ON backet.car_id=car.id WHERE backet.user_id={$_SESSION['id']}");
    $sth->execute();

    $subject = "Оформление заказа";
    $body = "Здравствуйте, благодарим за оформление заказа.\r\nВаш заказ:\r\n";
    
    $total = 0;
    while ($car = $sth->fetch(PDO::FETCH_ASSOC)) {
        $body .= "{$car['name']} ({$car['brand']})   {$car['price']}$\r\n";
        $total += $car['price'];
    }
    $body .= "\r\n";
    $body .= "Итоговая сумма заказа: {$total}$\r\n"; 
    $body .= "-------------------------------------\r\nThis is test email send by PHP Script";
    $headers = "From: and.kis007@yandex.by";
    
    if (!(($total > 0) && mail($_POST['email'], $subject, $body, $headers))) {
        http_response_code(404);
    }
}
else {
    http_response_code(404);
}