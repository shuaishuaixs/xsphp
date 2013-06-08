<?php
	/*
	 *项目目录结构创建类
	 *用于创建所需目录和相关文件
	 * */
	class Structure{
		static $mess = array();			//提示信息

		//创建文件函数
		static function touch($fileName, $str){
			if(!file_exists($fileName)){
				/**/				
				/*if(file_put_contents($fileName, $str)){
					self::$mess[] = "创建文件 {$fileName} 成功。";
				}*/
				file_put_contents($fileName,$str);
			}
 
//				file_put_contents($fileName,$str);
		}

		//目录创建函数
		//mkdir($fileName,"0755")
		// the first number is always 0
		// the second number specifies permissions for owner
		// the third number specifies permissions for user group
		// the fourth number specifies permissions for everyone else
		// 1 = execute permission
		// 2 = write permission
		// 4 = read permission
		// 0755 = 0 rwx-rx-rx
		static function mkdir($dirs){
			foreach($dirs as $dir){
				if(!file_exists($dir)){
					/*if(mkdir($dir,"0755")){
						self::$mess[] = "创建目录 {$dir} 成功。";
					}*/
					mkdir($dir,"0755");
				}
			}
		}
		
		//创建项目所需文件
		static function make(){
			$dirs = array(
				PROJECT_PATH.APP,
				PROJECT_PATH.APP."/Action",
				PROJECT_PATH.APP."/Model",
				PROJECT_PATH.APP."/View",
				PROJECT_PATH.APP."/View/index",
				PROJECT_PATH.APP."/View/public",
				PROJECT_PATH.APP."/Public",
				PROJECT_PATH.APP."/Public/css",
				PROJECT_PATH.APP."/Public/js",
				PROJECT_PATH.APP."/Public/images",
				PROJECT_PATH.APP."/Public/upload",
				PROJECT_PATH."function",
				PROJECT_PATH."libs",
				PROJECT_PATH."runtime",
				PROJECT_PATH."runtime/".APP,
				PROJECT_PATH."runtime/".APP."/templates_c",
				PROJECT_PATH."runtime/".APP."/cache",
				PROJECT_PATH."public",
				PROJECT_PATH."public/css",
				PROJECT_PATH."public/js",
				PROJECT_PATH."public/images",
				PROJECT_PATH."public/upload",
//				PROJECT_PATH."config",
			);
			self::mkdir($dirs);
		}


		static function create(){
			self::make();	
			self::mkdir(array(PROJECT_PATH."config"));
			$fileName = PROJECT_PATH."config/config.php";
			if(!file_exists($fileName)){
					$str = <<<xs
<?php
	define("DEBUG",1);			//调试开启 1为开启 0为关闭
	define("HOST","localhost");		//数据库主机
	define("USER","");			//数据库用户
	define("PASS","");			//数据库密码
	define("DBNAME","");			//数据库名字
	define("TABFREFIX","xs_");		//表前缀
	define("CSTART",0);			//缓存开启 1为开启 0为关闭
	define("CTIME",60*60*24);		//缓存时间为一天
	define("DEFAULT_ACTION","welcome");	//设置默认方法
?>
xs;
				self::touch($fileName,$str);

			}

			if(!defined("DEBUG")){
				include $fileName;
			}
			
			$str = <<<xs
<?php
	class Index extends Action{
		function welcome(){
			echo "<div style='text-align:center'><font size='12px'><b>欢迎使用XSPHP框架</b></font></div>";
		}
	}
?>
xs;
			$mainclass = APP_PATH."Action/index.class.php";
			if(!file_exists($mainclass)){
				self::touch($mainclass,$str);
			}

			$successfile = XSPHP_PATH."common/success.html";
			$newsuccessfile = PROJECT_PATH.APP."/View/public/"."success.html";
			if(!file_exists($newsuccessfile)){
				//echo $successfile;
				copy($successfile,$newsuccessfile);
			}
				

				
			
		}
	}
?>
