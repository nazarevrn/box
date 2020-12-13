<?php
/**
 * Напишите PHP скрипт в который через GET передаются две даты,
 * а скрипт должен рассчитать сколько вторников было между ними.
 *
 * Ищем вторник. Ну или можно задать номер любого дня недели (от 1 до 7)
 */

$searchedDayNum = 2;

$first = $_GET['first'] ?? null;
$second = $_GET['second'] ?? null;

$result = 0;
if ($first && $second) {
    /**
     * не делаю сразу new DateTime(), что бы была возможность сравнить
     * 2 числа и переставить их местами. с объектами это сложнее.
     */
    $firstU = strtotime($first);
    $secondU = strtotime($second);
    if (is_int($firstU) && is_int($secondU)) {
        $diff = $firstU <=> $secondU;
        if ($diff === 1) {
            $temp = $firstU;
            $firstU = $secondU;
            $secondU = $temp;
        }

        $begin = DateTimeImmutable::createFromFormat('U', $firstU);
        $end = DateTimeImmutable::createFromFormat('U', $secondU);
        //что бы включить границы интервала
        $end = $end->modify('+1 day');
        $countDays = $begin->diff($end)->days;
        $i = 1;
        while ($i <= $countDays) {
            $step = 1;
            if ((int)$begin->format('N') === $searchedDayNum) {
                $result++;
                //переходим к следующей неделе
                $begin = $begin->modify('+7 days');
                $step = 7;
            } else {
                $begin = $begin->modify('+1 day');
            }

            $i += $step;
        }
    }
}

print $result;