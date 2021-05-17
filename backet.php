<?php

session_start();

function get_car_card($car, $number) {
    $card = file_get_contents('items_templates\\backet_card\\backet_card.html');
    $card = str_replace('{car_image}', $car['img'], $card); 
    $card = str_replace('{car_name}', $car['name'], $card);
    $card = str_replace('{car_brand}', $car['brand'], $card);
    $card = str_replace('{car_price}', (string)$car['price'], $card);
    $id = "card-auto-{$number}";
    $card = str_replace('{card_id}', $id, $card);
    $card = str_replace('{onclick_function}', "remove_from_backet({$car['backet_id']}, '{$id}')", $card);
    return $card;
}

function get_cards($dbh) {
    $cards = '';
    $number = 0;
    $sth = $dbh->prepare("SELECT *, backet.id AS backet_id FROM `backet` INNER JOIN `car` ON backet.car_id=car.id WHERE backet.user_id={$_SESSION['id']}");
    $sth->execute();
    while ($car = $sth->fetch(PDO::FETCH_ASSOC)) {
        $cards .= get_car_card($car, $number);
        $number++;
    }
    return $cards;
}

if (isset($_SESSION['id'])) {
    include('header.php');
    $header = prepare_header(file_get_contents('header.html'));

    $template = file_get_contents('template_base.html');
    $template = str_replace('{header}', $header, $template);
    $template = str_replace('{footer}', file_get_contents('footer.html'), $template);
    $template = str_replace('{page_css}',  file_get_contents('backet.css') . file_get_contents('items_templates\\backet_card\\backet_card.css'), $template);
    $template = str_replace('{page_html}', file_get_contents('backet.html'), $template);

    try {
        $dbh = new PDO('mysql:dbname=cars;host=localhost', 'root', '');
    }
    catch (PDOException $e) {
        die($e->getMessage());
    }

    $sth = $dbh->prepare("SELECT `login` FROM `user` WHERE `id`={$_SESSION['id']}");
    $sth->execute();
    $username = $sth->fetch(PDO::FETCH_ASSOC)['login'];
    $template = str_replace('{username}', $username, $template);

    $template = str_replace('{backet_cards}', get_cards($dbh), $template);
    $template = $template . '<script src="methods\\remove_from_backet\\remove_from_backet.js"></script>';
    echo $template;
}
else {
    http_response_code(401);
}