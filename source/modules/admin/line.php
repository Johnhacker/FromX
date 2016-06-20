<?php
defined('IN_SYS') or exit('No permission resources.');
pc_base::load_app_class('admin','admin',0);
pc_base::load_app_func('comm');

class line extends admin {
	public function __construct() {
		parent::__construct();
		
		$this->db = pc_base::load_model('pbqk_model');
		$this->db_dt = pc_base::load_model('pbqk_data_model');
	}
	
	public function init () {
		self::public_list();
	}
	
	public function public_list() {
		$action=__FUNCTION__;

		//权限判断
		if(!admin::check_roid('|51,')) showmessdialog('无权操作！', 300, HTTP_REFERER, 'noajax');
		
		$cid=intval($_GET['s']);
		
		$arr_week=array('日','一','二','三','四','五','六');
		$pbmonth=intval(date('m',SYS_TIME));
		$maxday=intval(date('t',SYS_TIME));
		$dclass='';
		$dstyle='';
		
		$thead=array();
		$weeks=array();
		$pbval=array();
		
		for($i=1; $i<=31; $i++){
			$thead[]=$i;
		}
		for($i=1; $i<=31; $i++){
			$weeks[]=$arr_week[date('w',strtotime(date('Y-m',SYS_TIME)."-$i"))];
		}
		for($i=1; $i<=31; $i++){
			$pbval[]=$i;
		}
		
		$r = $this->db->get_one(array('id'=>$cid));
		
		$pblist='';
		$p = $this->db_dt->get_one(array('pbmonth'=>$pbmonth, 'pbsort'=>$r['cname']));
		$pblist=unserialize($p['pbcontent']);

		for($i=1; $i<=31; $i++){
			if($i>$maxday){
				array_pop($thead);
				array_pop($weeks);
				array_pop($pblist);
			}
		}

		$actioname=$r['cname'];
		
		if($_GET['echo']=='export'){
			$filename=str_replace(' ', '', $pbmonth.'月份'.$actioname);
			$csv_data = ','.implode(',',$thead)."\n";

			ob_start();
			echo $csv_data;
			$csv_data = ','.implode(',',$weeks)."\n";
			echo $csv_data;
			foreach($pblist as $k=>$info) {
				$csv_data = '';
				$csv_data .= $info[0][0];
				$csv_data .= $info[0][1]."\n";
				echo $csv_data;
			}
			export_csv($filename);
		}

		include $this->admin_tpl('line_list');
	}
	
	public function public_pbset() {
		$action=__FUNCTION__;

		//权限判断
		if(!admin::check_roid('|52,')) showmessdialog('无权操作！', 300, HTTP_REFERER, 'noajax');
		
		//排班设置
		if(isset($_GET['dosubmit'])) {
			$pbsort = isset($_POST['pbsort']{3}) && trim($_POST['pbsort']) ? trim($_POST['pbsort']) : showmessdialog('名称不能为空！');
			$pbmonth = isset($_POST['pbmonth']) && trim($_POST['pbmonth']) ? trim($_POST['pbmonth']) : showmessdialog('月份不能为空！');
			$pbdata = isset($_POST['pbdata']{3}) && trim($_POST['pbdata']) ? trim($_POST['pbdata']) : showmessdialog('排班内容不能为空！');
			
			$pbdata_a=array();
			$pbdata_b=array();
			$pbdata_t=array();
			
			$pbdata_t=explode('$',$pbdata);
			
			foreach($pbdata_t as $row) {
				if(trim($row)!=''){
					$pbdata_b='';
					$pbdata_b[]=explode('|',$row);
					$pbdata_a[]=$pbdata_b;
				}
			}
			
			$pbdata=serialize($pbdata_a);
			
			if($_POST['ctrl']=='modify' && $_POST['cid']!=''){
				$cid=intval($_POST['cid']);
				$this->db_dt->update(array('pbsort'=>$pbsort, 'pbmonth'=>$pbmonth, 'pbcontent'=>$pbdata), array('id'=>$cid));
			}else{
				$this->db_dt->insert(array('pbsort'=>$pbsort, 'pbmonth'=>$pbmonth, 'pbcontent'=>$pbdata, 'addtime'=>SYS_TIME));
			}

			showmessdialog('操作成功', 200, './?m=admin&c=line&a='.__FUNCTION__);
			
		}else{
			$arr_week=array('日','一','二','三','四','五','六');
			$maxday=intval(date('t',SYS_TIME));
			$dclass='';
			$dstyle='';
			
			$thead=array();
			$weeks=array();
			$pblist=array(0);
			$pbval=array();
			
			for($i=1; $i<=31; $i++){
				$thead[]=$i;
			}
			
			for($i=1; $i<=31; $i++){
				$weeks[]=$arr_week[date('w',strtotime(date('Y-m',SYS_TIME)."-$i"))];
			}
			for($i=1; $i<=31; $i++){
				$pbval[]=$i;
			}
			
			$pbqk_list = $this->db->listinfo('', 'listorder desc, id asc', 1, 100);
			
			if(isset($_GET['ctrl'])=='modify') {
				$pblist='';
				$cid=intval($_GET['cid']);
				$r = $this->db_dt->get_one(array('id'=>$cid));
				$r['cid']=$r['id'];
				$pblist=unserialize($r['pbcontent']);
				$ctrl='modify';
			}
			
			$page = $_GET['page'] ? intval($_GET['page']) : '1';
			$infos = $this->db_dt->listinfo('', 'id desc', $page, 20);
			$pages = $this->db_dt->pages;
			
			include $this->admin_tpl('line_edit');
		}
	}

	public function deleteds(){
		if(isset($_GET['dosubmit'])) {
			if(empty($_POST['ids'])) showmessdialog('您没有勾选信息！');
			foreach($_POST['ids'] as $id) {
				$this->db->delete(array('id'=>$id));
			}
			showmessdialog('操作成功', 200, 'reload');
		}
	}

}
?>