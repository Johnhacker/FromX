<?php
defined('IN_SYS') or exit('No permission resources.');
pc_base::load_app_class('admin','admin',0);

class sysm extends admin {
	public function __construct() {
		parent::__construct();
		
		$this->db = '';
		
		$this->site_db = pc_base::load_model('site_model');
		$this->bmfz_db = pc_base::load_model('bmfz_model');
		$this->zjys_db = pc_base::load_model('zjys_model');
		$this->zxzy_db = pc_base::load_model('zxzy_model');
		$this->yytj_db = pc_base::load_model('yytj_model');
		$this->jzqk_db = pc_base::load_model('jzqk_model');
		$this->lyfs_db = pc_base::load_model('lyfs_model');
		$this->diqu_db = pc_base::load_model('diqu_model');
		$this->bzks_db = pc_base::load_model('bzks_model');
		$this->wlxf_db = pc_base::load_model('wlxf_model');
		$this->pbqk_db = pc_base::load_model('pbqk_model');
		$this->email_db = pc_base::load_model('email_model');
		$this->logs_db = pc_base::load_model('adminlogs_model');
	}
	
	public function init () {
	}

	public function public_loginlogs() {
		$action=__FUNCTION__;

		$page = $_GET['page'] ? intval($_GET['page']) : '1';
		$_SESSION['page']=$page;
		
		$perpage = 20;
		
		$infos = $this->logs_db->listinfo('', 'logintime desc', $page, $perpage);
		$pages = $this->logs_db->pages;
		
		$topages = ceil($this->logs_db->number/$perpage);
		$prevpage = $page-1;
		$nextpage = $page+1;
		
		//键盘上下页
		if($prevpage==0) $prevpage=1;
		if($nextpage>$topages) $nextpage=$topages;
		$prevpage=pageurl(url_par('page={$page}'), $prevpage);
		$nextpage=pageurl(url_par('page={$page}'), $nextpage);
		
		include $this->admin_tpl('sysm_loginlogs');
	}

	public function public_siteset() {
		$action=__FUNCTION__;
		$this->selectdb(__FUNCTION__);
		
		if(isset($_GET['dosubmit'])) {
			$stitle = isset($_POST['stitle']{3}) && trim($_POST['stitle']) ? trim($_POST['stitle']) : showmessdialog('系统标题不能为空！');
			$cktime = isset($_POST['cktime']) && trim($_POST['cktime']) ? trim($_POST['cktime']) : showmessdialog('Cookies时长不能为空！');
			$semail = trim($_POST['semail']);
			$semailpw = trim($_POST['semailpw'])!='??????' ? trim($_POST['semailpw']) : '';
			
			$udata = array('sitetitle'=>$stitle, 'cookietime'=>$cktime, 'fsemail'=>$semail);
			if($semailpw!=''){ $udata['fsemailpwd']=$semailpw; }
			$this->db->update($udata, array('id'=>1));

			showmessdialog('操作成功', 200, './?m=admin&c=sysm&a='.$action);
		}else{
			$r = $this->db->get_one(array('id'=>1));
			include $this->admin_tpl('sysm_siteset');
		}
	}
	
	public function public_bmfzset() {
		$action=__FUNCTION__;
		$this->selectdb(__FUNCTION__);

		if(isset($_GET['dosubmit'])) {
			$stitle = isset($_POST['stitle']{3}) && trim($_POST['stitle']) ? trim($_POST['stitle']) : showmessdialog('名称不能为空！');
			$explains = isset($_POST['explains']) && trim($_POST['explains']) ? trim($_POST['explains']) : showmessdialog('分组不能为空！');
			
			if($_POST['ctrl']=='modify' && $_POST['cid']!=''){
				$cid=intval($_POST['cid']);
				$this->db->update(array('cname'=>$stitle, 'explains'=>$explains), array('id'=>$cid));
			}else{
				$this->db->insert(array('cname'=>$stitle, 'explains'=>$explains, 'addtime'=>SYS_TIME));
			}

			showmessdialog('操作成功', 200, './?m=admin&c=sysm&a='.$action);
		}else{
			$ctrl='';
			$iname='部门分组';
			$irows='说明';

			if(isset($_GET['ctrl'])=='modify') {
				$cid=intval($_GET['cid']);
				$r = $this->db->get_one(array('id'=>$cid));
				$r['cid']=$r['id'];
				$r['stitle']=$r['cname'];
				$ctrl='modify';
			}
			//$r = $this->site_db->get_one(array('id'=>1));
			$page = $_GET['page'] ? intval($_GET['page']) : '1';
			$infos = $this->db->listinfo('', 'listorder desc, id asc', $page, 20);
			$pages = $this->db->pages;

			foreach($infos as &$row) {
				$row['stitle']=$row['cname'];
			}

			include $this->admin_tpl('sysm_commset');
		}
	}

