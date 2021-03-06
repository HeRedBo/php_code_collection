<?php

/**
 * 1、冒泡排序
 */
function bubble_sort($arr)
{
    if(is_array($arr)) {
        $len = count($arr);
        for ($i=0; $i < $len; $i++) {
            for ($j=1; $i < $len - $i; $j++) {
                if($arr[$j-1] > $arr[$j]) {
                    $temp       = $arr[$j-1];
                    $arr[$j-1]  = $arr[$j];
                    $arr[$j]    = $temp;
                }
            }
        }
        return $arr;
    }
}

/**
 * 4、选择排序
 *
 * @param array $arr
 */
function selectSort($arr)
{
    $len = count($arr);
    if($len > 1)
    {
        for ($i=0; $i < $len; $i++)
        {
            $p = $i;  //先假设最小的值的位置

            for ($j= $i + 1; $j < $len; $j++)
            {
                if($arr[$p] > $arr[$j])
                {
                    //比较，发现更小的,记录下最小值的位置；并且在下次比较时采用已知的最小值进行比较。
                    $p = $j;
                }
            }

            // 已经确定了当前的最小值的位置，保存到$p中。如果发现最小值的位置与当前假设的位置$i不同，则位置互换即可。
            if($p != $i)
            {
                $tmp = $arr[$p];
                $arr[$p] = $arr[$i];
                $arr[$i] = $tmp;
            }
        }
    }
    return $arr;
}

/**
 * 2、插入排序
 *
 * 将要排序的元素插入到已经 假定排序号的数组的指定位置。
 * @param array $arr
 */
function insertSort($arr)
{
    $len = count($arr);
    for($i=1; $i < $len; $i++) {
        //获得当前需要比较的元素值。
        $tmp = $arr[$i];
        //内层循环控制 比较 并 插入
        for($j=$i-1;$j>=0;$j--) {
            if($tmp < $arr[$j]) {
                //发现插入的元素要小，交换位置 将后边的元素与前面的元素互换
                $arr[$j+1] = $arr[$j];
                //将前面的数设置为 当前需要交换的数
                $arr[$j] = $tmp;
            } else {
                //如果碰到不需要移动的元素
                //由于是已经排序好是数组，则前面的就不需要再次比较了。
                break;
            }
        }
    }
    //将这个元素 插入到已经排序好的序列内。
    //返回
    return $arr;
}

/**
 * 3、快速排序
 *
 * @param array $arr
 */
function quickSort($arr)
{
    //先判断是需要继续进行
    $length = count($arr);
    if($length <= 1) {
        return $arr;
    }
    // 数组需要排序 选择第一个元素作为标尺
    $base_num    = $arr[0];
    $left_array  = [];
    $right_array = [];

    for ($i=0; $i <$length ; $i++) {
        if($base_num > $arr[$i])
            $left_arry[]   = $arr[$i];
        else
            $right_array[] = $arr[$i];
    }
    // 在分别对 左边 右边数组进行同样的排序处理方式
    // 递归调用这个函数 并记录结果
    $left_array  = quickSort($left_array);
    $right_array = quickSort($right_array);
    // 合并左边 标尺 右边
    return array_merge($left_array,array($base_num),$left_array);
}


/**
 * 二分法快速查找
 *
 * @param array $arr 需要查找的数组
 * @param int   $find 需要查找的对象
 * @return 返回数组下标的位置 不存在则返回false
 */
function getKeyInArray($arr, $find)
{
    $count = count($arr);
    if($count == 0) return false;

    $middleKey = floor($count/2);
    $middleValue = $arr[$middleKey];
    if($find == $middleValue)
        return $middleKey;

    if($middleValue < $find)
        return $middleKey + 1 + getKeyInArray(array_slice($arr,$middleKey + 1),$find);
    else
        return getKeyInArray(array_slice($arr,0,$middleKey),$find);

    return false;
}

/**
 * 二分查找
 *
 * @param array $array 需查找的数组
 * @param int   $low
 * @param int   $hignt
 * @param int   $find
 * @return 返回数组下标的位置 不存在则返回 -1
 */
function binSearch($array, $low, $hight, $find)
{
    if($low <= $hight)
    {
        $mid =  (int)(($low + $hight)/2);
        if($array[$mid] === $find)
            return $mid;
        else if($find < $array[$mid])
            return binSearch($array, $low, $mid - 1 ,$find);
        else
            return binSearch($array, $mid + 1,$hight, $find);
        return -1;
    }
}


//效率比较
for($i = 0;$i < 1000;$i++){
    $arr[] = mt_rand(0,100);
}

//比较时间
// var_dump($arr);
$before = microtime(true);
$arr2  = selectSort($arr);
//quick_sort($arr);
$after = microtime(true);
echo '程序执行时间', $after - $before ,'秒';
echo "<pre/>";
var_dump($arr2);
