<?php
	//无限极分类，生成树状结构
	function getTree($category,$c_id=0,$level=0)
	{
		static $result =array();
		foreach($category as $k => $v){
			if($v['c_id'] == $c_id){
				//有子分类
				$v['level'] = $level;
				$result[] = $v;
				unset($categroy[$k]);
				//递归实现查询子分类
				getTree($category,$v['id'],$level+1);
			}
		}
		return $result;
	}
