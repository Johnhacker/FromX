<?php
defined('IN_SYS') or exit('No permission resources.');
pc_base::load_app_class('admin','admin',0);
pc_base::load_app_func('comm');

class comp extends admin {
	public function __construct() {
		parent::__construct();
		
		/*$this->db = pc_base::load_model('yuyue_model');*/
		$this->wlxf_db = pc_base::load_model('wlxf_model');
		$this->wlxf_db_dt = pc_base::load_model('wlxf_data_model');
		$this->wlzh_db_dt = pc_base::load_model('wlzh_data_model');
	}
	
	public function init () {
		self::public_list();
	}
	
	public function public_wlxf_list() {
		$action=__FUNCTION__;
		
		//权限判断
		if(!admin::check_roid('|31,')) showmessdialog('无权操作！', 300, HTTP_REFERER, 'noajax');

		/*$smonth=date('Y-m',SYS_TIME);
		$stdate=strtotime($smonth.'-1');
		$endate=strtotime(date('Y-m-t',$stdate));*/
		
		$rdate=getdaterange(trim($_GET['s']));
		if($rdate['stdate']!=''&&$rdate['endate']!=''){
			$stdate=$rdate['stdate'];
			$endate=$rdate['endate'];
			$where="rcdate >= '$stdate' and rcdate <= '$endate'";
		}
		
		$arr_wlxf = $this->wlxf_db_dt->select($where, 'cname', '', 'cname desc', 'cname');
		array_unshift($arr_wlxf,array('cname'=>'日期'));
		array_push($arr_wlxf,array('cname'=>'合计'));//横轴
		array_push($arr_wlxf,array('cname'=>'操作'));
		
		//表头设置
		$arr_thead=array();
		
		foreach($arr_wlxf as $row){
			foreach($row as $key=>$rowb){
				//echo $key;
				//json_encode($rowb);
				$arr_thead[]=$row[$key];
			}
		}
		
		$infos=array();
		$arr=array();
		$arr_wlzh = $this->wlzh_db_dt->select($where, 'id,rcdate', '', 'rcdate desc', 'rcdate');
		$arr_wlzh[]=array('rcdate'=>'合计');//竖轴
		
		foreach($arr_wlzh as $row){//竖轴
			$arr='';
			foreach($arr_wlxf as $rowb){//横轴
				if($rowb['cname']=='日期'){
					$arr[]=$row['rcdate']=='合计' ? $row['rcdate'] : date('Y-m-d',$row['rcdate']);
				}elseif($rowb['cname']=='合计'){
					if($row['rcdate']=='合计'){
						$tdata=$this->wlxf_db_dt->sum('tgcost', $where);
					}else{
						$tdata=$this->wlxf_db_dt->sum('tgcost', "rcdate='$row[rcdate]'");
					}
					$arr[]=$tdata;
				}elseif($rowb['cname']=='操作'){
					if($row['rcdate']=='合计'){
						
					}else{
						$arr[]='<a href="./?m=admin&c=comp&a=public_wlxf_edit&ctrl=modify&cid='.$row['id'].'">修改</a>';
					}
				}else{
					if($row['rcdate']=='合计'){
						$tdata=$this->wlxf_db_dt->sum('tgcost', "rcdate >= '$stdate' and rcdate <= '$endate' and cname='$rowb[cname]'");
					}else{
						$tdata=$this->wlxf_db_dt->sum('tgcost', "rcdate='$row[rcdate]' and cname='$rowb[cname]'");
					}
					$arr[]=$tdata;
				}
			}
			$infos[]=$arr;
		}
		
		include $this->admin_tpl('comp_wlxf_list');
	}
	
	public function public_wlxf_add() {
		$action=__FUNCTION__;
		
		//权限判断
		if(!admin::check_roid('|32,')) showmessdialog('无权操作！', 300, HTTP_REFERER, 'noajax');

		if(isset($_GET['dosubmit'])) {
			$info = array();
			$info = $_POST['info'];
			if($this->savepostedit($info)){
				showmessdialog('操作成功！', 200,'./?m=admin&c=comp&a=public_wlxf_list&s=cmonth');
			}else{
				showmessdialog('操作出错！');
			}
		}else{
			
			$infos = $this->wlxf_db->listinfo('', 'listorder desc, id asc', 1, 100);
			$r=array();
			$r['rcdate']=date('Y-m-d',strtotime('-1 day',SYS_TIME));
			 
			include $this->admin_tpl('comp_wlxf_edit');
		}
	}
	
	public function public_wlxf_edit() {
		$action=__FUNCTION__;
		
		//权限判断
		if(!admin::check_roid('|32,')) showmessdialog('无权操作！', 300, HTTP_REFERER, 'noajax');
		
		if(isset($_GET['dosubmit'])) {
			$info = array();
			$info = $_POST['info'];
			$cid = intval($info['cid']);
			if($this->savepostedit($info, 'edit', $cid)){
				showmessdialog('操作成功！', 200, './?m=admin&c=comp&a=public_wlxf_list&s=cmonth');
			}else{
				showmessdialog('操作出错！');
			}
		}else{
			$cid=intval($_GET['cid']);
			
			$arr_tem=array();
			$infos = $this->wlxf_db_dt->listinfo("catid='$cid'", 'cname desc, id asc', 1, 100);
			$arr_wlxf = $this->wlxf_db->listinfo('', 'listorder desc, id asc', 1, 100);
			foreach($arr_wlxf as $row){
				foreach($infos as $rowb){
					if($rowb['cname']!=$row['cname']){
						$arr_tem[]=$row;
					}
				}
			}
			$r=$this->wlzh_db_dt->get_one(array('id'=>$cid));
			$r['rcdate']=date('Y-m-d',$r['rcdate']);
			
			include $this->admin_tpl('comp_wlxf_edit');
		}
	}
	
	private function savepostedit($info, $ctrl='add', $cid=0){
		
		if($ctrl=='edit'&&$cid==0 || $ctrl=='edit'&&$cid==''){
			return false;
		}
		
		$info['rcdate']=strtotime($info['rcdate']);
		
		if($info['rcdate']==''){
			showmessdialog('日期不能为空！');
		}
		
		if($ctrl=='add'){
			$r=$this->wlzh_db_dt->get_one(array('rcdate'=>$info['rcdate']));
			if($r['id']!=''){
				showmessdialog('当前日期已经存在记录！');
			}
			
			$this->wlzh_db_dt->insert(array('rcdate'=>$info['rcdate'], 'addtime'=>SYS_TIME));
			$cid=$this->wlzh_db_dt->insert_id();
			if($cid){
				$arr_wlxf = $this->wlxf_db->listinfo('', 'listorder desc, id asc', 1, 100);
				foreach($arr_wlxf as $row){
					$tgcost='';
					$tgcost=sprintf('%.2f', $info['wlxf'.$row['id']]);
					if($tgcost!=0){
						$this->wlxf_db_dt->insert(array('catid'=>$cid, 'rcdate'=>$info['rcdate'], 'cname'=>$row['cname'], 'tgcost'=>$tgcost, 'addtime'=>SYS_TIME));
					}
				}
				return true;
			}else{
				return false;
			}
		}
		
		if($ctrl=='edit'){
			/*$result=$this->wlxf_db->update($info, array('id'=>$cid));
			if($result){
				$this->wlxf_db_dt->update(array('jzremark'=>$jzremark), array('id'=>$cid));
				return true;
			}else{
				return false;
			}*/
		}
		
		return false;
	}

}
?>