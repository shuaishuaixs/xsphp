<?php
	class Session {
		function __construct(){
			if(session_id()){
				session_unset();
			}
			session_start();
		}
		/*function start(){
			session_start();
		}*/

		static function set($key,$value){
			$_SESSION["{$key}"] = $value;
		}

		static function get($key){
			if(empty($_SESSION["{$key}"])){
				//echo "false";
				return false;
			}
			return $_SESSION["{$key}"];
		}

		static function is_set($key){
			/*if(!isset($_SESSION["{$key}"])){
				return false;
			}elseif(trim($_SESSION["{$key}"]) == ""){
				return false;
			}else{
				return true;
			}*/
			if(!isset($_SESSION["{$key}"])){
				return false;
			}
			if(trim($_SESSION["{$key}"]) == ""){
				//echo "false";
				return false;
			}else{
				//echo "true";
				return true;
			}
		}
		static function clear($key){
			$_SESSION["{$key}"] = "";
		}
		function __destruct(){
			$_SESSION = array();
			session_destroy();
			
		}
	}
?>
