<?php

session_start();

function get_car_card($car) {
    $card = file_get_contents('card.html');
    $card = str_replace('{car_image}', $car['img'], $card); 
    $card = str_replace('{car_name}', $car['name'], $card);
    $card = str_replace('{car_brand}', $car['brand'], $card);
    $card = str_replace('{car_price}', (string)$car['price'], $card);
    $card = str_replace('{onclick_function}', "add_to_backet({$car['id']})", $card);
    return $card;
}

function get_cards() {
    $cards = "";
    try {
        $dbh = new PDO('mysql:dbname=cars;host=localhost', 'root', '');
    }
    catch (PDOException $e) {
        die($e->getMessage());
    }
    $sth = $dbh->prepare('SELECT * FROM `car`');
    $sth->execute();
    while ($car = $sth->fetch(PDO::FETCH_ASSOC)) {
        $cards .= get_car_card($car);
    }
    return $cards;
}

include('header.php');
$header = prepare_header(file_get_contents('header.html'));

$template = file_get_contents('template_base.html');
$template = str_replace('{header}', $header, $template);
$template = str_replace('{footer}', file_get_contents('footer.html'), $template);
$template = str_replace('{page_css}',  file_get_contents('catalog.css') . file_get_contents('card.css'), $template);
$template = str_replace('{page_html}', file_get_contents('catalog.html'), $template);
$template = str_replace('{cards}', get_cards(), $template);
$template = $template . '<script src="car_card.js"></script>';
echo $template;