	public function public_zjysset() {
		$action=__FUNCTION__;
		$this->selectdb(__FUNCTION__);

		if(isset($_GET['dosubmit'])) {
			$stitle = isset($_POST['stitle']{3}) && trim($_POST['stitle']) ? trim($_POST['stitle']) : showmessdialog('名称不能为空！');
			$explains = isset($_POST['explains']) && trim($_POST['explains']) ? trim($_POST['explains']) : showmessdialog('分组不能为空！');
			
			//$explains = serialize(explode('|',$explains));
			
			if($_POST['ctrl']=='modify' && $_POST['cid']!=''){
				$cid=intval($_POST['cid']);
				$this->db->update(array('cname'=>$stitle, 'explains'=>$explains), array('id'=>$cid));
			}else{
				$this->db->insert(array('cname'=>$stitle, 'explains'=>$explains, 'addtime'=>SYS_TIME));
			}

			showmessdialog('操作成功', 200, './?m=admin&c=sysm&a='.$action);
		}else{
			$ctrl='';
			$imodel=1; //设置模式
			$iname='专家';
			$irows='分组';
			$iexps='说明';

			if(isset($_GET['ctrl'])=='modify') {
				$cid=intval($_GET['cid']);
				$r = $this->db->get_one(array('id'=>$cid));
				$r['cid']=$r['id'];
				$r['stitle']=$r['cname'];
				$ctrl='modify';
			}
			//$r = $this->site_db->get_one(array('id'=>1));
			$page = $_GET['page'] ? intval($_GET['page']) : '1';
			$g = $this->db->listinfo("explains like '%类别%'", 'listorder desc, id asc', $page, 20);
			$pages = $this->db->pages;

			$ids = array();
			$infos = array();
			foreach($g as $row) {
				$row['explains']=$row['cname'];
				$ids[]=$row['id'];
				$infos[]=$row;
				$e = $this->db->listinfo("explains like '%$row[cname]%'", 'listorder desc, id asc', 1, 100);
				if($e){
					$total = count($e);
					foreach($e as $k=>$rowb) {
						$ids[]=$rowb['id'];
						if(($k+1)==$total){
							$rowb['explains']='　└─ '.$rowb['cname'];
						}else{
							$rowb['explains']='　├─ '.$rowb['cname'];
						}
						unset($rowb['cname']);
						$infos[]=$rowb;
					}
				}
			}
			$g = $this->db->listinfo('', 'listorder desc, id asc', 1, 100);
			if($g){
				foreach($g as $row) {
					if(!in_array($row['id'],$ids)){ //附加未分类数据
						$row['explains2']=$row['explains'];
						$row['explains']=$row['cname'];
						$infos[]=$row;
					}
				}
			}

			include $this->admin_tpl('sysm_commset');
		}
	}

	public function public_zxzyset() {
		$action=__FUNCTION__;
		$this->selectdb(__FUNCTION__);

		if(isset($_GET['dosubmit'])) {
			$stitle = isset($_POST['stitle']{3}) && trim($_POST['stitle']) ? trim($_POST['stitle']) : showmessdialog('名称不能为空！');
			$explains = isset($_POST['explains']) && trim($_POST['explains']) ? trim($_POST['explains']) : showmessdialog('分组不能为空！');
			
			if($_POST['ctrl']=='modify' && $_POST['cid']!=''){
				$cid=intval($_POST['cid']);
				$this->db->update(array('cname'=>$stitle, 'explains'=>$explains), array('id'=>$cid));
			}else{
				$this->db->insert(array('cname'=>$stitle, 'explains'=>$explains, 'addtime'=>SYS_TIME));
			}

			showmessdialog('操作成功', 200, './?m=admin&c=sysm&a='.$action);
		}else{
			$ctrl='';
			$iname='咨询员';
			$irows='分组';

			if(isset($_GET['ctrl'])=='modify') {
				$cid=intval($_GET['cid']);
				$r = $this->db->get_one(array('id'=>$cid));
				$r['cid']=$r['id'];
				$r['stitle']=$r['cname'];
				$ctrl='modify';
			}
			//$r = $this->site_db->get_one(array('id'=>1));
			$page = $_GET['page'] ? intval($_GET['page']) : '1';
			$infos = $this->db->listinfo('', 'listorder desc, id asc', $page, 20);
			$pages = $this->db->pages;
			
			foreach($infos as &$row) {
				$row['stitle']=$row['cname'];
			}

			include $this->admin_tpl('sysm_commset');
		}
	}

