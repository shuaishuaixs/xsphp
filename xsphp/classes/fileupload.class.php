<?php
	//header('content-type:text/html;charset=utf-8');
	class FileUpload {
		private $maxsize = 102401024;	//限制上传文件大小，单位K
		private $originName;		//源文件名
		private $tmpFileName;		//临时文件名
		private $fileType;		//文件类型（后缀名）
		private $fileSize;		//文件大小
		private $newFileName;		//新文件名
		private $fileStorePath;		//文件的上传位置
		private $errorNum;		//错误号
		private $isRandom = true;	//是否随机命名
		private $errorMess;		//错误信息
		private $filePath;		//上传后的文件路径

		//获取文件基本信息
		public function __construct($file){
			//echo $file['error'];
			$this->originName = $file['name'];
			$this->tmpFileName = $file['tmp_name'];
			$this->fileSize = $file['size'];
			$this->errorNum = $file['error'];
			$this->fileType = $file['type'];
			//print_r($file);
			//echo $this->originName;
			//echo $this->newFileName;
			//$this->newFileName = "";
		}

		//设置属性值
		public function setOption($key,$val){
			//$key = strtolower($key);
			//echo $key;
			$class_option = array_keys(get_class_vars(get_class($this)));
			//print_r($class_option);
			if(in_array($key,$class_option)){
				$this->$key = $val;
				//echo "xiao";
			}
		}


		//获取错误信息
		public function getError(){
			$str = "上传文件失败: ";
			switch($this->errorNum){
				case 1:
					$str.= "上传的文件大小超过了 php.ini 中的upload_max_filesize 的限制值";break;  
				case 2:
					$str.= "上传的文件大小超过了表单中 MAX_FILE_SIZE 选项指定的值";break;  
				case 3:
					$str.= "文件只有部分被上传";break;  
				case 4:
					$str.= "没有文件被上传";break;
				case -1:
					$str.= "上传文件超过最大值{$this->maxsize}k";break;
				case -2:
					$str.= "指定的上传位置不存在";break;
				case -3:
					$str.= "上传出错";break;	
				case -4:
					$str.= "上传的文件已存在";break;
				default:
					$str.= "未知错误";break;
			}
			return $str;
		}

		public function getErrorMsg(){
			return $this->errorMess;
		}

		//上传选择的文件
		public function upload(){
			$this->setNewFileName();
			if(!$this->checkStorePath()){
				$this->errorMess = $this->getError();
				//echo "1231";
				return false;
			}
			if(!$this->checkSize()){
				$this->errorMess = $this->getError();
				//echo "456";
				return false;
			}
			if($this->checkFileExist()){
				$this->errorMess = $this->getError();
				return false;
			}
			if($this->moveFile()){
				return true;
			}else{
				$this->errorMess = $this->getError();
				return false;
			}
		}

		/*public function getInfo(){
			$this->originName = $file['name'];
			$this->tmpFileName = $file['tmp_name'];
			$this->fileSize = $file['size'];
			$this->errorNum = $file['error'];
			$this->fileType = $file['type'];
		}*/


		//移动上传的文件到指定的位置
		public function moveFile(){
/*
			if(empty($this->fileStorePath)){
				$storePath = trim($this->makeStorePath());
				$this->setOption('fileStorePath',$storePath);
				//echo $path."xiso<br>";
				//$this->
				//$path.= $this->fileStorePath;
			}
*/
			$path = trim($this->fileStorePath,"/")."/";
			//echo "---".$path.$this->newFileName."---";
			$filePath = $path.$this->newFileName;
			$this->setOption("filePath",$filePath);
			if(!$this->errorNum){
				if(move_uploaded_file($this->tmpFileName,/*$path.$this->newFileName*/$filePath)){
					return true;
				}else{
					$this->setOption("errorNum","-3");
					return false;
				}
			}else{
				return false;
			}
		}	

		public function setNewFileName(){
			if($this->isRandom == "true"){
				//echo "<br>-----------<br>";
				$this->setOption("newFileName",$this->makeRandomName());
			}else{
				//echo "<br>+++++++++++<br>";
				$this->setOption("newFileName",$this->originName);
			}
		}

		//获取上传成功后的文件名称
		public function getFileName(){
			return $this->newFileName;
		}


		//检查上传文件的存储位置是否存在
		public function checkStorePath(){
			if(!empty($this->fileStorePath)){
				//echo "<br>".$this->fileStorePath."<br>";
				/*if(file_exists($this->fileStorePath)){
					echo "existed";
				}else{
					echo "not existed";
				}*/
				if(file_exists($this->fileStorePath)){
					//echo "existed";
					return true;
				}else{
					//$this->makeStorePath();
					$this->setOption('errorNum','-2');
					return false;
				}
			}else{
				//echo "false<br>";
				return false;
			}
		}

		//检查上传文件的大小是否超过设定值
		public function checkSize(){
			if($this->filesize > $this->maxsize){
				$this->setOption('errorNum','-1');
				return false;
			}else{
				return true;
			}
		}
/*
		//生成日期形式的文件夹
		public function makeStorePath(){
			$fileName = date('Ymd');
			if(!file_exists($fileName)){
				mkdir($fileName,"0755");
			}
			return $fileName;
			//echo $this->fileStorePath.$fileName."<br>";
			//$storePath = $this->fileStorePath."/".$fileName;
			//$this->setOption('fileStorePath',$storePath);
		}

*/
		//生成随机文件名
		public function makeRandomName(){
			return date('YmdHis').$this->originName;
		}

		public function getStorePath(){
			return $this->fileStorePath;
		}
		public function getErrorNum(){
			return $this->errorNum;
		}
		public function checkFileExist(){
			//echo "4565654"."<br>";
			$fileStorePath = trim($this->fileStorePath,"/")."/";
			$fileName = $this->fileStorePath.$this->newFileName;
			//echo $fileName."<br>";
			if(file_exists($fileName)){
				$this->setOption('errorNum','-4');
				//echo "jjxijx<br>";
				return true;
			}else{
				return false;
			}
		}
		public function getIsrandom(){
			return $this->isRandom;
			//echo "2222";
		}
		public function getFilePath(){
			return $this->filePath;	
		}
	}
?>
