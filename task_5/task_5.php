<?php

include("connectDB.php");

$resultTransaction = mysqli_query($connection, "select * from transactions");
$resultSender = mysqli_query($connection, "select from_person_id,fullname,amount from transactions t join persons p on t.from_person_id=p.id");
$resultRecipients = mysqli_query($connection, "select to_person_id,fullname,amount from transactions t join persons p on t.to_person_id=p.id ");

$getCurrentBalance = mysqli_query($connection, "SELECT `id`, `fullname`,
Round((100 + IFNULL((SELECT SUM(`amount`) FROM `transactions` WHERE `to_person_id`=`persons`.`id`),0) - 
IFNULL((SELECT SUM(`amount`) FROM `transactions` WHERE `from_person_id`=`persons`.`id`),0)),2) 
as `balans` FROM `persons`");

$getPersonsMaxCountTransactions = mysqli_query($connection, "SELECT  from_person_id, COUNT(*) as max_count from 
(SELECT from_person_id  from `transactions` AS t1 UNION ALL 
SELECT to_person_id  from `transactions` as t2)
as T GROUP BY from_person_id HAVING max_count > 2 ORDER by max_count DESC ");

$getNameCityMaxTransactions = mysqli_query($connection, "select name from cities where id = 
(select city_id from 
(select count(*) as transactions_count, city_id from 
(SELECT * FROM `transactions` t inner join persons p on t.from_person_id=p.id 
UNION 
SELECT * FROM `transactions` t inner join persons p on t.to_person_id=p.id 
) as A 
group by city_id 
) as B 
order by transactions_count desc limit 1 
)");

$getTransactionCity = mysqli_query($connection, "select * from transactions t 
INNER JOIN persons p1 on t.from_person_id=p1.id 
INNER JOIN persons p2 on t.to_person_id=p2.id 
WHERE p1.city_id=p2.city_id");

$resultTransactionRows = mysqli_num_rows($resultTransaction);
$getTransactionCityRows = mysqli_num_rows($getTransactionCity);
$getPersonsMaxCountTransactionsRows = mysqli_num_rows($getPersonsMaxCountTransactions);
$resultSenderRows = mysqli_num_rows($resultSender);
$resultRecipientsRows = mysqli_num_rows($resultRecipients);
$getCurrentBalanceRows = mysqli_num_rows($getCurrentBalance);

echo "<table><tr><th>Id</th><th>Отправитель</th><th>Получатель</th><th>Сумма</th></tr>";
for ($i = 0; $i < $resultTransactionRows; ++$i) {
    $row = mysqli_fetch_array($resultTransaction);
    echo "<tr>";
    for ($j = 0; $j < 4; ++$j) {
        echo "<td>$row[$j]</td>";
    }
    echo "</tr>";
}
echo "</table>";

echo '<hr>';
echo "<table><tr><th>Id</th><th>Имя отправителя</th><th>Сумма</th></tr>";
for ($i = 0; $i < $resultTransactionRows; ++$i) {
    $row = mysqli_fetch_array($resultSender);
    echo "<tr>";
    for ($j = 0; $j < 3; ++$j) {
        echo "<td>$row[$j]</td>";
    }
    echo "</tr>";
}
echo "</table>";
echo '<hr>';
echo "<table><tr><th>Id</th><th>Имя получателя</th><th>Сумма</th></tr>";
for ($i = 0; $i < $resultRecipientsRows; ++$i) {
    $row = mysqli_fetch_array($resultRecipients);
    echo "<tr>";
    for ($j = 0; $j < 4; ++$j) {
        echo "<td>$row[$j]</td>";
    }
    echo "</tr>";
}
echo "</table>";
echo '<hr>';
echo '<table><tr><th>Текущий баланс: </th></tr></table>';
echo "<table><tr><th>Id</th><th>Полное имя</th><th>Баланс</th></tr>";
for ($i = 0; $i < $getCurrentBalanceRows; ++$i) {
    $row = mysqli_fetch_array($getCurrentBalance);
    echo "<tr>";
    for ($j = 0; $j < 4; ++$j) {
        echo "<td>$row[$j]</td>";
    }
    echo "</tr>";
}
echo "</table>";
echo '<hr>';
echo "<table><tr><th>Id Представителя</th><th>Кол-во транзакций</th></tr>";
for ($i = 0; $i < $getPersonsMaxCountTransactionsRows; ++$i) {
    $row = mysqli_fetch_array($getPersonsMaxCountTransactions);
    echo "<tr>";
    for ($j = 0; $j < 4; ++$j) {
        echo "<td>$row[$j]</td>";
    }
    echo "</tr>";
}
echo "</table>";

echo '<hr>';

echo '<table><tr><th>Город,представительно которого больше всех учавствовал: </th></tr></table>';
while ($res4 = mysqli_fetch_array($getNameCityMaxTransactions)) {
    echo $res4['name'] . "<br>";
}
echo '<hr>';

echo '<table><tr><th>Транзакции внутри одного города: </th></tr></table>';
echo "<table><tr><th>Id</th><th>Отправитель</th><th>Получатель</th><th>Сумма</th></tr>";
for ($i = 0; $i < $getTransactionCityRows; ++$i) {
    $row = mysqli_fetch_array($getTransactionCity);
    echo "<tr>";
    for ($j = 0; $j < 4; ++$j) {
        echo "<td>$row[$j]</td>";
    }
    echo "</tr>";
}
echo "</table>";

