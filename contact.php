<?php

session_start();

$template = file_get_contents('template_base.html');

include('header.php');
$header = prepare_header(file_get_contents('header.html'));

$template = str_replace('{header}', $header, $template);
$template = str_replace('{footer}', file_get_contents('footer.html'), $template);
$template = str_replace('{page_css}',  file_get_contents('contact.css'), $template);
$template = str_replace('{page_html}', file_get_contents('contact.html'), $template);

echo $template;