<?php
	header("Content-type:text/html;charset=utf-8");
	/**
	 * 单例数据库连接类 连接数据库 基本实现数据库的增删改查
	 */
	class SingleDB {
		//定义属性
		private $host;
		private $port;
		private $user;
		private $pass;
		private $charset;
		private $dbname;
		private $link;
		static private $_instance;
		
		/**
		 * 构造方法 初始化属性
		 * 设置为私有 不允许通过new获取对象
		 * @param array $arr 包含是所有属性的关联数组
		 */
		private  function __construct($arr){
			//初始化属性：用户如果没有使用默认值
			$this->host = isset($arr['host']) ? $arr['host']:'localhost';
			$this->port = isset($arr['port']) ? $arr['port']:'3306';
			$this->user = isset($arr['user']) ? $arr['user']:'root';
			$this->pass = isset($arr['pass']) ? $arr['pass']:'root';
			$this->charset = isset($arr['charset']) ? $arr['charset']:'utf8';
			$this->dbname = isset($arr['dbname']) ? $arr['dbname']:'itshop';

			//连接数据库
			$this->db_connect();
			//设置字符集
			$this->db_charset();
			//选择数据库
			$this->db_selectdb();
		}

		//获取实例的方法
		public static function getInstance($arr){
			if(!self::$_instance instanceof self){
				self::$_instance = new self($arr);
			}
			return self::$_instance;
		}
		//禁止克隆
		private function __clone(){}

		/**
		 * 连接数据库
		 */
		private function db_connect(){

			error_reporting(E_ALL ^ E_DEPRECATED);
			$this->link = mysql_connect($this->host.':'.$this->port,$this->user,$this->pass);
			//判断：连接失败
			
			if(!$this->link){
				//连接失败
				/*echo "数据库连接失败！<br/>";
				echo '错误编号！',mysql_errno(),'<br/>';
				echo '错误信息！',mysql_error(),'<br/>';*/
				throw new Exception('数据库连接失败!['.mysql_errno().']'.mysql_error());
				exit;
			}
		}

		/**
		 * 设置数据库字符集
		 */
		private  function db_charset(){
			$this->db_query('set names '.$this->charset);
		}

		/**
		 * 选择数据库
		 */
		private function db_selectdb(){
			$this->db_query('use '.$this->dbname);
		}

		/**
		 * 封装mysql_queryd方法
		 * @param string $sql 要执行的sql语句
		 * @return  obj $res 返回连接资源
		 */
		private function db_query($sql){
			if(!is_string($sql) ||empty($sql)){
				throw new Exception("参数错误,执行参数不能为空且必须是字符串！");
				exit;
			}
			$res = mysql_query($sql);
			//执行错误
			if(!$res){
				/*echo "sql 执行错误<br/>";
				echo "错误编号！",mysql_errno(),'<br/>';
				echo '错误信息！',mysql_error(),'<br/>';*/
				throw new Exception('['.mysql_errno().']'.mysql_error());
				exit;
			}
			//返回资源
			return $res;
		}
		
		/********************封装数据库基本的增删改查*********************/
		/**
		 * 数据插入方法
		 * @param string $sql 要执行的sql语句
		 * @return int 受影响的函数或者id
		 */
		private function db_insert($sql){
			//执行sql语句
			$this-db_query($sql);
			$id = mysql_insert_id();
			$row = mysql_affected_rows();
			//数据返回
			return isset($id) ? $id : ($row ? $row : 'false');

		}

		/**
		 * 单行数据查询
		 * @param  string $sql 要执行的sql语句
		 * @return array||boolen $result 返回查询结果
		 */
		public function db_selectOne($sql){
			$res = $this->db_query($sql);
			$row = mysql_fetch_assoc($res);
			return $row;
		}

		/**
		 * 多行数据查询
		 * @param  string $sql 要执行的sql语句
		 * @return array||boolen $result 返回查询结果
		 */
		public function db_selectAll($sql){
			$res = $this->db_query($sql);
			$rows = array();
			while($row = mysql_fetch_assoc($res)){
				$rows[] = $row;
			}
			return $rows;	
		}

		/**
		 * 更新修改操作方法
		 * @param  string $sql 要执行的sql语句
		 * @return int $result 返回受影响的行数
		 */
		public function db_update($sql){
			$res = $this->db_query($sql);
			return mysql_affected_rows();
		}

		/**
		 * 数据修改操作
		 * @param  string $sql 要执行的sql语句
		 * @return int $result 返回受影响的行数
		 */
		public function  db_alert($sql){
			$this->db_update($sql);
		}

		/**
		 * 数据删除方法
		 * @param sting $sql 要执行的sql语句
		 * @return int 返回受影响的行数
		 */
		
		public function db_delete(){
			//执行sql语句
			$res = $this->db_query($sql);
			//返回
			return mysql_affected_rows();

		}
		

	}

	/*$db =  SingleDB::getInstance(array());
	$sql ="select * from yii_user";
	$res = $db->db_selectAll($sql);
	// //$update = "update yii_user set username = 'admin' where user_id = 1";
	$res = $db->db_update($update);*/
	// var_dump($res);
