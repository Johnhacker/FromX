<?php
defined('IN_SYS') or exit('No permission resources.');
pc_base::load_app_class('admin','admin',0);

class edlg extends admin {
	public function __construct() {
		parent::__construct();
		
		$this->db = pc_base::load_model('edlogs_model');
	}
	
	public function init () {
		self::public_list();
	}
	
	public function public_list() {
		$action=__FUNCTION__;
		$fromer=$_GET['c'];
		$ctrl=$action;

		$param = array();
		$param = $_GET['p'];
		$param_fields = array('stdate', 'endate', 'keyword');
		
		if(is_array($param)){
			foreach ($param as $k=>$value) {
				$info[$k]=trim($value);
				if (!in_array($k, $param_fields)){
					unset($param[$k]);
				}
			}
		}
		
		$sedate=date('Y-m-d',strtotime('-5 month',SYS_TIME)).' 至 '.date('Y-m-d',SYS_TIME);

		if($param['stdate']!=''&&$param['endate']!=''){
			$stdate=strtotime($param['stdate']);
			$endate=strtotime($param['endate']);
		}
		
		//列表
		include $this->admin_tpl('edlg_list');
	}

}
?>