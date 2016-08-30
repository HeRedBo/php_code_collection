<?php

	//PHP快速排序
	header('Content-type:text/html;charset=utf-8');
	set_time_limit(0);

	//带排序数组
	$arr = array(3,8,5,4,1);

	/*
	 * 快速排序函数
	 * @param1 array $arr，待排序的数组
	 * @param2 bool $asc = true，默认升序排序
	 * @return array，已经排好序的数组
	*/
	function quick_sort($arr){
		//判断数组元素：如果小于1，那么直接返回
		$len = count($arr);
		if($len <= 1){
			//*递归出口：数组元素小于1
			return $arr;
		}

		//数组长度大于1：取出第一个元素，当做中间值
		$middle = $arr[0];

		//遍历数组，进行比较
		$left = $right = array();
		for($i = 1;$i < $len;$i++){
			//判断：比$middle小的放左边数组；大的放右边数组
			if($arr[$i] < $middle){
				$left[] = $arr[$i];
			}else{
				$right[] = $arr[$i];
			}
		}


		//递归点：left和right都是无序数组，与父问题一致，规模较小
		$left = quick_sort($left);
		$right = quick_sort($right);

		//合并数组：进行返回
		return array_merge($left,array($middle),$right);
	}


	//调用
	//print_r(quick_sort($arr));


	/*
	 * 冒泡排序
	 * @param1 array $arr
	 * @return array
	*/
	function bubble_sort($arr){
		//外层控制次数
		$len = count($arr);
		for($i = 0;$i < $len;$i++){
			//内层控制当前最大的泡
			for($j = 0;$j < $len - 1 - $i;$j++){
				//比较判断
				if($arr[$j] > $arr[$j + 1]){
					//交换位置
					$temp = $arr[$j];
					$arr[$j] = $arr[$j + 1];
					$arr[$j + 1] = $temp;
				}
			}
		}

		//返回
		return $arr;
	}

	//调用
	//print_r(bubble_sort($arr));


	//效率比较
	for($i = 0;$i < 100000;$i++){
		$arr[] = mt_rand(0,100000);
	}

	//比较时间
	$before = time();
	bubble_sort($arr);
	//quick_sort($arr);
	$after = time();

	echo $after-$before,'秒';