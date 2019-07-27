<?php
include('simplehtmldom_1_9/simple_html_dom.php');

$html = file_get_html('https://www.onliner.by/');
foreach($html->find('a.b-main-navigation__link') as $e)
    echo $e->href . '<br>';


foreach($html->find('div.b-top-logo') as $e)
    echo $e->innertext . '<br>';


