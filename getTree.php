<?php
	//无限极分类，生成树状结构
	function getTree($category,$c_id=0,$level=0)
	{
		static $result =array();
		foreach($category as $key => $value){
			if($value['c_id'] == $c_id){
				//有子分类
				$value['level'] = $level;
				$result[] = $value;
				unset($categroy[$key]);
				//递归实现查询子分类
				getTree($category,$value['id'],$level+1);
			}
		}
		return $result;
	}
