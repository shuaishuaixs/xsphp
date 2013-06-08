<?php
	class action extends View{
/*		public function init(){
			echo "init function<br>";
		}
*/
		function run(){
			if($this->left_delimiter!="<{"){
				parent::__construct();
			}

			if(method_exists($this,"init")){
				$this->init();
			}

			$control = $_GET['m'];
			$method = $_GET['a'];
			if(method_exists($this,$method)){
				if($control != "index" || $method != "index"){
						$this->$method();
				}	
				
			}else{
				Debug::addmsg("<font color='red'>当前控制器{$_GET['m']}下没有{$_GET['a']}这个操作！</font>");
			}
		}

		/**
		 *$this->redirect("index")	// 当前模块/inde
		 *$this->redirect("user/index")	// user/index
		 *$this->redirect("user/index","page/2")	// user/index/page/2
		 * */
		function redirect($path,$args = ""){
			$path = trim($path,"/");
			if($args != ""){
				$args = "/".trim($args,"/"); 
			}
			if(strstr($path,"/")){
				$url = $path.$args;
			}else{
				$url = $_GET['m']."/".$path.$args;
			}
			$newUrl = $GLOBALS['APP'].$url;
			echo "<script>";
			echo 'location="'.$newUrl.'"';
			echo "</script>";
			//echo "<br>--------<br>";
			//echo $newUrl;
			//echo "<br>--------<br>";
			//echo $_SERVER["SCRIPT_NAME"]."<br>";
		}

		function success($mess="操作成功",$timeout=1,$location=""){
			$this->push($mess,$timeout,$location);
			$this->assign("mark",true);
			//echo $mess."<br>";
			$this->display("public/success");
			exit;
		}
		function error($mess="操作失败",$timeout=1,$location=""){
			$this->push($mess,$timeout,$location);
			$this->assign("mark",false);
			$this->display("public/success");
			exit;
		}
		function push($mess,$timeout,$location){
			if($location == ""){
				$location = "window.history.back();";
			}else{
				$path = trim($location,"/");
				if(strstr($path,"/")){
					$url = $path;
				}else{
					$url = $_GET['m']."/".$path;
				}
				$location = $GLOBALS['APP'].$url;
				$location = "window.location='{$location}'";
			}
			//echo $location;
			$this->assign("mess",$mess);
			$this->assign("timeout",$timeout);
			$this->assign("location",$location);
		}
	}
?>
