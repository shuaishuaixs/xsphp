<?php
	class init {
		static function set_path(){
			//设置包含目录，PATH_SEPARATOR 分隔符号(:) windows(;)
			$path = get_include_path();				//原始包含目录
			$path.=PATH_SEPARATOR.XSPHP_PATH."bases/";		//框架基类所在目录
			$path.=PATH_SEPARATOR.XSPHP_PATH."classes/";		//框架扩展类目录
			$path.=PATH_SEPARATOR.XSPHP_PATH."smarty/";		//Smarty模板所在目录
			$path.=PATH_SEPARATOR.RUNTIME_PATH;		//缓存文件所在目录
			$path.=PATH_SEPARATOR.PROJECT_PATH.APP."/Action";
			set_include_path($path);				//设置所有包含目录
		}
	}
?>
