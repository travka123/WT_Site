<?php

function highlight_phonenumber(string $text)
{
    preg_match('/[+]\d{1,3}[-]\d{1,3}[-]\d{3}[-]\d{2}[-]\d{2}/', $text, $matches);
    print_r($matches);
    foreach($matches as $strnumber)
    {
        $text = str_replace($strnumber, '<span class="phonenumber underline">' . $strnumber . '</span>', $text);
    }
    preg_match('/[+]\d{4,4}[-]\d{3}[-]\d{2}[-]\d{2}/', $text, $matches);
    print_r($matches);
    foreach($matches as $strnumber)
    {
        $text = str_replace($strnumber, '<span class="phonenumber underline">' . $strnumber . '</span>', $text);
    }
    preg_match('/[+]\d{11,15}/', $text, $matches);
    print_r($matches);
    foreach($matches as $strnumber)
    {
        $text = str_replace($strnumber, '<span class="phonenumber">' . $strnumber . '</span>', $text);
    }
    preg_match('/[+]\d{2,3}\s?\d{2,3}\s?\d{3}\s\d{2}\s\d{2}/', $text, $matches);
    print_r($matches);
    foreach($matches as $strnumber)
    {
        $text = str_replace($strnumber, '<span class="phonenumber">' . $strnumber . '</span>', $text);
    }
    
    return $text;
}



if ($_POST)
{
    $contact_information = $_POST['contact_information'];
    $template = file_get_contents('template_base.html');
    $template = str_replace('{header}', file_get_contents('header.html'), $template);
    $template = str_replace('{footer}', file_get_contents('footer.html'), $template);
    $template = str_replace('{page_css}',  file_get_contents('contact_send.css'), $template);
    $template = str_replace('{page_html}', file_get_contents('contact_send.html'), $template);

    $contact_information = highlight_phonenumber($contact_information);
    $template = str_replace('{sended_information}', $contact_information, $template);
    echo $template;
}
else
{
    http_response_code(404);
}