<?php
// 描述顺序查找和二分查找（也叫做折半查找）算法，顺序查找必须考虑效率，对象可以是一个有序数组（小米）

/**
 * 顺序查找
 * @param array $arr 数组
 * @param mixed $k 要查找的元素
 * @return mixed 成功返回数组下标，失败返回-1
 */
function seq_sch($arr, $k)
{
    $n = count($arr);
    for ($i = 0; $i < $n; $i ++)
    {
        if($arr[$i] == $k)
            break;
    }
    if($i < $n)
        return $i;
    else
        return -1;
}

/**
 * 二分查找，要求数据已经排序
 * @param array $array 数组
 * @param int $low 数组的起始坐标
 * @param int $high 数组的末尾坐标
 * @param mixed $k 要查找的元素
 * @return mixed 成功返回数组下标，失败返回-1
 */
function bin_sch($array, $low, $high, $k)
{
    if($low <= $high)
    {
        $mid = (int) (($low + $high) / 2);
        if($array[$mid] == $k)
            return $mid;
        else if ($k < $array[$mid])
        {
            return bin_sch($array,$low, $mid -1, $k);
        }
        else
        {
            return bin_sch($array, $mid +1, $high, $k);
        }
    }
    return -1;
}

// 测试：顺序查找
$arr1 = array(9,15,34,76,25,5,47,55);
echo seq_sch($arr1,47);//结果为6

echo "<br />";

// 测试：二分查找
$arr2 = array(5,9,15,25,34,47,55,76);
echo bin_sch($arr2,0,7,47);//结果为5