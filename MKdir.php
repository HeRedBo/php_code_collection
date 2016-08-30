<?php
	header("Content-type:text/html;charset=utf-8");
	/**
	 *php创建多级目录函数
	 *@param $path string 要创建的目录
	 *@param $mode int 要创建的目录模式 ，在window下忽略
	 */
	function create_dir($path,$mode = 0777){
		if(!is_dir($path)){
			#如果不存在目录，则不创建

			if(mkdir($path,$mode,true)){
				echo "目录创建成功！";
			}else{
				echo "目录创建失败！";
			}
		} else{
			echo "该目录已存在！";
		}
	}

create_dir("D:/www.php.com/Thinkphp/Uploads/Images/2015-05-11/thumb_image");

	/**
	 *php创建多级目录函数
	 *@param $path string 要创建的目录
	 *@param $mode int 要创建的目录模式 ，在window下忽略
	 */
	function create_dir2($path,$mode = 0777){
		if(!is_dir($path)){
			#如果不存在目录，则不创建
			mkdir($path,$mode,true);
		}
	}
