<?php

	//PHP冒泡算法

	//待排序数组
	$arr = array(10,3,8,5,2,0);

	//冒泡排序
	//外层循环控制层数：控制冒泡多少次
	for($i = 0,$len = count($arr);$i < $len;$i++)
	{
		//内存循环用来比较相邻的两个元素，看谁大，大的交换到后面
		for($j = 0;$j < $len - 1 - $i;$j++)
		{
			//相邻的进行比较
			if($arr[$j] > $arr[$j+1])
			{
				//交换
				$temp = $arr[$j];
				$arr[$j] = $arr[$j+1];
				$arr[$j+1] = $temp;
			}
		}
	}

	var_dump($arr);
	/*
	i = 0;j = 0; $arr[$j] = 10;$arr[$j+1] = 3;
	10 > 3：交换 arr = array(3,10,8,5,2,0)

	i = 0;j = 1; $arr[$j] = 10;$arr[$j+1] = 8;
	10 > 8;交换 arr = array(3,8,10,5,2,0);

	i = 0;j = 5；不满足条件，循环结束

	i = 1;j = 0


	*/
