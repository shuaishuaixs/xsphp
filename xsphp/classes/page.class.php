<?php
	class Page{
		private $total;			//总记录数
		private $listRows;		//每页显示记录数
		private $pageNum;		//总页数
		private $url;			//页码上的链接
		private $firstRow;		//每页起始位置
		private $currentPage;		//当前第几页
		private $config = array(	//显示信息
				"head" => "条记录",
				"prev" => "上一页",
				"next" => "下一页",
				"first" => "首页",
				"last" => "末页",
			);
		public function __construct($total,$listRows = "20"){
			$this->total = $total;
			$this->listRows = $listRows;
			$this->currentPage = !empty($_GET['page']) ? $_GET['page'] : 1 ;
			$this->firstRow = $this->listRows*($this->currentPage-1);
			$this->pageNum = ceil($this->total/$this->listRows);
			//$this->limit = $this->setLimit();

		}

		//自定义字段名
		function setConfig($key,$value){
			if(array_key_exists($key,$this->config)){
				$this->config[$key] = $value;	
			}
		}

		function __get($pro){
			if($pro == "firstRow"){
				return $this->firstRow;
			}elseif($pro == "listRows"){
				return $this->listRows;
			}
		}

		//获得链接
		private function getUrl(){
			$this->url = $GLOBALS['URL'].$_GET['a'];
			return $this->url;
		} 

		//‘首页’部分
		private function getFirstPage(){
			if($this->currentPage == "1"){
				$str = "&nbsp;{$this->config['first']}";
			}else{
			
				$str = "&nbsp;<a href='{$this->getUrl()}/page/1'>{$this->config['first']}</a>";
			}
			return $str;
		}

		//‘上一页’部分
		private function getPrevPage(){
			if($this->currentPage == "1"){
				$str= "&nbsp;{$this->config['prev']}";
			}else{
				//$str = "&nbsp;<a href='{$this->getUrl()}/page/'.($this->currentPage-1).>{$this->config['prev']}</a>";
				$str = "&nbsp;<a href='{$this->getUrl()}/page/".($this->currentPage - 1)."'>{$this->config['prev']}</a>";
			}
			return $str;
		}

		//中间部分(1、2、3、4、5、6、7、8、9)
		private function getLinkPage(){
			for($i = 1;$i <= $this->pageNum;$i++){
				if($i == $this->currentPage){
					$str.= "&nbsp;{$i}";
				}else{
					$str.= "&nbsp;<a href='{$this->getUrl()}/page/{$i}'>{$i}</a>";
					
				}
			//echo "123";
			}
			//echo $this->currentPage;
			return $str;
		}

		//‘下一页’部分
		private function getNextPage(){
			if($this->currentPage == $this->pageNum){
				$str = "&nbsp;{$this->config['next']}";
			}else{
				//$str = "&nbsp;<a href='{$this->getUrl()}/page/'.($this->currentPage+1)>{$this->config['next']}</a>";
				$str = "&nbsp;<a href='{$this->getUrl()}/page/".($this->currentPage + 1)."'>{$this->config['next']}</a>";
			}
			return $str;
		}

		//‘末页’部分
		private function getLastPage(){
			if($this->currentPage == $this->pageNum){
				$str = "&nbsp;{$this->config['last']}"; 
			}else{
				$str= "&nbsp;<a href='{$this->url}/page/{$this->pageNum}'>{$this->config['last']}</a>";
			}
			return $str;
		}

		//输出最后结果
		//总共 53 条记录 首页 上一页 1 2 3 4 5 6 下一页 末页
		function show(){
			$html[] = "&nbsp;总共有 {$this->total} {$this->config['head']}";
			$html[] = "&nbsp;".$this->currentPage."/".$this->pageNum." 页";
			$html[] = $this->getFirstPage();
			$html[] = $this->getPrevPage();
			$html[] = $this->getLinkPage();
			$html[] = $this->getNextPage();
			$html[] = $this->getLastPage();
			$output = "<div>";
			for($i = 0;$i < count($html);$i++){
				$output.= $html[$i];
			}
			$output.= "</div>";
			return $output;
		}
	}
?>
