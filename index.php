<?php

$template = file_get_contents('template.html');

$template = str_replace('{header}', file_get_contents('header.html'), $template);
$template = str_replace('{footer}', file_get_contents('footer.html'), $template);

$page = $_GET['page'];
if (!$page) {
    $page = 'main';
}

$template = str_replace('{page_css}', $page . '.css', $template);
$template = str_replace('{page_html}', file_get_contents($page . '.html'), $template);

echo $template;