	public function public_yytjset() {
		$action=__FUNCTION__;
		$this->selectdb(__FUNCTION__);

		if(isset($_GET['dosubmit'])) {
			$stitle = isset($_POST['stitle']{1}) && trim($_POST['stitle']) ? trim($_POST['stitle']) : showmessdialog('名称不能为空！');
			$explains = isset($_POST['explains']) && trim($_POST['explains']) ? trim($_POST['explains']) : showmessdialog('分组不能为空！');
			
			if($_POST['ctrl']=='modify' && $_POST['cid']!=''){
				$cid=intval($_POST['cid']);
				$this->yytj_db->update(array('cname'=>$stitle, 'explains'=>$explains), array('id'=>$cid));
			}else{
				$this->yytj_db->insert(array('cname'=>$stitle, 'explains'=>$explains, 'addtime'=>SYS_TIME));
			}

			showmessdialog('操作成功', 200, './?m=admin&c=sysm&a='.$action);
		}else{
			$ctrl='';
			$iname='咨询途径';
			$irows='分组';
			
			if(isset($_GET['ctrl'])=='modify') {
				$cid=intval($_GET['cid']);
				$r = $this->yytj_db->get_one(array('id'=>$cid));
				$r['cid']=$r['id'];
				$r['stitle']=$r['cname'];
				$ctrl='modify';
			}
			//$r = $this->site_db->get_one(array('id'=>1));
			$page = $_GET['page'] ? intval($_GET['page']) : '1';
			$infos = $this->yytj_db->listinfo('', 'explains desc, listorder desc, id asc', $page, 20);
			$pages = $this->yytj_db->pages;
			
			foreach($infos as &$row) {
				$row['stitle']=$row['cname'];
			}

			include $this->admin_tpl('sysm_commset');
		}
	}

	public function public_jzqkset() {
		$action=__FUNCTION__;
		$this->selectdb(__FUNCTION__);

		if(isset($_GET['dosubmit'])) {
			$stitle = isset($_POST['stitle']{1}) && trim($_POST['stitle']) ? trim($_POST['stitle']) : showmessdialog('名称不能为空！');
			$explains = isset($_POST['explains']) && trim($_POST['explains']) ? trim($_POST['explains']) : showmessdialog('说明不能为空！');
			
			if($_POST['ctrl']=='modify' && $_POST['cid']!=''){
				$cid=intval($_POST['cid']);
				$this->jzqk_db->update(array('cname'=>$stitle, 'explains'=>$explains), array('id'=>$cid));
			}else{
				$this->jzqk_db->insert(array('cname'=>$stitle, 'explains'=>$explains, 'addtime'=>SYS_TIME));
			}

			showmessdialog('操作成功', 200, './?m=admin&c=sysm&a='.$action);
		}else{
			$ctrl='';
			$iname='就诊情况';
			$irows='备注说明';

			if(isset($_GET['ctrl'])=='modify') {
				$cid=intval($_GET['cid']);
				$r = $this->jzqk_db->get_one(array('id'=>$cid));
				$r['cid']=$r['id'];
				$r['stitle']=$r['cname'];
				$ctrl='modify';
			}
			//$r = $this->site_db->get_one(array('id'=>1));
			$page = $_GET['page'] ? intval($_GET['page']) : '1';
			$infos = $this->jzqk_db->listinfo('', 'listorder desc, id asc', $page, 20);
			$pages = $this->jzqk_db->pages;
			
			foreach($infos as &$row) {
				$row['stitle']=$row['cname'];
			}

			include $this->admin_tpl('sysm_commset');
		}
	}

