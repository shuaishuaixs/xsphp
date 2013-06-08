<?php
	class Model extends db{
		private $host = HOST;
		private $user = USER;
		private $pass = PASS;
		private $database = DBNAME;
		//public $tabName;

		//实例化之后自动连接数据库
		function __construct($tabName){
			$this->tabName = $tabName;
			//echo $tabName;
			self::connect($this->host,$this->user,$this->pass,$this->database);
			//echo "fail";
			//$this->close();
		}
		function __destruct(){
			//$this->close($link);
			//echo "2122222222";
		}

		//获取私有变量
		public function __get($pro){
			if($pro == "host"){
				return $this->host;
			}elseif($pro == "user"){
				return $this->user;
			}elseif($pro == "pass"){
				return $this->pass;
			}elseif($pro == "database"){
				return $this->database;
			}elseif($pro == "tabName"){
				return $this->tabName;
			}
		}

		//数据库连接
		static function connect($host,$user,$pass,$database){
			$link = mysql_connect($host,$user,$pass) or die("数据库连接失败!:".mysql_error());
			mysql_select_db($database) or die("数据库选择失败:".mysql_error());
		}

		//SQL操作
		function query($sql,$method){
			mysql_query("SET NAMES UTF8");
			$sql = trim($sql);
			$method = trim($method);
//			$result = mysql_query($sql);
			if($method == "FIND"){
				//返回带键值的数组
				$result = mysql_query($sql);
				$query_result = mysql_fetch_assoc($result);
				//print_r($query_result);
			}elseif($method == "INSERT"){
				//返回最新插入的ID
				//mysql_query("SET NAMES UTF8");
				$result = mysql_query($sql);
				$query_result = mysql_insert_id();
				//dump($sql);
			}elseif($method == "UPDATE" || $method == "DELETE"){
				//返回bool值
				//mysql_query("SET NAMES UTF8");
				$query_result = mysql_query($sql);
			}elseif($method == "SELECT"){
				//echo $sql."<br>";
				//mysql_query("SET NAMES UTF8");
				$result = mysql_query($sql);
				//dump($result);
				if($result == false){
					$query_result = false;
				}else{
					while($row = mysql_fetch_assoc($result)){
					$query_result[] = $row;
				}
			}
				//dump($result);
			}elseif($method == "TOTAL"){
				$result = mysql_query($sql);
				$row = mysql_fetch_assoc($result);
				$query_result = $row['count'];
				
				//$query_result = count($data);
				//echo count($data);
			}
			
			return $query_result;

		}

		//自定义sql语句
		function sql($sql){
			$sql = trim($sql);
			$sql_array = explode(" ",$sql);
			$firstWord = strtoupper($sql_array[0]);
			$array = array("SELECT","UPDATE","DELETE","INSERT");
			if(!in_array($firstWord,$array)){
				Debug::addmsg("<font color='red'>请检查sql语句</font>");
			}else{
				if($firstWord == "SELECT"){
					$result = mysql_query($sql);
					while($row = mysql_fetch_assoc($result)){
						$sql_result[] = $row;
					}
				}elseif($firstWord == "UPDATE" || $firstWord == "DELETE"){
					$result = mysql_query($sql);
					//echo $sql;
					$sql_result = $result;
				}elseif($firstWord = "INSERT"){
					$result = mysql_query($sql);
					$sql_result = mysql_insert_id();
				}else{
					echo "wrong";
				}
			}
			return $sql_result;
		}
	}
?>
