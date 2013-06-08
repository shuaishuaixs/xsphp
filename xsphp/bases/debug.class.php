<?php
	class Debug{
		static $startTime;
		static $infos = array();
		//static $sqls = array();
		//static $includefile = array();
		static $stopTime;
/*		static $msg = array(
			E_WARNING =>'运行警告',
			E_NOTICE =>'运行提醒',
			E_STRICT =>'编码标准化警告',
			E_USER_ERROR =>'自定义错误',
			E_USER_WARNING =>'自定义警告',
			E_USER_NOTICE =>'自定义提醒',
			'Unknown' =>'未知错误'
		);
*/
		static function start(){
			self::$startTime = microtime(true);
			//echo self::$startTime;
		}

		static function stop(){
			self::$stopTime = microtime(true);
			//echo self::$stopTime;
			//$time = $stopTime - $startTime;
			//echo "<br>".$time;
		}

		static function spent(){
			return round((self::$stopTime - self::$startTime),5);
		}

		/*static function Cratcher($errno,$errstr,$errfile,$errline){
			if(!isset(self::$msg[$errno])){
				$errno = "Unknown";
			}

			$mess = '<font color="red">';
			$mess.= '<b>'.self::$msg[$errno]."</b>[在文件 {$errfile} 中，第 $errline 行 ]:";
			$mess.= $errstr;
			$mess.= '</font>';
			self::addmsg($mess);
		}*/

		static function addmsg($msg,$type = 0){
			/*if(defined("DEBUG") && DEBUG == 1){
				switch($type){
					case 0:
						self::$info[] = $msg;
						break;
					case 1:
						self::$includefile[] = $msg;
						break;
					case 2:
						self::$sqls[] = $msg ;
						break;
				}
			}*/
			self::$infos[] = $msg;
		}

		static function message(){
			echo '<br>';
			echo "<div style='border:1px solid black;width:600px;height:auto;margin:0 auto;'>";
			echo "<font size='5px'><b>trace</b>信息:</font>";
			//echo "<font color='red' size='8'>trace</font>";
			echo "<hr style='width:100%;size:2px'>";
			echo '<div>当前脚本执行时间: '.self::spent().' 秒</div>';
			/*foreach(self::$includefile as $file){
				echo $file;
				echo "<br>---------<br>";
			}*/

			foreach(self::$infos as $info){
				echo "<br>---------<br>";
				echo $info;
			}

			/*foreach(self::$sqls as $sql){
				echo $sql;
				echo "<br>---------<br>";
			}*/
			echo "</div>";
		}
	}	
?>