	public function public_lyfsset() {
		$action=__FUNCTION__;
		$this->selectdb(__FUNCTION__);

		if(isset($_GET['dosubmit'])) {
			$stitle = isset($_POST['stitle']{3}) && trim($_POST['stitle']) ? trim($_POST['stitle']) : showmessdialog('名称不能为空！');
			$explains = isset($_POST['explains']) && trim($_POST['explains']) ? trim($_POST['explains']) : showmessdialog('说明不能为空！');
			
			if($_POST['ctrl']=='modify' && $_POST['cid']!=''){
				$cid=intval($_POST['cid']);
				$this->lyfs_db->update(array('cname'=>$stitle, 'explains'=>$explains), array('id'=>$cid));
			}else{
				$this->lyfs_db->insert(array('cname'=>$stitle, 'explains'=>$explains, 'addtime'=>SYS_TIME));
			}

			showmessdialog('操作成功', 200, './?m=admin&c=sysm&a='.$action);
		}else{
			$ctrl='';
			$iname='来院方式';
			$irows='备注说明';

			if(isset($_GET['ctrl'])=='modify') {
				$cid=intval($_GET['cid']);
				$r = $this->lyfs_db->get_one(array('id'=>$cid));
				$r['cid']=$r['id'];
				$r['stitle']=$r['cname'];
				$ctrl='modify';
			}
			//$r = $this->site_db->get_one(array('id'=>1));
			$page = $_GET['page'] ? intval($_GET['page']) : '1';
			$infos = $this->lyfs_db->listinfo('', 'listorder desc, id asc', $page, 20);
			$pages = $this->lyfs_db->pages;
			
			foreach($infos as &$row) {
				$row['stitle']=$row['cname'];
			}

			include $this->admin_tpl('sysm_commset');
		}
	}

	public function public_diquset() {
		$action=__FUNCTION__;
		$this->selectdb(__FUNCTION__);

		if(isset($_GET['dosubmit'])) {
			$stitle = isset($_POST['stitle']{3}) && trim($_POST['stitle']) ? trim($_POST['stitle']) : showmessdialog('名称不能为空！');
			$explains = isset($_POST['explains']) && trim($_POST['explains']) ? trim($_POST['explains']) : showmessdialog('地区校验不能为空！');
			
			if($_POST['ctrl']=='modify' && $_POST['cid']!=''){
				$cid=intval($_POST['cid']);
				$this->diqu_db->update(array('cname'=>$stitle, 'explains'=>$explains), array('id'=>$cid));
			}else{
				$this->diqu_db->insert(array('cname'=>$stitle, 'explains'=>$explains, 'addtime'=>SYS_TIME));
			}

			showmessdialog('操作成功', 200, './?m=admin&c=sysm&a='.$action);
		}else{
			$ctrl='';
			$iname='地区';
			$irows='地区校验';

			if(isset($_GET['ctrl'])=='modify') {
				$cid=intval($_GET['cid']);
				$r = $this->diqu_db->get_one(array('id'=>$cid));
				$r['cid']=$r['id'];
				$r['stitle']=$r['cname'];
				$ctrl='modify';
			}
			//$r = $this->site_db->get_one(array('id'=>1));
			$page = $_GET['page'] ? intval($_GET['page']) : '1';
			$infos = $this->diqu_db->listinfo('', 'listorder desc, id asc', $page, 20);
			$pages = $this->diqu_db->pages;
			
			foreach($infos as &$row) {
				$row['stitle']=$row['cname'];
			}

			include $this->admin_tpl('sysm_commset');
		}
	}

	public function public_bzksset() {
		$action=__FUNCTION__;
		$this->selectdb(__FUNCTION__);

		if(isset($_GET['dosubmit'])) {
			$stitle = isset($_POST['stitle']{3}) && trim($_POST['stitle']) ? trim($_POST['stitle']) : showmessdialog('名称不能为空！');
			$explains = isset($_POST['explains']) && trim($_POST['explains']) ? trim($_POST['explains']) : showmessdialog('病种校验不能为空！');
			
			if($_POST['ctrl']=='modify' && $_POST['cid']!=''){
				$cid=intval($_POST['cid']);
				$this->db->update(array('cname'=>$stitle, 'explains'=>$explains), array('id'=>$cid));
			}else{
				$this->db->insert(array('cname'=>$stitle, 'explains'=>$explains, 'addtime'=>SYS_TIME));
			}

			showmessdialog('操作成功', 200, './?m=admin&c=sysm&a='.$action);
		}else{
			$ctrl='';
			$iname='病种';
			$irows='病种校验';

			if(isset($_GET['ctrl'])=='modify') {
				$cid=intval($_GET['cid']);
				$r = $this->db->get_one(array('id'=>$cid));
				$r['cid']=$r['id'];
				$r['stitle']=$r['cname'];
				$ctrl='modify';
			}
			//$r = $this->site_db->get_one(array('id'=>1));
			$page = $_GET['page'] ? intval($_GET['page']) : '1';
			$infos = $this->db->listinfo('', 'listorder desc, id asc', $page, 20);
			$pages = $this->db->pages;
			
			foreach($infos as &$row) {
				$row['stitle']=$row['cname'];
				$row['explains']=$row['explains'];
			}

			include $this->admin_tpl('sysm_commset');
		}
	}

