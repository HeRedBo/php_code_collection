<?php
/**
 * n只猴子围坐成一个圈，按顺时针方向从1到n编号。然后从1号猴子开始沿顺时针方向从1开始报数，报到m的猴子出局，再从刚出局猴子的下一个位置重新开始报数，如此重复，直至剩下一个猴子，它就是大王。
 */

/**
 * 猴子选择大王算法 (最终算法)
 * @author Red-Bo
 * @date   2016-09-02
 * @param  int     $n  猴子数量
 * @param  int     $m  出局猴子数字
 * @return int     返回最后的猴子序号
 */
function getLeader($n, $m)
{
    $res = 0;
    for($i=2; $i<=$n; $i++)
    {
        $res = ($res + $m) % $i;
    }
    return $res+1;
}

//定义函数
function getKing($monkeys , $m , $current = 0)
{
    $number = count($monkeys);
    $num    = 1;
    if(count($monkeys) == 1)
    {
        echo '<font color="red">编号为'.$monkeys[0].'的猴子成为猴王了!</font>';
        return;
    }
    else
    {
        while($num++ < $m)
        {
            $current ++;
            $current = $current % $number;
        }

        echo "编号为".$monkeys[$current]."的猴子被踢掉了...<br/>";
        array_splice($monkeys , $current , 1);
        getKing($monkeys , $m , $current);
    }
}


$n=5;      //总共猴子数目
$m = 2;    //数到第几只的那只猴子被踢出去
$monkeys = range(1,$n); //将猴子编号放入数组中
getKing($monkeys , $m);     //调用函数

//echo getLeader(5,2);


/**
* 猴子选大王
*
* @param int $m 猴子数
* @param int $n 出局数
* @return array
*/
function king($m ,$n)
{
    //构造数组
    for($i=1 ;$i<$m+1 ;$i++){
        $arr[] = $i ;
    }
    $i = 0 ;    //设置数组指针
    while(count($arr)>1)
    {
        //遍历数组，判断当前猴子是否为出局序号，如果是则出局，否则放到数组最后
        if(($i+1)%$n ==0) {
            unset($arr[$i]) ;
        } else {
            array_push($arr ,$arr[$i]) ; //本轮非出局猴子放数组尾部
            unset($arr[$i]) ;   //删除
        }
        $i++ ;
    }
    return $arr ;
}

//var_dump(king(5,2)); // [3];
