<?php
	/*
	 *输出各种类型数据
	 * */
	function dump(){
		$args = func_get_args();
		if(count($args)<1){
			Debug::addmsg("<font color='red'>必须为p()函数提供参数</font>");
			return;
		}

		echo "<div style='width:100%;text-align:left'>";
		echo "<pre>";
		foreach($args as $arg){
			if(is_array($arg)){
				print_r($arg);
				echo "<br>";
			}elseif(is_string($arg)){
				echo $arg."<br>";
			}else{
				var_dump($arg);
				echo "<br>";
			}
			
		}
		echo "</pre>";
		echo "</div>";
	}


	/*
	 *创建Models中的数据库操作对象
	  $className 类名 代表一张表对象
	 * */
	function M($className = null){
		$className = strtolower($className);
		$modelfile = APP_PATH."Model/".$className."Model.class.php";
		//echo $modelfile;
		if(file_exists($modelfile)){
			include $modelfile;
			//echo "{$className}({$className})";
			$modelClass = $className."Model";
			//echo $modelClass;
			$model = new $modelClass($className);
			//echo "123";
		}else{
			//echo "not existed";
			//echo $className;
			include "model.class.php";
			$model = new Model($className);
		}
		//dump($model);
		//$model = new Model($className);
		return $model;
	}

	function import($className){
		include PROJECT_PATH."libs/".$className.".class.php";
	}
?>
