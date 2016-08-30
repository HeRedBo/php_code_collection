<?php
	/**
	 *文件件遍历函数
	 *@param string $dir，要遍历的文件夹（路径）
	 *@param int $level = 0，函数被调用的层数
	 */
	function myScandir($dir){
		//定义一个空数组来存储文件内容
		$files = array();
		//判断传递过来的值是否是一个文件目录
		if(is_dir($dir)){
			//打开文件目录 得到目录的资源对象
			if($tmp  = opendir($dir)){
				//遍历并判断
				while ($file = readdir($tmp)){
					if($file!='.'&&$file!=".."){
						if(is_dir($dir."/".$file)){
							$files[$file] = myScandir($dir."/".$file);
						}else{
							$files[]=$file;
						}
					}
				}
				//文件遍历结束
				closedir($tmp);
				return $files;
			}
		}
	}
	$dir = "D:/wamp";
	var_dump(myScandir($dir));
