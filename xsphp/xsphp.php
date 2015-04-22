<?php
	/*
	 *框架主入口文件
	 * */
	header("Content-Type:text/html;charset=utf-8");	//设置编码格式为UTF-8
	session_start();
	date_default_timezone_set("PRC");		//设置时区（中国）
	define("XSPHP_PATH",rtrim(XSPHP,"/")."/");	//定义框架路径
//	define("APP_PATH",rtrim(APP,"/")."/");		
	define("PROJECT_PATH",dirname(XSPHP_PATH)."/");	//网站根路径
	define("APP_PATH",PROJECT_PATH.APP."/");	//用户项目应用路径
	define("RUNTIME_PATH",PROJECT_PATH."runtime/");	//网站缓存文件路径

	require_once XSPHP_PATH."bases/init.class.php";	//加载目录包含类
	init::set_path();				//设置目录包含
	Structure::create();				//创建应用目录及文件
	Prourl::paresUrl();				//处理当前URL

	function __autoload($className){		//自动加载类函数
		if($className == "Smarty"){	
			include_once "Smarty.class.php";	//如果是Smarty，加载Smarty类
		}else{
			include_once strtolower($className).".class.php";	//加载其他类
		}			
	}


	$config = PROJECT_PATH."config/config.php";	//系统配置文件
	if(file_exists($config)){
		require_once $config;			//加载配置文件
	}



		 if(defined("DEBUG") && DEBUG == 1){
			 $GLOBALS["debug"] = 1;
			 error_reporting(E_ALL ^ E_NOTICE);	//输出除提醒错误以外的所有错误报告
			 include_once "debug.class.php";
			 Debug::start();
			 //set_error_handler(array("Debug","Catcher"));
		 }else{
			 ini_set("display_errors","Off");	//屏蔽错误输出
			 ini_set("log_errors","On");		//开启错误日志，将错误报告写入日志中
			 ini_set("error_log",PROJECT_PATH.APP."/error_log.txt");	//指定错误日志文件
		 }

		 $functionfile = XSPHP_PATH."common/function.inc.php";
		 include $functionfile;				//加载框架公共函数文件
		 $funfile = PROJECT_PATH.APP_PATH."functions/function.php";
		 //echo $functionfile."<br>";
		 if(file_exists($funfile)){
		 	include $funfile;			//加载自定义函数
		 }

		 if(CSTART == 0){				//判断是否开启页面静态缓存
			 Debug::addmsg("<font color='red'>没有开启页面缓存!</font>(建议使用缓存)");
		 }else{
			 //echo CSTART."<br>";
			 Debug::addmsg("已开启页面缓存，实现页面静态化");
		 }

		 //$str = dirname($_SERVER['SERVER_NAME'])."/";
		 //echo dirname(dirname(__FILE__))."<br>";
		 //$root = str_replace(":\'",":/",$str);
		 //$port = $_SERVER['HTTP_HOST']."/";
		 //echo $port."<br>";
		 //echo $str;
		 //$rootpath = $_SERVER['DOCUMENT_ROOT'];
		 //echo $rootpath."<br>";
		 //$GLOBALS['ROOT'] = $port.trim(dirname($_SERVER['SCRIPT_NAME']),"/")."/";
		 //$GLOBALS['ROOT'] = $rootpath.trim(dirname($_SERVER['SCRIPT_NAME']),'/').'/';
		 $GLOBALS['ROOT'] = dirname($_SERVER['SCRIPT_NAME'])."/";
		 //$GLOBALS['ROOT'] = dirname($_SERVER['SERVER_NAME'])."/";
		 //echo $GLOBALS['ROOT']."<br>";
		 //$GLOBALS['ROOT'] = dirname(dirname(__FILE__))."/";
		 $GLOBALS['APP'] = $_SERVER['SCRIPT_NAME']."/";
		 //echo $GLOBALS['APP'];
		 $GLOBALS['URL'] = $GLOBALS['APP'].$_GET['m']."/";
		 $GLOBALS['PUBLIC'] = $GLOBALS['ROOT']."public/";
		 $GLOBALS['RES'] = $GLOBALS['ROOT'].APP."/Public/";
		 //echo $GLOBALS['PUBLIC']."<br>";
		 //echo $GLOBALS['RES'];

		$srccontrollerfile = APP_PATH."Action/".strtolower($_GET['m']).".class.php";	//当前控制器文件

		Debug::addmsg("当前访问的控制器类是应用目录下的：<b>$srccontrollerfile</b> 文件!");
		
		if(file_exists($srccontrollerfile)){
			include $srccontrollerfile;
			$className = ucfirst($_GET["m"]);
			$controller = new $className();
			$controller->run();
		}else{
			Debug::addmsg("<font color='red'>对不起，你当前访问的模块不存在，请检查!</font>");
		}

		if(defined("DEBUG") && DEBUG==1 && $GLOBALS['debug']){
			Debug::stop();
			Debug::message();
		}
		
//	}

	
	
	

	

?>
