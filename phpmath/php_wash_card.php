<?php
/**
 * php 洗牌算法
 */
/**
 * 洗牌算法
 * @param  int $card_numb 牌数目
 * @return 
 */
function washCard($card_num)
{
    $card = $tmp = [];
    for ($i=0; $i < $card_num; $i++) 
    { 
        $tmp[$i] = $i;
    }
    for ($i=0; $i < $card_num; $i++) 
    { 
        $index = rand(0,$card_num - $i -1);
        $card[] = $tmp[$index];
        unset($tmp[$index]);
        $tmp = array_values($tmp);
    }
    return $card;
}

$card_num = 54;
print_r(washCard($card_num));