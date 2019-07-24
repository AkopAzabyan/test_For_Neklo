<?php

class First
{
    function getClassName()
    {
        echo get_class($this);
    }

    function getLetter()
    {
        echo "A";
    }
}

class Second extends First
{
    function getLetter()
    {
        echo "B";
    }
}

$fc = new First();
$sc = new Second();
$fc->getClassName();
echo "<br>";
$sc->getClassName();
echo "<br>";
$fc->getLetter();
echo "<br>";
$sc->getLetter();