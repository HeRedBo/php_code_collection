<?php
// php5.5新特性之yield理解
/**
 * 计算平方数列
 * @param $start
 * @param $stop
 * @return Generator
 */
function squares($start, $stop) {
    if ($start < $stop) {
        for ($i = $start; $i <= $stop; $i++) {
            yield $i => $i * $i;
        }
    }
    else {
        for ($i = $start; $i >= $stop; $i--) {
            yield $i => $i * $i; //迭代生成数组： 键=》值
        }
    }
}
foreach (squares(3, 15) as $n => $square) {
    echo $n . ' squared is ' . $square . '<br/>';
}

