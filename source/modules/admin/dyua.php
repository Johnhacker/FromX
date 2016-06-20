<?php
defined('IN_SYS') or exit('No permission resources.');
pc_base::load_app_class('admin','admin',0);
pc_base::load_app_func('comm');

class dyua extends admin {
	public function __construct() {
		parent::__construct();
		
		$this->db = pc_base::load_model('yuyue_model');
		$this->db_dt = pc_base::load_model('yuyue_data_model');
		
		$this->bzks_db = pc_base::load_model('bzks_model');
		$this->diqu_db = pc_base::load_model('diqu_model');
		
		$this->zjys_db = pc_base::load_model('zjys_model');
		$this->jzqk_db = pc_base::load_model('jzqk_model');
		$this->lyfs_db = pc_base::load_model('lyfs_model');
	}
	
	public function init () {
		self::public_list();
	}
	
	public function public_list() {
		$action=__FUNCTION__;
		$fromer=$_GET['c'];
		
		//权限判断
		if(!admin::check_roid('|21,') && !admin::check_roid('|22,')) showmessdialog('无权操作！', 300, HTTP_REFERER, 'noajax');
		
		param::set_cookie('comm_currurl', get_url());
		
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
		
		$where='1=1';
		$sedate=date('Y-m-d',strtotime('-5 month',SYS_TIME)).' 至 '.date('Y-m-d',SYS_TIME);
		
		$rdate=getdaterange(trim($_GET['s']));
		if($rdate['stdate']!=''&&$rdate['endate']!=''){
			$stdate=$rdate['stdate'];
			$endate=$rdate['endate'];
			$where="lydate >= '$stdate' and lydate <= '$endate'";
		}
		
		if($param['stdate']!=''&&$param['endate']!=''){
			$stdate=strtotime($param['stdate']);
			$endate=strtotime($param['endate']);
			$where="lydate >= '$stdate' and lydate <= '$endate'";
		}
		
		if($param['keyword']!=''){
			$keywd=$param['keyword'];
			$sewhere=array(" and ( hzname like '%$param[keyword]%'",
							" or djname like '%$param[keyword]%'",
							" or hztel like '%$param[keyword]%'",
							" or bingzx like '%$param[keyword]%'",
							" or bingzm like '%$param[keyword]%'",
							" or yynum like '%$param[keyword]%'",
							" or jzzj like '%$param[keyword]%'",
							" or yyzxy like '%$param[keyword]%'",
							" or yykey like '%$param[keyword]%'",
							" or yytj like '%$param[keyword]%'",
							" or jzqk like '%$param[keyword]%'",
							" )");
			$sewhere=join('',$sewhere);
			$where=$where.$sewhere;
		}
		
		if(isset($stdate)&&isset($endate)){
			$stdate=date('Y-m-d',$stdate);
			$endate=date('Y-m-d',$endate);
			if($_GET['s']!='cmonth')
			$sedate=$stdate.' 至 '.$endate;
		}
		
		if(!admin::check_roid('|22,')) $where="yyzxy='".self::$username."' and ".$where;
		
		//导出CSV
		if($_GET['echo']=='export'){
			if(!admin::check_roid('|84,')) showmessdialog('无权操作！', 300, HTTP_REFERER, 'noajax');
			$filename = str_replace(' ', '', $sedate.'到院数据');
			$csv_data = "到院日期,姓名,真实姓名,性别,年龄,地区,电话,病种,预约号,预计时间,接诊专家,咨询员,预约途径,关键词,来院方式,就诊情况,接管状态\n";
			$infos = $this->db->select('lydate>0 and '.$where, '*', '6000', 'lydate desc, yyzxy asc');
			ob_start();
			echo $csv_data;
			foreach($infos as $k=>$info) {
				$csv_data = '';
				$csv_data .= date('Y-m-d',$info['lydate']).',';
				$csv_data .= $info['hzname'].',';
				$csv_data .= $info['djname'].',';
				$csv_data .= $info['hzsex'].',';
				$csv_data .= $info['hzage'].',';
				$csv_data .= $info['hzcity'].',';

				if(admin::check_roid('|81,')){
					$csv_data .= $info['hztel'].',';
				}else{
					$csv_data .= substr($info['hztel'],0,7).'****,';
				}

				$csv_data .= '['.$info['bingzx'].']'.$info['bingzm'].',';
				$csv_data .= $info['yynum'].',';
				$csv_data .= date('Y-m-d',$info['yytime1']).'~'.date('Y-m-d',$info['yytime2']).',';
				$csv_data .= $info['jzzj'].',';
				$csv_data .= $info['yyzxy'].',';
				$csv_data .= $info['yytj'].',';
				$csv_data .= $info['yykey'].',';
				$csv_data .= $info['lyfs'].',';
				$csv_data .= $info['jzqk'].',';
				$str='';
				$str=$info['tover']==1?'接管':'';
				$csv_data .= $str."\n";
				echo $csv_data;
			}
			export_csv($filename);
		}
		
		$page = $_GET['page'] ? intval($_GET['page']) : '1';
		$_SESSION['page']=$page;
		
		$perpage = 20;
		
		$infos = $this->db->listinfo('lydate>0 and '.$where, 'lydate desc, yyzxy asc', $page, $perpage);
		$pages = $this->db->pages;
		
		$topages = ceil($this->db->number/$perpage);
		$prevpage = $page-1;
		$nextpage = $page+1;
		
		//键盘上下页
		if($prevpage==0) $prevpage=1;
		if($nextpage>$topages) $nextpage=$topages;
		$prevpage=pageurl(url_par('page={$page}'), $prevpage);
		$nextpage=pageurl(url_par('page={$page}'), $nextpage);
		
		include $this->admin_tpl('dyua_list');
	}
	
