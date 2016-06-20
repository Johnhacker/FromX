<?php
defined('IN_SYS') or exit('No permission resources.');//权限
pc_base::load_app_class('admin','admin',0);

class quer extends admin {
	public function __construct() {
		parent::__construct();
		// $this->userid = $_SESSION['userid'];
	}
	
	public function init () {
		$fromer = $_GET['fromer'];
		$ctrl = $_GET['ctrl'];
		$param = array();
		$param = $_POST['p'];
		$param_fields = array('stdate', 'endate', 'keyword');
		foreach ($param as $k=>$value) {
			$info[$k]=trim($value);
			if (!in_array($k, $param_fields)){
				unset($param[$k]);
			}
		}
		//echo $fromer;
		if($fromer=='main'){
			header("Location: ./?m=admin&c=main&p[stdate]=$param[stdate]&p[endate]=$param[endate]&p[keyword]=$param[keyword]");
		}

		if($fromer=='edlg'){
			header("Location: ./?m=admin&c=edlg&a=$ctrl&p[stdate]=$param[stdate]&p[endate]=$param[endate]&p[keyword]=$param[keyword]");
		}
		
		if($fromer=='dyua'){
			header("Location: ./?m=admin&c=dyua&p[stdate]=$param[stdate]&p[endate]=$param[endate]&p[keyword]=$param[keyword]");
		}

		if($fromer=='anls'){
			header("Location: ./?m=admin&c=anls&a=$ctrl&p[stdate]=$param[stdate]&p[endate]=$param[endate]");
		}

		if($fromer=='repo'){
			header("Location: ./?m=admin&c=repo&a=$ctrl&p[stdate]=$param[stdate]&p[endate]=$param[endate]");
		}
	}

}
?>