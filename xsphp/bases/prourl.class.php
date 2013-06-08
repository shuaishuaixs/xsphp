<?php
	class Prourl{
		static function paresUrl(){
			if(isset($_SERVER['PATH_INFO'])){
				//echo $_SERVER['PATH_INFO']."<br>";
				//echo trim($_SERVER['PATH_INFO'],"/")."<br>";
				$pathinfo = explode('/',trim($_SERVER['PATH_INFO'],"/"));
				//var_dump($pathinfo);
				//$_GET['m'] = isset($pathinfo[0]) ? $pathinfo[0] : "index";
				$_GET['m'] = !empty($pathinfo[0]) ? $pathinfo[0] : "index";
				array_shift($pathinfo);
//			       	$_GET['a'] = isset($pathinfo[0]) ? $pathinfo[0] : DEFAULT_ACTION;	
				if($_GET['m'] == "index"){
					//$_GET['a'] = isset($pathinfo[0]) ? $pathinfo[0] : DEFAULT_ACTION;
					$_GET['a'] = !empty($pathinfo[0]) ? $pathinfo[0] : DEFAULT_ACTION;
				}else{
					$_GET['a'] = !empty($pathinfo[0]) ? $pathinfo[0] : "index";
				}
				array_shift($pathinfo);
				$sum = count($pathinfo);
				for($i=0; $i<$sum; $i+=2){
					$_GET[$pathinfo[$i]] = $pathinfo[$i+1];
				}
			}else{
				$_GET["m"] = !empty($_GET['m']) ? $_GET['m'] : "index";
//				$_GET['a'] = isset($_GET['a']) ? $_GET['a'] : DEFAULT_ACTION;
				if($_GET['m'] == "index"){
					$_GET['a'] = !empty($_GET['a']) ? $_GET['a'] : DEFAULT_ACTION;
				}else{
					$_GET['a'] = !empty($_GET['a']) ? $_GET['a'] : "index";
				}
				if($_SERVER['QUERY_STRING']){
					$m = $_GET['m'];
					unset($_GET['m']);
					$a = $_GET['a'];
					unset($_GET['a']);
					$query = http_build_query($_GET);
					$url = $_SERVER['SCRIPT_NAME']."/{$m}/{$a}/".str_replace(array("&","=","+","\'","\""),"/",$query);
					header("Location:".$url);
				}
			}
		}
	}
?>