	public function public_add() {
		$action=__FUNCTION__;
		
		//权限判断
		if(!admin::check_roid('|23,')) showmessdialog('无权操作！', 300, HTTP_REFERER, 'noajax');
		
		if(isset($_GET['dosubmit'])) {
			$info = array();
			$info = $_POST['info'];
			if($this->savepostedit($info)){
				showmessdialog('操作成功！', 200,'./?m=admin&c=dyua&a=public_list');
			}else{
				showmessdialog('操作出错！');
			}
		}else{
		
			$bzks_list = $this->bzks_db->listinfo('', 'listorder desc, id asc', 1, 100);
			$diqu_list = $this->diqu_db->listinfo('', 'listorder desc, id asc', 1, 100);
			
			$zjys_list = $this->zjys_db->listinfo("explains like '%类别%'", 'listorder desc, id asc', 1, 100);
			$jzqk_list = $this->jzqk_db->listinfo('', 'listorder desc, id asc', 1, 100);
			$lyfs_list = $this->lyfs_db->listinfo('', 'listorder desc, id asc', 1, 100);
			
			//处理专家数组
			foreach($zjys_list as &$row) {
				$row['explains']='';
				$e = $this->zjys_db->listinfo("explains like '%$row[cname]%'", 'listorder desc, id asc', 1, 100);
				if($e){
					foreach($e as $k=>$rowb) {
						$row['explains'].=$rowb['cname'].'，';
					}
				}
			}
			
			$r=array();
			$r['lydate']=date('Y-m-d',SYS_TIME);
			$r['yytime1']=date('Y-m-d',$r['yytime1']);
			$r['yytime2']=date('Y-m-d',$r['yytime2']);
			include $this->admin_tpl('main_edit');
		}
	}
	
