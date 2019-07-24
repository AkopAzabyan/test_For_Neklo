<?php
include("connectDB.php");
$result = mysqli_query($connection, "select * from transactions");
$result1 = mysqli_query($connection, "select * from transactions t join persons p on t.from_person_id=p.id  ");
$result2 = mysqli_query($connection, "select * from transactions t join persons p on t.to_person_id=p.id ");
$result3 = mysqli_query($connection, "SELECT `id`, `city_id`,`fullname`,
    Round((100 + IFNULL((SELECT SUM(`amount`) FROM `transactions` WHERE `to_person_id`=`persons`.`id`),0) - 
    IFNULL((SELECT SUM(`amount`) FROM `transactions` WHERE `from_person_id`=`persons`.`id`),0)),2) 
    as `balans` FROM `persons`");
$result4 = mysqli_query($connection, "SELECT  from_person_id, COUNT(*) as max_count from 
(SELECT from_person_id  from `transactions` AS t1 UNION ALL 
SELECT to_person_id  from `transactions` as t2)
as T GROUP BY from_person_id HAVING max_count > 2 ORDER by max_count DESC ");

$rows = mysqli_num_rows($result); // количество полученных строк

$personResult = mysqli_query($connection, "select * from persons");

$rowsPersons = mysqli_num_rows($personResult); // количество полученных строк

echo '<hr>';
echo "<table><tr><th>Id</th><th>Отправитель</th><th>Получатель</th><th>Сумма</th></tr>";
for ($i = 0; $i < $rows; ++$i) {
    $row = mysqli_fetch_array($result);
    echo "<tr>";
    for ($j = 0; $j < 4; ++$j) {
        echo "<td>$row[$j]</td>";
    }
    echo "</tr>";
}
echo "</table>";

echo '<hr>';
echo '<table><tr><th>Имена: </th></tr></table>';
while ($rowPersons = mysqli_fetch_array($personResult)) {
    echo $rowPersons['id'] . ' ' . $rowPersons['fullname'] . "<br>";
}

echo '<hr>';
echo '<table><tr><th>Отправители: </th></tr></table>';
while ($res = mysqli_fetch_array($result1)) {
    echo $res['from_person_id'] . ' ' . $res['fullname'] . ' ' . $res['amount'] . "<br>";
}

echo '<hr>';
echo '<table><tr><th>Получатели: </th></tr></table>';
while ($res1 = mysqli_fetch_array($result2)) {
    echo $res1['to_person_id'] . ' ' . $res1['fullname'] . ' ' . $res1['amount'] . "<br>";
}
echo '<hr>';

echo '<table><tr><th>Текущий баланс: </th></tr></table>';
while ($res2 = mysqli_fetch_array($result3)) {
    echo $res2['id'] . ' ' . $res2['fullname'] . ' ' . $res2['balans'] . "<br>";
}
echo '<hr>';

echo '<table><tr><th>Города,которые больше всех участвовали: </th></tr></table>';
while ($res3 = mysqli_fetch_array($result4)) {
    echo $res3['name'] . ' ' . $res3['from_person_id'] . ' ' . $res3['max_count'] . "<br>";
}
echo '<hr>';

/*SELECT  from_person_id, COUNT(*)  from (SELECT from_person_id from `transactions` AS t1 UNION ALL SELECT to_person_id  from `transactions` as t2) AS T GROUP BY from_person_id*/