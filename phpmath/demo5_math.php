<?php 
/**
 * 有5个人偷了一堆苹果，准备在第二天分赃。晚上，有一人遛出来，把所有菜果分成5份，但是多了一个，
 * 顺手把这个扔给树上的猴了，自己先拿1/5藏了。没想到其他四人也都是这么想的，都如第一个人一样分
 * 成5份把多的那一个扔给了猴，偷走了1/5。第二天，大家分赃，也是分成5份多一个扔给猴了。最后一人分了一份。
 * 问：共有多少苹果？
 */

// 参考代码

for ($i=1; ; $i++) { 
   if($i%5 == 1) 
   {
        //第一个人取走五分之一 还剩 $t
        $t = $i - round($i / 5) -1 ;
        if($t % 5 == 1)
        {
            // 第二个去五分之一 还剩$t 
            $r = $t - round($t / 5) - 1;
            if($r % 5 == 1) 
            {
                // 第三天五分之一 还剩 $s
                $s = $r - round($r / 5) - 1;
                if($s % 5 == 1) 
                {
                    // 第四人 取走五分之一 还剩$x 
                    $x = $s - round($s / 5) - 1;
                    if($x % 5 == 1) 
                    {   
                        $y = $x - round($x /5) -1;
                        if($y % 5 == 1) 
                        {
                            echo $i;
                            break;
                        } 
                    }
                }
            }
        }
   }
}

// result = 15621

/**
 * 一群猴子排成一圈，按1，2，…，n依次编号。然后从第1只开始数，数到第m只,把它踢出圈，从它后面再开始数，
 * 再数到第m只，在把它踢出去…，如此不停的进行下去，直到最后只剩下一只猴子为止，那只猴子就叫做大王。
 * 要求编程模拟此过程，输入m、n, 输出最后那个大王的编号。
 */

// 示例代码

function king($n , $m)
{
    $mokeys = range(1,$n);
    $i = 0;
    $k = $n;
    while (count($mokeys) > 1) 
    {
       if(($i + 1) % $m  == 0)
       {
            unset($mokeys[$i]);
       } 
       else 
       {
            array_push($mokeys, $mokeys[$i]);
            unset($mokeys[$i]);
       }
       $i ++ ;
    }
    return current($mokeys);
}

$a = king(5 ,2 );

echo "<br/>";
echo $a;