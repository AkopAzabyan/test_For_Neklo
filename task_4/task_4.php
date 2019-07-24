<?php
include('simplehtmldom_1_9/simple_html_dom.php');

$html = file_get_html('https://ru.whoscored.com/Regions/108/Tournaments/5/Èòàëèÿ-Èòàëèÿ-1');
foreach($html->find('a') as $e)
    echo $e->href . '<br>';
