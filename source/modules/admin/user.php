<?php
defined('IN_SYS') or exit('No permission resources.');
pc_base::load_app_class('admin','admin',0);
pc_base::load_app_func('admin');

class user extends admin {
	public function __construct() {
		parent::__construct();
		
		$this->db = '';
		$this->admin_db = pc_base::load_model('admin_model');
		$this->bmfz_db = pc_base::load_model('bmfz_model');
		$this->op = pc_base::load_app_class('admin_op');
	}
	
	public function init () {
	}

	public function public_userlist(){
		$action=__FUNCTION__;

		//权限判断
		if(!admin::check_roid('|62,')) showmessdialog('无权操作！', 300, HTTP_REFERER, 'noajax');

		$page = $_GET['page'] ? intval($_GET['page']) : '1';
		$infos = $this->admin_db->listinfo('', 'useing desc, depart desc', $page, 20);
		$pages = $this->admin_db->pages;
		include $this->admin_tpl('user_userlist');
	}

	public function public_changepwd(){
		$action=__FUNCTION__;

		//权限判断
		if(!admin::check_roid('|61,')) showmessdialog('无权操作！', 300, HTTP_REFERER, 'noajax');

		$userid=self::$userid;
		if(isset($_GET['dosubmit'])) {
			$info = array();
			$info = $_POST['info'];
			if(isset($info['password']) && !empty($info['password']))
			{
				if($info['password']!=$info['pwdconfirm']) showmessdialog('两次密码不一致！');
				$this->op->edit_password($userid, $info['password']);
			}
			showmessdialog('操作成功', 200);
		}else{
			$action=__FUNCTION__;
			$r = $this->admin_db->get_one(array('userid'=>$userid));
			include $this->admin_tpl('user_changepwd');
		}
	}
	
	public function public_adduser(){
		$action=__FUNCTION__;

		//权限判断
		if(!admin::check_roid('|62,')) showmessdialog('无权操作！', 300, HTTP_REFERER, 'noajax');

		if(isset($_GET['dosubmit'])) {
			$purview = array();
			$info = array();
			
			$purview = $_POST['purview'];
			$info = $_POST['info'];
			if($this->savepostedit($info, $purview)){
				showmessdialog('操作成功！', 200, './?m=admin&c=user&a=public_userlist');
			}else{
				showmessdialog('操作出错！');
			}
		}else{

			$purview = array();
			//复制权限
			$ctrl=$_GET['ctrl'];
			if($ctrl=='copy'){
				$userid = intval($_GET['cid']);
				if($userid < 1) return false;
				
				$r = $this->admin_db->get_one(array('userid'=>$userid));
				
				unset($r['username']);
				unset($r['depart']);
				
				$purview = explode(',',$r['purview']);
			}
			
			$infos = $this->bmfz_db->listinfo('', 'listorder desc, id asc');
			include $this->admin_tpl('user_edituser');
		}
	}
	
	public function public_edituser(){
		$action=__FUNCTION__;

		//权限判断
		if(!admin::check_roid('|62,')) showmessdialog('无权操作！', 300, HTTP_REFERER, 'noajax');

		$purview = array();
		$info = array();
		$userid = 0;
		
		if(isset($_GET['dosubmit'])) {
			$info = $_POST['info'];
			$purview = $_POST['purview'];
			
			$cid = intval($info['cid']);
			
			if($this->savepostedit($info, $purview, 'edit', $cid)){
				showmessdialog('操作成功！', 200, './?m=admin&c=user&a=public_userlist');
			}else{
				showmessdialog('操作出错！');
			}
		}else{
			$userid = intval($_GET['cid']);
			if($userid < 1) return false;
	
			$infos = $this->bmfz_db->listinfo('', 'listorder desc, id asc');
			$r = $this->admin_db->get_one(array('userid'=>$userid));
			
			$purview = explode(',',$r['purview']);
			
			include $this->admin_tpl('user_edituser');
		}
	}
	
	private function savepostedit($info, $purview, $ctrl='add', $cid=0){
		
		if($ctrl=='edit'&&$cid==0 || $ctrl=='edit'&&$cid==''){
			return false;
		}
		$bool=false;
		
		$purview = implode('',$purview);
		$username = trim($info['username']);
		$useing = $info['useing']=='true' ? 1:0;
		$depart = $info['depart'];
		$password = trim($info['password']);
		$pwdconfirm = trim($info['pwdconfirm']);
		
		if($ctrl=='add'){
			if(isset($password) && !empty($password)){
				if($password!=$pwdconfirm) showmessdialog('两次密码不一致！');
			}
			if(!is_password($password)){
				showmessdialog('密码不合法！');
				return false;
			}
			if(!$this->op->checkname($username)){
				showmessdialog('用户名已经存在！');
				return false;
			}
			
			$this->admin_db->insert(array('username'=>$username, 'useing'=>$useing, 'depart'=>$depart, 'purview'=>$purview, 'addtime'=>SYS_TIME));
			$cid=$this->admin_db->insert_id();
			if($cid){
				$this->op->edit_password($cid, $password);
				$bool=true;
			}
		}
		
		if($ctrl=='edit'){
			if(isset($password) && !empty($password)){
				if($password!=$pwdconfirm) showmessdialog('两次密码不一致！');
				$this->op->edit_password($cid, $password);
			}
		
			$result=$this->admin_db->update(array('username'=>$username, 'useing'=>$useing, 'depart'=>$depart, 'purview'=>$purview), array('userid'=>$cid));
			if($result) $bool=true;
		}
		return $bool;
	}

	public function deleteds(){
		
		//权限判断
		if(!admin::check_roid('|62,')) showmessdialog('无权操作！');

		if(isset($_GET['dosubmit'])) {
			if(empty($_POST['ids'])) showmessdialog('您没有勾选信息！');
			foreach($_POST['ids'] as $id) {
				$this->db->delete(array('userid'=>$id));
			}
			showmessdialog('操作成功', 200, 'reload');
		}
	}

}
?>