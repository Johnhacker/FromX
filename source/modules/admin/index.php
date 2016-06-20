<?php
defined('IN_SYS') or exit('No permission resources.');
pc_base::load_app_class('admin','admin',0);

class index extends admin {
	public function __construct() {
		parent::__construct();
		$this->db = pc_base::load_model('admin_model');
		$this->menu_db = pc_base::load_model('menu_model');
	}
	public function init() {
		//代码
	}
}
?>