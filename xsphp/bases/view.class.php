<?php
	/**
	 *模板扩展类
	 * */
	class View extends Smarty{
		/**
		 *  类初始化
		 * */
		function __construct(){
			$this->template_dir = APP_PATH."view/";
			$this->compile_dir = RUNTIME_PATH.APP."/templates_c/";
			$this->caching = CSTART;
			$this->cache_dir = RUNTIME_PATH.APP."/cache/";
			$this->cache_lifetime = CTIME;
			$this->left_delimiter = "<{";
			$this->right_delimiter = "}>";
			parent::__construct();
		}
		/**
		 *重写smarty类中的方法
		 *$resource_name 模板位置
		 * */
		function display($resource_name = null,$cache_id = null, $compile_id = null){
			$this->assign("ROOT",$GLOBALS['ROOT']);
			$this->assign("APP",$GLOBALS['APP']);
			$this->assign("URL",$GLOBALS['URL']);
			$this->assign("PUBLIC",$GLOBALS['PUBLIC']);
			$this->assign("RES",$GLOBALS['RES']);


			//echo $resource_name;
			if(is_null($resource_name)){
				$resource_name = "{$_GET['m']}/{$_GET['a']}.html";
			}elseif(strstr($resource_name,'/')){
				$resource_name = $resource_name.".html";
			}else{
				$resource_name = $_GET["m"]."/".$resource_name.".html";
			}
			//echo $resource_name."<br>";
			//$tplfile = APP."/View/".$resource_name;
			//$tplfile = "../../".APP."/View/".$resource_name;
			//$tplfile = "index/View/index/index.html";
			//echo dirname($tplfile)."<br>";
			//echo file_exists($tplfile);
			//$viewfile = $GLOBALS['APP']."";
			$tplfile = APP_PATH."View/".$resource_name;
			//echo $tplfile."<br>";
			if(file_exists($tplfile)){
				//echo $tplfile." existed";
				Debug::addmsg("使用模板<b> $resource_name </b>");
			}else{
				//echo $tplfile." not existed";
				Debug::addmsg("<font color='red'>尚未建立模板 $resource_name </font>");
			}
			//Debug::addmsg("使用模板<b> $resource_name </b>");
			parent::display($resource_name,$cache_id,$compile_id);
		}

		/**
		 *
		 *
		 * */
		function is_cached($tpl_file = null,$cache_id = null,$comile_id = null){
			if(is_null($tpl_file)){
				$tpl_file = "{$_GET['m']}/{$_GET['a']}.html";
			}elseif(strstr($tpl_file,'/')){
				$tpl_file = $tpl.".html";
			}else{
				$tpl_file = $_GET['m']."/".$tpl_file.".html";
			}

			parent::is_cached($tpl_file,$cache_id,$compile_id);
		}
	}
?>
