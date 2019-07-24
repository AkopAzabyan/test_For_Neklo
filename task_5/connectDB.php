<?php
$connection = mysqli_connect("127.0.0.1", "root", "", "testbase")
or die("Ошибка подключения" . mysqli_error($connection));
if (!$connection) {
    echo " Не удалось подключиться к серверу <br>";
}
$select_db = mysqli_select_db($connection, 'testbase');