	public function public_edit() {
		$action=__FUNCTION__;
		
		//权限判断
		if(!admin::check_roid('|23,')) showmessdialog('无权操作！', 300, HTTP_REFERER, 'noajax');
		
		if(isset($_GET['dosubmit'])) {
			if(isset($_SESSION['page'])){
				$page_param='&page='.$_SESSION['page'];
			}
			$info = array();
			$info = $_POST['info'];
			$cid = intval($info['cid']);
			if($this->savepostedit($info, 'edit', $cid)){
				$currurl=param::get_cookie('comm_currurl');
				if($currurl!=''){
					showmessdialog('操作成功！', 200, $currurl);
				}else{
					showmessdialog('操作成功！', 200, './?m=admin&c=dyua&a=public_list'.$page_param);
				}
			}else{
				showmessdialog('操作出错！');
			}
		}else{
			$cid=intval($_GET['cid']);
			
			$bzks_list = $this->bzks_db->listinfo('', 'listorder desc, id asc', 1, 100);
			$diqu_list = $this->diqu_db->listinfo('', 'listorder desc, id asc', 1, 100);
			
			$zjys_list = $this->zjys_db->listinfo("explains like '%类别%'", 'listorder desc, id asc', 1, 100);
			$jzqk_list = $this->jzqk_db->listinfo('', 'listorder desc, id asc', 1, 100);
			$lyfs_list = $this->lyfs_db->listinfo('', 'listorder desc, id asc', 1, 100);
			
			//处理专家数组
			foreach($zjys_list as &$row) {
				$row['explains']='';
				$e = $this->zjys_db->listinfo("explains like '%$row[cname]%'", 'listorder desc, id asc', 1, 100);
				if($e){
					foreach($e as $k=>$rowb) {
						$row['explains'].=$rowb['cname'].'，';
					}
				}
			}
			
			$r=array();
			$r=$this->db->get_one(array('id'=>$cid));
			$u=$this->db_dt->get_one(array('id'=>$cid));
			
			if($r['lydate']==0)
			$r['lydate']=SYS_TIME;
			
			$r['lydate']=date('Y-m-d',$r['lydate']);
			$r['yytime1']=date('Y-m-d',$r['yytime1']);
			$r['yytime2']=date('Y-m-d',$r['yytime2']);
			$r['remark']=$u['remark'];
			$r['jzremark']=$u['jzremark'];
			
			include $this->admin_tpl('dyua_edit');
		}
	}
	
	private function savepostedit($info, $ctrl='add', $cid=0){
		
		if($ctrl=='edit'&&$cid==0 || $ctrl=='edit'&&$cid==''){
			return false;
		}
		$post_fields = array('djname', 'bingz', 'hzcity', 'lydate', 'sjxf', 'jzzj', 'jzqk', 'lyfs', 'jzremark');
		foreach ($info as $k=>$value) {
			$info[$k]=trim($value);
			if (!in_array($k, $post_fields)){
				unset($info[$k]);
			}
		}
		
		if($info['bingz']!=''){
			$bingz=explode('[',$info['bingz']);
			$info['bingzx']=str_replace(']','',$bingz[1]);
			$info['bingzm']=$bingz[0];
		}
		unset($info['bingz']);
		
		$info['lydate']=strtotime($info['lydate']);
		
		if($info['lydate']==''){
			showmessdialog('来院时间不能为空！');
		}
		
		if($info['jzzj']==''){
			showmessdialog('接诊专家不能为空！');
		}
		
		if($info['jzqk']==''){
			showmessdialog('就诊情况不能为空！');
		}
		
		if($info['lyfs']==''){
			showmessdialog('来院方式不能为空！');
		}
		
		$jzremark=$info['jzremark'];
		unset($info['jzremark']);
		
		if($ctrl=='add'){
			/*$this->db->insert($info);
			$cid=$this->db->insert_id();
			if($cid){
				$this->db_dt->insert(array('id'=>$cid, 'jzremark'=>$jzremark));
				return true;
			}else{
				return false;
			}*/
		}
		
		if($ctrl=='edit'){
			$result=$this->db->update($info, array('id'=>$cid));
			if($result){
				$this->db_dt->update(array('jzremark'=>$jzremark), array('id'=>$cid));
				return true;
			}else{
				return false;
			}
		}
		
		return false;
	}
	
	/**
	 * 批量删除
	 */
	public function deleteds(){
		//权限判断
		if(!admin::check_roid('|24,')) showmessdialog('无权操作！');

		if(isset($_GET['dosubmit'])) {
			if(empty($_POST['ids'])) showmessdialog('您没有勾选信息！');
			foreach($_POST['ids'] as $id) {
				$this->db->update(array('lydate'=>NULL, 'jzzj'=>NULL, 'lyfs'=>NULL, 'jzqk'=>NULL, 'sjxf'=>0.00), array('id'=>$id));
			}
			showmessdialog('操作成功', 200, 'reload');
		}
	}
	
	
	private function judge_role($model=0, $info){
		if($model==0){ //电话
			if(admin::check_roid('|81,')){ //显示电话权限直接返回
				echo '<span title="'.$info['hztel'].'">'.str_cut($info['hztel'],3*5).'</span>';
				return;
			}
			echo '<span>'.substr($info['hztel'],0,7).'</span><font color="#777777">****</font>';
			return;
		}
		if($model==8){ //实际消费
			if(admin::check_roid('|25,')){ //显示实际消费直接返回
				echo $info['sjxf'];
				return;
			}
			echo '*****';
			return;
		}
	}

}
?>