	public function public_wlxfset() {
		$action=__FUNCTION__;
		$this->selectdb(__FUNCTION__);
		
		if(isset($_GET['dosubmit'])) {
			$stitle = isset($_POST['stitle']{3}) && trim($_POST['stitle']) ? trim($_POST['stitle']) : showmessdialog('名称不能为空！');
			$explains = isset($_POST['explains']) && trim($_POST['explains']) ? trim($_POST['explains']) : showmessdialog('说明不能为空！');
			
			if($_POST['ctrl']=='modify' && $_POST['cid']!=''){
				$cid=intval($_POST['cid']);
				$this->db->update(array('cname'=>$stitle, 'explains'=>$explains), array('id'=>$cid));
			}else{
				$this->db->insert(array('cname'=>$stitle, 'explains'=>$explains, 'addtime'=>SYS_TIME));
			}

			showmessdialog('操作成功', 200, './?m=admin&c=sysm&a='.$action);
		}else{
			$ctrl='';
			$iname='推广消费';
			$irows='备注说明';

			if(isset($_GET['ctrl'])=='modify') {
				$cid=intval($_GET['cid']);
				$r = $this->db->get_one(array('id'=>$cid));
				$r['cid']=$r['id'];
				$r['stitle']=$r['cname'];
				$ctrl='modify';
			}
			//$r = $this->site_db->get_one(array('id'=>1));
			$page = $_GET['page'] ? intval($_GET['page']) : '1';
			$infos = $this->db->listinfo('', 'listorder desc, id asc', $page, 20);
			$pages = $this->db->pages;
			
			foreach($infos as &$row) {
				$row['stitle']=$row['cname'];
			}

			include $this->admin_tpl('sysm_commset');
		}
	}

	public function public_emailset() {
		$action=__FUNCTION__;
		$this->selectdb(__FUNCTION__);

		if(isset($_GET['dosubmit'])) {
			$emname = isset($_POST['emname']{3}) && trim($_POST['emname']) ? trim($_POST['emname']) : showmessdialog('名称不能为空！');
			$emaddr = isset($_POST['emaddr']) && trim($_POST['emaddr']) ? trim($_POST['emaddr']) : showmessdialog('邮箱地址不能为空！');
			$explains = trim($_POST['explains']);
			
			if(trim($_POST['useing'])=='true'){
				$useing=1;
			}else{
				$useing=0;
			}

			if($_POST['ctrl']=='modify' && $_POST['cid']!=''){
				$cid=intval($_POST['cid']);
				$this->db->update(array('emname'=>$emname, 'emaddr'=>$emaddr, 'explains'=>$explains, 'useing'=>$useing), array('id'=>$cid));
			}else{
				$this->db->insert(array('emname'=>$emname, 'emaddr'=>$emaddr, 'explains'=>$explains, 'useing'=>$useing, 'addtime'=>SYS_TIME));
			}

			showmessdialog('操作成功', 200, './?m=admin&c=sysm&a='.$action);
		}else{
			$ctrl='';
			$iname='邮箱';

			if(isset($_GET['ctrl'])=='modify') {
				$cid=intval($_GET['cid']);
				$r = $this->db->get_one(array('id'=>$cid));
				$r['cid']=$r['id'];
				$ctrl='modify';
			}
			//$r = $this->site_db->get_one(array('id'=>1));
			$page = $_GET['page'] ? intval($_GET['page']) : '1';
			$infos = $this->db->listinfo('', 'listorder desc, id asc', $page, 20);
			$pages = $this->db->pages;

			include $this->admin_tpl('sysm_emailset');
		}
	}
	
