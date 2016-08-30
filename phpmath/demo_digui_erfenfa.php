<?php

	//递归实现二分法


	/*
	 * 递归实现二分法
	 * @param1 array $arr，要查询的数组
	 * @param2 int $find，要查询的结果
	 * @return 当前值在数组中的下标位置，如果不存在则返回false
	*/
	function getKeyInArray($arr,$find){
		//判断数组：递归出口
		$len = count($arr);
		if($len == 0){
			//没有元素，所以查不到结果
			return false;
		}

		//取得中间元素
		$middle_key = floor($len/2);
		$middle_value = $arr[$middle_key];

		//比较中间元素值
		if($middle_value == $find){
			//找到值
			return $middle_key;
		}else{
			//判断大小
			if($middle_value < $find){
				//要查找的结果在右边 array_slice:从数组中取出一段数据
				return $middle_key + 1 + getKeyInArray(array_slice($arr,$middle_key + 1),$find);
			}else{
				//要查找的结果在左边
				return getKeyInArray(array_slice($arr,0,$middle_key),$find);
			}
		}

		//最后没有找到结果
		return false;
	}

	//调用二分法函数进行处理
	$arr = array(1,2,3,4,5,6,7,8,9,10);

	$res = getKeyInArray($arr,1);
	var_dump($res);

	/**
	 * 二分法测试函数
	 * @author Red-Bo
	 * @date   2016-08-30
	 * @param  [array]    $arr  [需要查询的数组]
	 * @param  [type]     $find [需要查询的值]
	 * @return [type]   返回数组的小标位置 如果没有则返回false
	 */
	function getKeyInArrayTest($arr, $find)
	{
		$count = count($arr);
		if($count == 0)
			return false;

		$middleKey = floor($count/2);
		$middleValue = $arr[$middleKey];
		if($find == $middleValue) return $middleKey;

		if($middleValue < $find)
			return $middleKey + 1 + getKeyInArrayTest(array_splice($arr,$middleKey + 1,$find));
		else
			return getKeyInArrayTest(array_slice($arr,0,$middleKey),$find);

		return false;
	}
