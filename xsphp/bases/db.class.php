<?php
	abstract class db{
		protected $tabName;
		protected $msg = array();
		var $fields = "";
		protected $sql = array(
			"field"=>"",
			"where"=>"",
			"order"=>"",
			"limit"=>"",
		);

		/**
		 *获取表名
		 * */

		/*public function __get($pro){
			if($pro=="tabName"){
				return $this->tabName;
			}
		}*/

		
		
		/**
		 *重置属性
		 * */
		/*
		protected function setNull(){
			$this->sql = array(
				"field"=>"",
				"where"=>"",
				"order"=>"",
				"limit"=>"",
			);
		}*/
		

		/**
		 *连贯操作调用field() where() order() limit()
		 * */
		function __call($methodName,$args){
			$methodName = strtolower($methodName);
			/*if(array_key_exists($methodName,$this->sql)){
				if(empty($args[0]) || (is_string($args) && trim($args[0]) == '')){
					$this->sql[$methodName] = "";
				}else{
					$this->sql[$methodName] = $args;
				}
			}else{
				Debug::addmsg("<font color='red'>调用类".get_class($this)."中的方法 {$methodName}()不存在！ </font>");
			}*/
			if(array_key_exists($methodName,$this->sql)){
				if(empty($args[0]) || trim($args[0]) == ""){
					$this->sql[$methodName] = "";
					//echo $arg[0];
				}else{
					$this->sql[$methodName] = $args[0];
				}
			}else{
				Debug::addmsg("<font color='red'>调用类".get_class($this)."中的方法 {$methodName}()不存在！ </font>");
				//echo "<br>* * * * * *<br>";
			}
			return $this;
		}


		/**
		 *获取结果集的总记录数
		 *
		 * */
		function total(){
			$method = "TOTAL";
			$com_result = $this->com_where__order_limit();
			$sql = "SELECT COUNT(*) as count FROM {$this->tabName}{$com_result} ";
			//echo $sql;
			return $this->query($sql,$method);
		}

		//查询一条记录（已知id）
		function find($id){
			$method = "FIND";
			$fields = trim($this->sql['field']);
			if($this->sql['field'] == ""){
				$fields = "*";
			}elseif(is_array($this->sql['field'])){
				$fields = implode(",",$this->sql['field']);
			}
			$where = " WHERE"." id = {$id}";
			$sql = "SELECT {$fields} FROM {$this->tabName}{$where} LIMIT 1";
			//echo $sql."<br>";
			return $this->query($sql,$method);
		}

		//查询操作
		function select(){
			$method = "SELECT";
			$fields = $this->comField();
			$com_result = $this->com_where__order_limit();
			//dump($fields);
			$sql = "SELECT {$fields} FROM {$this->tabName }{$com_result} ";
			//echo $com_result;
			//echo $sql;
			//echo $com_result;
			//echo $com_result." select...<br>";
			//echo $this->fields;
			//echo $fields."fields<br>";
			return $this->query($sql,$method);
		}

		//插入操作
		function insert($data = null){
			//$table_columns 表字段名
			//SHOW COLUMNS FROM 表名
			$method = "INSERT";
			$fields = $this->comField();
			$array = "";
			foreach($data as $val){
				$array.=",'{$val}'";
			}
			$array = trim($array,",");
			$sql = "INSERT INTO {$this->tabName}(".implode(',',array_keys($data)).") VALUES ({$array})";
			//echo $sql;
			return $this->query($sql,$method);
		}

		//更新操作
		function update($data = null){
			$method = "UPDATE";
			$com_result = $this->com_where__order_limit();
			$setField = "";
			foreach($data as $k=>$val){
				$setField.= "$k = '{$val}',";
			}
			$setField = trim($setField,",");
			$sql = "UPDATE {$this->tabName} SET {$setField}{$com_result}";
			//echo $sql;
			return $this->query($sql,$method);
		}

		//删除操作
		function delete(){
			$method = "DELETE";
			//$fields = $this->comField();
			//$where = $this->comWhere();
			//$order = $this->comOrder();
			//$limit = $this->comLimit();
			$com_result = $this->com_where__order_limit();
			$sql = "DELETE FROM {$this->tabName}{$com_result}";
			//echo "<br>";
			//echo $sql;
			//echo $com_result;
			//echo $fields;
			//echo "<br>-------<br>";
			//var_dump($where);
			//var_dump($where);
			//echo $this->comWhere();
			//echo "<br>-------<br>";
			return $this->query($sql,$method);
		}

		//组合 where order limit 语句
		function com_where__order_limit(){
			//echo "<br>com_where__order_limit()";
			//$fields = $this->comField();
			//dump($fields);
			//echo $fields."<br>";
			$where = $this->comWhere();
			$limit = $this->comLimit();
			$order = $this->comOrder();
			//echo $limit;
			$com_result = $where.$order.$limit;
			return $com_result;
		}

		//确定查询的字段名
		function comField(){
			$fields = trim(trim($this->sql['field']),",");
			if($this->sql['field'] == ""){
				$fields = "*";
			}elseif(is_array($this->sql['field'])){
				$fields = implode(",",trim($this->sql['field'],','));
			}
			return $fields;
		}

		//确定查询的条件
		function comWhere(){
			$where = trim($this->sql['where']);
			//echo $this->sql['where'];
			if($where != ""){
				$where = " WHERE {$where}";
				//echo "-++---+--";
			}else{
				$where = "";
			}
			//echo "<br>+++++++<br>";
			//$sql = "";
			//return $where;
			/*if(is_array($where)){
				foreach($where as $val){
					$sql_where.= $val;
				}
			}else{
				$sql_where = $where;
			}
			$where = " WHERE {$where}";*/
			//echo $where;
			return $where;
		}

		//确定查询的限制
		function comLimit(){
			$limit = trim($this->sql['limit']);
			//echo $limit;
			//dump($this->sql);
			if($limit != ""){
				$limit = " LIMIT {$limit}";
			}
			return $limit;
		}

		//确定查询的顺序
		function comOrder(){
			$order = trim($this->sql['order']);
			//echo "<br>order--".$order."--order<br>";
			if($order != ""){
				if(strstr($order,",")){
					$order = explode(",",$order);
					//var_dump($order);
					//echo count($order);
				}
			}
			/*if(strstr($order,",")){
				$order = explode(",",$order);
			}*/
			//echo $this->sql['order'];
			//var_dump($order);
			if(count($order) == 2){
				if($order[1] == "desc"){
					$order[1] = strtoupper($order[1]);
					//echo $order[1]."121231<br>";
					$order = " ORDER BY {$order[0]} {$order[1]}";
				}else{
					$order = " ORDER BY {$order[0]}";
				}
			}else{
				$order = "";
			}
			return $order;
		}

		abstract function query($sql,$method);
		//abstract function connect($host,$user,$pass);
	}
?>