	public function public_pbqkset() {
		$action=__FUNCTION__;
		$this->selectdb(__FUNCTION__);
		
		if(isset($_GET['dosubmit'])) {
			$stitle = isset($_POST['stitle']{3}) && trim($_POST['stitle']) ? trim($_POST['stitle']) : showmessdialog('名称不能为空！');
			$explains = isset($_POST['explains']) && trim($_POST['explains']) ? trim($_POST['explains']) : showmessdialog('说明不能为空！');
			
			if($_POST['ctrl']=='modify' && $_POST['cid']!=''){
				$cid=intval($_POST['cid']);
				$this->db->update(array('cname'=>$stitle, 'explains'=>$explains), array('id'=>$cid));
			}else{
				$this->db->insert(array('cname'=>$stitle, 'explains'=>$explains, 'addtime'=>SYS_TIME));
			}

			showmessdialog('操作成功', 200, './?m=admin&c=sysm&a='.$action);
		}else{
			$ctrl='';
			$iname='排班表';
			$irows='备注说明';			

			if(isset($_GET['ctrl'])=='modify') {
				$cid=intval($_GET['cid']);
				$r = $this->db->get_one(array('id'=>$cid));
				$r['cid']=$r['id'];
				$r['stitle']=$r['cname'];
				$ctrl='modify';
			}
			//$r = $this->site_db->get_one(array('id'=>1));
			$page = $_GET['page'] ? intval($_GET['page']) : '1';
			$infos = $this->db->listinfo('', 'listorder desc, id asc', $page, 20);
			$pages = $this->db->pages;
			
			foreach($infos as &$row) {
				$row['stitle']=$row['cname'];
			}

			include $this->admin_tpl('sysm_commset');
		}
	}

	public function listorder(){
		if(isset($_GET['dosubmit'])) {
			$this->selectdb(trim($_GET['ctrl']));
			foreach($_POST['listorders'] as $id => $listorder) {
				$this->db->update(array('listorder'=>$listorder),array('id'=>$id));
			}
			showmessdialog('操作成功', 200, 'reload');
		}
	}

	public function deleteds(){
		if(isset($_GET['dosubmit'])) {
			if(empty($_POST['ids'])) showmessdialog('您没有勾选信息！');
			
			if(!$this->selectdb(trim($_GET['ctrl']))) showmessdialog('无权操作！');
			foreach($_POST['ids'] as $id) {
				$this->db->delete(array('id'=>$id));
			}
			showmessdialog('操作成功', 200, 'reload');
		}
	}

	private function selectdb($action, $model=0){
		$brole=true;
		if($action=='public_loginlogs'){
			//权限判断
			if(!admin::check_roid('|77,')) $brole=false;
			$this->db=$this->logs_db;
		}
		if($action=='public_siteset'){
			
			if(!admin::check_roid('|71,')) $brole=false;
			$this->db=$this->site_db;
		}
		if($action=='public_bmfzset'){
			
			if(!admin::check_roid('|73,')) $brole=false;
			$this->db=$this->bmfz_db;
		}
		if($action=='public_zjysset'){
			
			if(!admin::check_roid('|78,')) $brole=false;
			$this->db=$this->zjys_db;
		}
		if($action=='public_zxzyset'){
			
			if(!admin::check_roid('|79,')) $brole=false;
			$this->db=$this->zxzy_db;
		}
		if($action=='public_yytjset'){
			
			if(!admin::check_roid('|710,')) $brole=false;
			$this->db=$this->yytj_db;
		}
		if($action=='public_jzqkset'){
			
			if(!admin::check_roid('|714,')) $brole=false;
			$this->db=$this->jzqk_db;
		}
		if($action=='public_lyfsset'){

			if(!admin::check_roid('|713,')) $brole=false;
			$this->db=$this->lyfs_db;
		}
		if($action=='public_diquset'){

			if(!admin::check_roid('|712,')) $brole=false;
			$this->db=$this->diqu_db;
		}
		if($action=='public_bzksset'){

			if(!admin::check_roid('|711,')) $brole=false;
			$this->db=$this->bzks_db;
		}
		if($action=='public_wlxfset'){

			if(!admin::check_roid('|715,')) $brole=false;
			$this->db=$this->wlxf_db;
		}
		if($action=='public_emailset'){

			if(!admin::check_roid('|72,')) $brole=false;
			$this->db=$this->email_db;
		}
		if($action=='public_pbqkset'){

			if(!admin::check_roid('|74,')) $brole=false;
			$this->db=$this->pbqk_db;
		}

		if(!$brole){
			if($model==1){
				return $brole;
			}else{
				showmessdialog('无权操作！', 300, HTTP_REFERER, 'noajax');
			}
		}

		return $brole;
	}

}
?>