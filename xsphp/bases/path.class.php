<?php
	//路径定义类
	class path{
		static function define_path(){
			define("XSPHP_PATH",rtrim(XSPHP,"/")."/");	//定义框架路径
			define("APP_PATH",rtrim(APP,"/")."/");		//用户项目应用路径
			define("PROJECT_PATH",dirname(XSPHP_PATH)."/");	//网站根路径
			define("TMP_PATH",PROJECT."runtime/");		//网站缓存文件路径
		}
	}
?>
