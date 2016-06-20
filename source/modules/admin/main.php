<?php
defined('IN_SYS') or exit('No permission resources.');
pc_base::load_app_class('admin','admin',0);
pc_base::load_app_func('comm');

class main extends admin {
	public function __construct() {
		parent::__construct();
		
		$this->ntake = 7; //接管时间
		$this->currgroup = false; //分组判断

		$this->db = pc_base::load_model('yuyue_model');
		$this->db_dt = pc_base::load_model('yuyue_data_model');
		
		$this->bzks_db = pc_base::load_model('bzks_model');
		$this->diqu_db = pc_base::load_model('diqu_model');
		$this->zjys_db = pc_base::load_model('zjys_model');
		$this->zxzy_db = pc_base::load_model('zxzy_model');
		$this->yytj_db = pc_base::load_model('yytj_model');
		
		$this->edlogs_db = pc_base::load_model('edlogs_model');
	}
	
	public function init () {
		/*$userid = $_SESSION['userid'];
		$admin_username = self::$username;
		$roles = getcache('role','commons');
		$rolename = $roles[$_SESSION['roleid']];
		$site = pc_base::load_app_class('sites');
		$sitelist = $site->get_list($_SESSION['roleid']);
		$currentsite = $this->get_siteinfo(param::get_cookie('siteid'));*/
		/*管理员收藏栏*/
		/*$adminpanel = $this->panel_db->select(array('userid'=>$userid), "*",20 , 'datetime');
		$site_model = param::get_cookie('site_model');*/
		self::public_list();
	}
	
	public function public_list() {
		$action=__FUNCTION__;
		$fromer=$_GET['c'];
		
		param::set_cookie('comm_currurl', get_url());

		$username = self::$username;
		$r=$this->zxzy_db->get_one(array('cname'=>$username));
		$this->currgroup = trim($r['explains']);
		
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
		
		$where='yydate>0';
		$order='yydate desc, yyzxy asc';
		$sedate=date('Y-m-d',strtotime('-5 month',SYS_TIME)).' 至 '.date('Y-m-d',SYS_TIME);
		
		$show=trim($_GET['s']);
		
		$gdate=$show;
		if($show=='prtomor')
		$gdate='tomor';
		
		if($show=='prtoday'||$show=='prnear'||$show=='prnonat')
		$gdate='today';
		
		$rdate=getdaterange($gdate);
		if($rdate['stdate']!=''&&$rdate['endate']!=''){
			$stdate=$rdate['stdate'];
			$endate=$rdate['endate'];
			
			if($show=='prtomor'||$show=='prtoday'){
				$where="yytime1 <= '$stdate' and yytime2 >= '$endate'";
				$where='lydate=0 and '.$where;
				$order='yytime1 desc, yyzxy asc';
			}elseif($show=='prnear'){
				$endate=strtotime('+1 month',$stdate);
				$where="yytime1 >= '$stdate' and yytime2 <= '$endate'";
				$where='lydate=0 and '.$where;
				$order='yytime1 asc, yyzxy asc';
			}elseif($show=='prnonat'){
				$where="yytime2 < '$stdate'";
				$where='lydate=0 and '.$where;
				$order='yytime2 desc, yyzxy asc';
			}else{
				$where="yydate >= '$stdate' and yydate <= '$endate'";
			}
		}
		
		if($param['stdate']!=''&&$param['endate']!=''){
			$stdate=strtotime($param['stdate']);
			$endate=strtotime($param['endate']);
			$where="yydate >= '$stdate' and yydate <= '$endate'";
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
							" )");
			$sewhere=join('',$sewhere);
			$where=$where.$sewhere;
		}
		
		if(isset($stdate)&&isset($endate)){
			$stdate=date('Y-m-d',$stdate);
			$endate=date('Y-m-d',$endate);
			$sedate=$stdate.' 至 '.$endate;
		}
		
		//echo $where;
		
