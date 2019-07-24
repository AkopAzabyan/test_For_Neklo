<?php
$mas = $argv;
asort($mas);
array_unique($mas);
foreach ($mas as $item) {
    if ((int)($item)) {
        echo "$item ";
    }
}
