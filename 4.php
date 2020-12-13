<?php

//добавим индекс для color
// CREATE INDEX color ON products(color)

/*сформируем массив, в котором перечислены цвета и насколько нужно
изменить цену товаров указанного цвета
*/

$data = [
    'red' => '0.95',
    'green' => '1.1',
];

foreach ($data as $color => $value) {
    //псевдозапуск команды используя query builder yii
    \Yii::$app->db->createCommand("UPDATE products SET price = price * :price_value WHERE color=':color'")
            ->bindValue(':price_value', $value)
            ->bindValue(':color', $color)
            ->execute();
}