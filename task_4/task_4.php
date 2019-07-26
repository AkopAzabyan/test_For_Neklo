<?php
include('simplehtmldom_1_9/simple_html_dom.php');

$html = file_get_html('https://www.onliner.by');
foreach($html->find('a') as $e)
    echo $e->href . '<br>';