		//导出CSV
		if($_GET['echo']=='export'){
			if(!admin::check_roid('|83,')) showmessdialog('无权操作！', 300, HTTP_REFERER, 'noajax');
			$filename = str_replace(' ', '', $sedate.'预约数据');
			$csv_data = "日期,姓名,性别,年龄,地区,电话,病种,预约号,预计时间,预约专家,咨询员,预约途径,关键词,班次,到院情况,接管状态\n";
			$infos = $this->db->select($where, '*', '6000', $order);
			ob_start();
			echo $csv_data;
			foreach($infos as $k=>$info) {
				$csv_data = '';
				$csv_data .= date('Y-m-d',$info['addtime']).',';
				$csv_data .= $info['hzname'].',';
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
				$csv_data .= $info['yyzj'].',';
				$csv_data .= $info['yyzxy'].',';
				$csv_data .= $info['yytj'].',';
				$csv_data .= $info['yykey'].',';
				$csv_data .= '…,';
				$str='';
				$str=$info['lyfs']!=''?'已到院':'';
				$csv_data .= $str.',';
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
		
		$infos = $this->db->listinfo($where, $order, $page, $perpage);
		$pages = $this->db->pages;
		
		$topages = ceil($this->db->number/$perpage);
		$prevpage = $page-1;
		$nextpage = $page+1;
		
		//键盘上下页
		if($prevpage==0) $prevpage=1;
		if($nextpage>$topages) $nextpage=$topages;
		$prevpage=pageurl(url_par('page={$page}'), $prevpage);
		$nextpage=pageurl(url_par('page={$page}'), $nextpage);
		
		include $this->admin_tpl('main_list');
	}
	
	public function public_add() {
		$action=__FUNCTION__;
		
		//权限判断
		if(!admin::check_roid('|17,')) showmessdialog('无权操作！', 300, HTTP_REFERER, 'noajax');

		$username = self::$username;

		if(isset($_GET['dosubmit'])) {
			$info = array();
			$info = $_POST['info'];
			if($this->savepostedit($username, $info)){
				showmessdialog('操作成功！', 200, './?m=admin&c=main&a=public_list');
			}else{
				showmessdialog('操作出错！');
			}
		}else{
			$bzks_list = $this->bzks_db->listinfo('', 'listorder desc, id asc', 1, 100);
			$diqu_list = $this->diqu_db->listinfo('', 'listorder desc, id asc', 1, 100);
			
			$zxzy_list = $this->zxzy_db->listinfo('', 'listorder desc, id asc', 1, 100);
			
			$zjys_list = $this->zjys_db->listinfo("explains like '%类别%'", 'listorder desc, id asc', 1, 100);
			$yytj_list = $this->yytj_db->select('', 'explains', '', 'explains desc', 'explains');

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

			//处理途径数组
			foreach($yytj_list as &$row) {
				$row['cname']=$row['explains'];
				$row['explains']='';
				$e = $this->yytj_db->listinfo("explains like '%$row[cname]%'", 'listorder desc, id asc', 1, 100);
				if($e){
					foreach($e as $k=>$rowb) {
						$row['explains'].=$rowb['cname'].'，';
					}
				}
			}
			
			$r=array();
			$r['yyzxy']=$username;
			$r['yydate']=date('Y-m-d',SYS_TIME);
			$r['yytime1']=date('Y-m-d',SYS_TIME);
			$r['yytime2']=date('Y-m-d',SYS_TIME+86400*7);
			$r['yytimes']=$r['yytime1'].' 至 '.$r['yytime2'];

			include $this->admin_tpl('main_edit');
		}
	}
	
	public function public_edit() {
		$action=__FUNCTION__;

		$ctrl=trim($_GET['ctrl']);

		//权限判断
		if(!admin::check_roid('|13,') && !admin::check_roid('|14,')
			&& !admin::check_roid('|18,') //接管
			&& !admin::check_roid('|111,')) showmessdialog('无权操作！', 300, HTTP_REFERER, 'noajax');

		$username = self::$username;
		$r=$this->zxzy_db->get_one(array('cname'=>$username));
		$this->currgroup = trim($r['explains']);

		if(isset($_GET['dosubmit'])) {

			if(isset($_GET['s'])){
				$page_param='&s='.$_GET['s'];
			}
			if(isset($_SESSION['page'])){
				$page_param='&page='.$_SESSION['page'];
			}
			$info = array();
			$info = $_POST['info'];
			$cid = intval($info['cid']);

			//权限放绕 开始
			$igroup=false;
			if($this->currgroup){
				$r=$this->zxzy_db->get_one(array('explains'=>$this->currgroup, 'cname'=>$info['yyzxy']));
				if($r) $igroup=true;
			}
			$r=array();
			$r=$this->db->get_one(array('id'=>$cid));
			if(!$r) showmessdialog('参数错误！');

			//权限判断 已到院不能修改
			if($username!=self::$admin_super && $r['lyfs']!='') showmessdialog('无权操作！');
			
			if(admin::check_roid('|14,') && $username!=self::$admin_super && $igroup!=true) showmessdialog('无权操作！');

			//权限防绕 结束

			if($this->savepostedit($username, $info, 'edit', $cid)){
				$currurl=param::get_cookie('comm_currurl');
				if($currurl!=''){
					showmessdialog('操作成功！', 200, $currurl);
				}else{
					showmessdialog('操作成功！', 200, './?m=admin&c=main&a=public_list'.$page_param);
				}
			}else{
				showmessdialog('操作出错！');
			}
		}else{
			$cid=intval($_GET['cid']);
			$_SESSION['recid'] = $cid; //保存记录ID到会话以便AJAX使用

			$bzks_list = $this->bzks_db->listinfo('', 'listorder desc, id asc', 1, 100);
			$diqu_list = $this->diqu_db->listinfo('', 'listorder desc, id asc', 1, 100);
			
			$zxzy_list = $this->zxzy_db->listinfo('', 'listorder desc, id asc', 1, 100);

			$zjys_list = $this->zjys_db->listinfo("explains like '%类别%'", 'listorder desc, id asc', 1, 100);
			
			//$yytj_list = $this->yytj_db->listinfo('', 'listorder desc, id asc', 1, 100);
			$yytj_list = $this->yytj_db->select('', 'explains', '', 'explains desc', 'explains');

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

			//处理途径数组
			foreach($yytj_list as &$row) {
				$row['cname']=$row['explains'];
				$row['explains']='';
				$e = $this->yytj_db->listinfo("explains like '%$row[cname]%'", 'listorder desc, id asc', 1, 100);
				if($e){
					foreach($e as $k=>$rowb) {
						$row['explains'].=$rowb['cname'].'，';
					}
				}
			}
			
			$r=array();
			$r=$this->db->get_one(array('id'=>$cid));
			if(!$r) showmessdialog('参数错误！', 300, HTTP_REFERER, 'noajax');

			$u=$this->db_dt->get_one(array('id'=>$cid));

			//权限判断
			if(admin::check_roid('|13,') && $username!=$r['yyzxy']
				&& !admin::check_roid('|18,') //接管
				&& !admin::check_roid('|111,')) showmessdialog('无权操作！', 300, HTTP_REFERER, 'noajax');

			//$r['yydate']=date('Y-m-d',SYS_TIME);
			$r['yydate']=date('Y-m-d',$r['yydate']);
			$r['yytime1']=date('Y-m-d',$r['yytime1']);
			$r['yytime2']=date('Y-m-d',$r['yytime2']);
			$r['yytimes']=$r['yytime1'].' 至 '.$r['yytime2'];
			$r['remark']=$u['remark'];
			$r['jzremark']=$u['jzremark'];
			
			include $this->admin_tpl('main_edit');
		}
	}
	
	private function savepostedit($username, $info, $ctrl='add', $cid=0) {
		
		if($ctrl=='edit'&&$cid==0 || $ctrl=='edit'&&$cid==''){
			return false;
		}
		$post_fields = array('yydate', 'hzname', 'djname', 'hzsex', 'hzage', 'hzcity', 'hztel', 'bingz', 'yynum', 'yytime1', 'yytime2', 'yyzxy', 'yytj', 'yyzj', 'yykey', 'hfjg', 'remark');
		foreach ($info as $k=>$value) {
			$info[$k]=trim($value);
			if (!in_array($k, $post_fields)){
				unset($info[$k]);
			}
		}
		
		$bool=false;
		$r=$this->db->get_one(array('id'=>$cid));

		//部门分组
		$b = $this->yytj_db->get_one(array('cname'=>$info['yytj']));
		$info['bmfz']=$b['explains'];
		
		$bingz=explode('[',$info['bingz']);
		$info['bingzx']=str_replace(']','',$bingz[1]);
		$info['bingzm']=$bingz[0];
		unset($info['bingz']);
		
		$info['yydate']=strtotime($info['yydate']);
		$info['yytime1']=strtotime($info['yytime1']);
		$info['yytime2']=strtotime($info['yytime2']);
		
		if($info['yydate']==''){
			showmessdialog('日期不能为空！');
		}
		
		if($info['hzname']==''){
			showmessdialog('患者姓名不能为空！');
		}
		
		if($info['hztel']==''){
			showmessdialog('患者联系电话不能为空！');
		}

		if($ctrl=='edit'){
			$d = $this->db->select("id!=$cid and yydate>0 and hztel=$info[hztel]", 'id', '1');
			if($d) showmessdialog('这个号码已经预约过，请确认是否重复预约！');
		}else{
			$d = $this->db->select("yydate>0 and hztel=$info[hztel]", 'id', '1');
			if($d) showmessdialog('这个号码已经预约过，请确认是否重复预约！');
		}
		
		if($info['bingzx']==''||$info['bingzm']==''){
			showmessdialog('科室病种不能为空！');
		}
		
		if($info['yynum']==''){
			showmessdialog('预约号不能为空！');
		}
		
		if($info['yytime1']==''){
			showmessdialog('预约时间不能为空！');
		}
		
		$timedt=$info['yytime2']-$info['yytime1'];
		if($timedt<0||intval(floor($timedt/86400))>30){
			showmessdialog('预约时间范围不能超过30天！');
		}
		
		/*if($info['yyzj']==''){
			showmessdialog('预约专家不能为空！');
		}*/
		
		if($info['yytj']==''){
			showmessdialog('预约途径不能为空！');
		}
		
		if($ctrl=='add'){
			$info['addtime']=SYS_TIME;
			$info['username']=$username;
		}

		$info_hztel=$info['hztel'];//保存电话号码用于修改记录数据
		if($ctrl=='edit'){
			unset($info['addtime']);
			if(!admin::check_roid('|14,')) unset($info['yydate']);
			if($r['tover']==1) unset($info['hztel']);
			if($info['hfjg']=='') unset($info['hfjg']);

			if(!admin::check_roid('|14,') && $username!=$r['yyzxy']) showmessdialog('无权操作！');
		}

		$remark=$info['remark'];
		$info['remark']=str_cut($remark,3*30);
		
		if($ctrl=='add'){
			$this->db->insert($info);
			$cid=$this->db->insert_id();
			if($cid){
				$this->db_dt->insert(array('id'=>$cid, 'remark'=>$remark));
				$bool=true;
			}
		}
		
		if($ctrl=='edit'){
			$result=$this->db->update($info, array('id'=>$cid));
			
			//echo $result2;
			//$result=$result&&$result2 ? true : false;
			if($result){
				$this->db_dt->update(array('remark'=>$remark), array('id'=>$cid));
				$bool=true;
			}
		}
		
		return $bool;
	}

	/**
	 * 回访记录操作
	 */
	public function revisit() {
		$gid=intval(trim($_POST['uid']));
		$cdata=trim($_POST['cdata']);
		$cid=trim($_SESSION['recid']);

		if($cdata==''||$cid=='') exit('error1');
		$username = self::$username;

		$r=$this->db->get_one(array('id'=>$cid));
		if($r){
			if(!admin::check_roid('|14,') && !admin::check_roid('|19,') && $r['yyzxy']!=$username){
				exit('error');
			}
			$this->db->update(array('hfjg'=>$cdata), array('id'=>$cid));
		}else{
			exit('error');
		}
		$g=$this->edlogs_db->get_one(array('id'=>$gid, 'username'=>$username));
		if($g){
			$this->edlogs_db->update(array('hfjg'=>$cdata), array('id'=>$gid));
		}else{
			$info_ed=array();
			$info_ed['yyid']=$cid;
			$info_ed['username']=$username;
			$info_ed['hfjg']=$cdata;
			$info_ed['addtime']=SYS_TIME;
			$this->edlogs_db->insert($info_ed);
		}
		exit('succeed');
	}
	
	/**
	 * 批量删除
	 */
	public function deleteds(){
		//权限判断
		if(!admin::check_roid('|15,') && !admin::check_roid('|16,')) showmessdialog('无权操作！');

		if(isset($_GET['dosubmit'])) {
			if(empty($_POST['ids'])) showmessdialog('您没有勾选信息！');
			foreach($_POST['ids'] as $id) {
				if(admin::check_roid('|16,')){
					$this->db->update(array('yydate'=>0), "lydate=0 and id=$id");
				}else{
					$this->db->update(array('yydate'=>0), "lydate=0 and id=$id and yyzxy='".self::$username."'");
				}
			}
			showmessdialog('操作成功', 200, 'reload');
		}
	}
	
	/**
	 * 修改某一字段数据
	 */
	public function update_param() {
		$id = intval($_GET['id']);
		$field = $_GET['field'];
		$modelid = intval($_GET['modelid']);
		$value = $_GET['value'];
		if (CHARSET!='utf-8') {
			$value = iconv('utf-8', 'gbk', $value);
		}
		//检查字段是否存在
		$this->db->set_model($modelid);
		if ($this->db->field_exists($field)) {
			$this->db->update(array($field=>$value), array('id'=>$id));
			exit('200');
		} else {
			$this->db->table_name = $this->db->table_name.'_data';
			if ($this->db->field_exists($field)) {
				$this->db->update(array($field=>$value), array('id'=>$id));
				exit('200');
			} else {
				exit('300');
			}
		}
	}

	private function judge_role($model=0, $info){

		if(admin::check_roid('|18,')){ //接管权限判断
			$igroup=false;
			$timedt=0;
		}

		$username = self::$username;
		if($model==0){ //电话
			if(admin::check_roid('|81,')){ //显示电话权限直接返回
				echo '<span title="'.$info['hztel'].'">'.str_cut($info['hztel'],3*5).'</span>';
				return;
			}
			echo '<span>'.substr($info['hztel'],0,7).'</span><font color="#777777">****</font>';
			return;
		}

		if($model==3){ //编辑电话
			if(ROUTE_A=='public_add'){ //录入
				echo $info['hztel'];
				return;
			}
			if(admin::check_roid('|81,')){ //显示电话权限直接返回
				echo $info['hztel'];
				return;
			}
			if(admin::check_roid('|14,') && $info['yyzxy']==$username){
				echo $info['hztel'];
				return;
			}
			if(admin::check_roid('|13,') && $info['yyzxy']==$username){
				echo $info['hztel'];
				return;
			}
			if(admin::check_roid('|19,')){
				echo $info['hztel'];
				return;
			}
			echo substr($info['hztel'],0,7).'****';
			return;
		}

		if($model==1){ //修改 接管 回访 详细
			if(admin::check_roid('|14,')){
				if($username==self::$admin_super){
					echo '<a href="./?m=admin&c=main&a=public_edit&cid='.$info['id'].'">修改</a>';
				}elseif($igroup==true && $info['lyfs']==''){
					echo '<a href="./?m=admin&c=main&a=public_edit&cid='.$info['id'].'">修改</a>';
				}else{

				}
				return;
			}

			if(admin::check_roid('|13,') && $info['yyzxy']==$username && $info['lyfs']==''){ //到院记录不能修改
				echo '<a href="./?m=admin&c=main&a=public_edit&cid='.$info['id'].'">修改</a>';
				return;
			}
			
			if(admin::check_roid('|19,') && $info['lyfs']==''){
				echo '<a href="./?m=admin&c=main&a=public_edit&ctrl=revisit&cid='.$info['id'].'" class="green">回访</a>';
				return;
			}

			if(admin::check_roid('|111,')){
				echo '<a href="./?m=admin&c=main&a=public_edit&&ctrl=views&cid='.$info['id'].'" class="green">查看</a>';
				return;
			}
		}

		if($model==2){ //编辑提交按钮
			if(admin::check_roid('|17,') && ROUTE_A=='public_add'){ //录入
				echo '<button type="submit" class="btn btn-primary">提 交</button>&nbsp;';
				return;
			}

			if(admin::check_roid('|14,')){
				echo '<button type="submit" class="btn btn-primary">提 交</button>&nbsp;';
				return;
			}
			if(admin::check_roid('|13,') && $info['yyzxy']==$username){
				echo '<button type="submit" class="btn btn-primary">提 交</button>&nbsp;';
				return;
			}
		}
		if($model==4){
			$tover=false;
			if(ROUTE_A=='public_edit' && !admin::check_roid('|14,')
				&& admin::check_roid('|18,') && $username!=$info['yyzxy']
				|| $info['tover']==1) $tover=true;
			return $tover;
		}
	}

}
?>