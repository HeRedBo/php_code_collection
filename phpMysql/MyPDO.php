<?php 
	//MyPDO类 单例模式

	class MyPDO{
		//属性
		private $type;
		private $host;
		private $port;
		private $user;
		private $pass;
		private $dbname;
		private $charset;
		static private $_pdo; //pdo对象	
		static private $_pdoInstance; 	//MyPdo类实例

		//构造方法 私有
		private function __construct($arr=array()){
			//初始化属性
			$this->type 	= isset($arr['type']) ? $arr['type'] : 'mysql';
			$this->host 	= isset($arr['host']) ? $arr['host'] : 'localhost';
			$this->port 	= isset($arr['port']) ? $arr['port'] : '3306';
			$this->user 	= isset($arr['user']) ? $arr['user'] : 'root';
			$this->pass 	= isset($arr['pass']) ? $arr['pass'] : 'root';
			$this->dbname 	= isset($arr['dbname']) ? $arr['dbname'] : 'baobao360';
			$this->charset 	= isset($arr['charset']) ? $arr['charset'] : 'utf8';

			//初始化数据库连接
			$this->db_conncet();
			//设置错误处理模式为异常模式
			$this->db_setErrorMode();
		}

		//私有化克隆方法
		private function  __clone(){}

		//获取pdo对象的方法
		public static function getPdoInstance($arr =array()){
			if(!self::$_pdoInstance instanceof self){
				self::$_pdoInstance = new self($arr);
			}
			return self::$_pdoInstance;
		}

		//数据库链接方法
		private function db_conncet(){
			$dsn = "{$this->type}:host={$this->host};port={$this->port};charset={$this->charset};dbname={$this->dbname}";
			try {
				$this->pdo = new PDO($dsn,$this->user,$this->pass);
			} catch (PDOException $e) {
				//将错误写入日志文件
				$fp = fopen("error.log", "a+");
				$content = date("Y-m-d").' ['.$e->getCode().']'.'  content:'.$e->getMessage().' in file '.basename($_SERVER['SCRIPT_NAME']).' on line '.$e->getLine() .''."\r\n";			
				fwrite($fp, $content);
				fclose($fp);
				//测试 将错误信息数据
				echo "数据库链接失败","<br/>";
				echo "错误编号是:",$e->getCode(),"<br/>";
				echo "错误信息是:",$e->getMessage(),"<br/>";
				echo "错误代码行:",$e->getLine();
				exit;
			}
		}

		//设置异常处理模式
		private function db_setErrorMode(){
			$this->pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		}

		//数据库的增删改查方法
		/**
		 * 查询一条记录
		 * @param string $sql 要执行的sql
		 * @return array|boolen
		 */
		public function db_getOne($sql){
			
			$stmt = $this->db_error($sql);
			if(!$stmt) return false;
			return $stmt->fetch(PDO::FETCH_ASSOC);
		}

		public function db_getAll($sql){
			$stmt = $this->db_error($sql);
			if(!$stmt) return false;
			return $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		
		/**
		 * query 错误处理方法
		 * @param string $sql
		 * @return object-PDOStatement|boolen
		 */
		private function db_error($sql){
			//交给pdo类的query 方法执行
			try {
				return $this->pdo->query($sql);
			} catch (PDOException $e) {
				//错误信息写入错误日志文件
				$fp = fopen("error.log", "a+");
				$content = date("Y-m-d").' ['.$e->getCode().']'.'  content:'.$e->getMessage().' in file '.basename($_SERVER['SCRIPT_NAME']).' on line '.$e->getLine() .''."\r\n";			
				fwrite($fp, $content);
				fclose($fp);
				//测试 将错误信息数据
				echo "SQL执行失败","<br/>";
				echo "错误编号是:",$e->getCode(),"<br/>";
				echo "错误信息是:",$e->getMessage(),"<br/>";
				echo "错误代码行:",$e->getLine();

				//返回错误
				return false;
				exit;
			}
		}
		
		//增删改操作
		public function db_exec($sql){
			//异常捕获
			try {
				return $this->pdo->exec($sql);
			} catch (PDOException $e) {
				//将错误写入日志文件
				$fp = fopen("error.log", "a+");
				$content = date("Y-m-d").' ['.$e->getCode().']'.'  content:'.$e->getMessage().' in file '.basename($_SERVER['SCRIPT_NAME']).' on line '.$e->getLine() .''."\r\n";			
				fwrite($fp, $content);
				fclose($fp);
				//测试 将错误信息数据
				echo "SQL执行失败","<br/>";
				echo "错误编号是:",$e->getCode(),"<br/>";
				echo "错误信息是:",$e->getMessage(),"<br/>";
				echo "错误代码行:",$e->getLine();
				//返回错误
				return false;
				exit;
			}
		}

		/**
		 * 增删改操作
		 * @param  string  $sql [description]
		 * @return boolen|int 返回受影响的行或者boolen
		 */
		public function db_lastInsertId(){
			return $this->pdo->lastInsertId();
		}
		
	}

	$pdo = MyPDO::getPdoInstance();
	//查询操作
	//$sql = "select user_id,user_name,sex,email from ecs_users limit 10";
	//修改操作测试
	$sql = "update ecs_users set last_ip ='14.152.79.195' where user_id = 171";
	$result = $pdo->db_exec($sql);
	var_dump($result);

	
