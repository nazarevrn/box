<?php

//добавим индекс для color
// CREATE INDEX color ON products(color)

/*
 * сформируем массив, в котором перечислены цвета и насколько нужно
 * изменить цену товаров указанного цвета
*/

$data = [
    'red' => '0.95',
    'green' => '1.1',
];

//вариант 1. количество запросов = количеству цветов
foreach ($data as $color => $value) {
    //псевдозапуск команды используя query builder yii
    \Yii::$app->db->createCommand("UPDATE products SET price = price * :price_value WHERE color=':color'")
            ->bindValue(':price_value', $value)
            ->bindValue(':color', $color)
            ->execute();
}

//вариант 2. сгенерируем 1 запрос для всех цветов

$query = 'UPDATE
            products
        SET
            price = price *
            CASE';

foreach ($data as $color => $value) {
    $query .= "WHEN `color` = '$color' THEN $value ";
}

//ELSE 1 - для того, что бюы не изменить цену товаров, цвет которых не перечислен в params
$query .= 'ELSE 1
	END';
\Yii::$app->db->createCommand($query)->execute();
