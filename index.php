<?php

$page = $_GET['page'];

if (!$page) {
    $page = 'main';
}

if (file_exists($page . '.html')) {
    $template = file_get_contents('template.html');
    $template = str_replace('{header}', file_get_contents('header.html'), $template);
    $template = str_replace('{footer}', file_get_contents('footer.html'), $template);
    $template = str_replace('{page_css}', $page . '.css', $template);
    $template = str_replace('{page_html}', file_get_contents($page . '.html'), $template);
    echo $template;
}
else {
    http_response_code(404);
}