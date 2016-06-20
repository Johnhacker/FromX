<?php
defined('IN_SYS') or exit('No permission resources.');
pc_base::load_app_class('admin','admin',0);
pc_base::load_app_func('comm');

class repo extends admin {
	public function __construct() {
		parent::__construct();
		
		$this->db = pc_base::load_model('yuyue_model');
		$this->yytj_db = pc_base::load_model('yytj_model');
	}
	
	public function init () {
		self::public_dyuan();
	}
	
	public function public_dyuan() {
		$action=__FUNCTION__;
		$actioname='到院数据报表';
		$ctrl=$action;

		//权限判断
		if(!admin::check_roid('|A5,')) showmessdialog('无权操作！', 300, HTTP_REFERER, 'noajax');

		//到院报表
		$rndate=self::get_daterange();
		$stdate=$rndate['stdate'];
		$endate=$rndate['endate'];
		
		$where="lydate >= '$stdate' and lydate <= '$endate'";
		
		if(isset($stdate)&&isset($endate)){
			$stdate=date('Y-m-d',$stdate);
			$endate=date('Y-m-d',$endate);
			if($_GET['s']!='cmonth')
			$sedate=$stdate.' 至 '.$endate;
		}
		
		//导出CSV
		if($_GET['echo']=='export'){
			$filename = str_replace(' ', '', $sedate.'到院数据');
			$csv_data = "到院日期,姓名,真实姓名,性别,年龄,预约号,科室,病种,接诊专家,咨询员,预约途径,来院方式,就诊情况,实际消费,关键词\n";
			$infos = $this->db->select('lydate>0 and '.$where, '*', '6000', 'lydate desc, yyzxy asc');
			ob_start();
			foreach($infos as $k=>$info) {
				$csv_data = '';
				$csv_data .= date('Y-m-d',$info['lydate']).',';
				$csv_data .= $info['hzname'].',';
				$csv_data .= $info['djname'].',';
				$csv_data .= $info['hzsex'].',';
				$csv_data .= $info['hzage'].',';
				$csv_data .= $info['yynum'].',';
				$csv_data .= $info['bingzx'].',';
				$csv_data .= $info['bingzm'].',';
				$csv_data .= $info['jzzj'].',';
				$csv_data .= $info['yyzxy'].',';
				$csv_data .= $info['yytj'].',';
				$csv_data .= $info['lyfs'].',';
				$csv_data .= $info['jzqk'].',';
				$csv_data .= $info['sjxf'].',';
				$csv_data .= $info['yykey'].',';
				$csv_data .= "\n";
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
		
		include $this->admin_tpl('repo_dyuan');
	}
	
	public function public_zxytj() {
		$action=__FUNCTION__;
		$actioname='咨询员途径报表';
		$ctrl=$action;

		//权限判断
		if(!admin::check_roid('|A1,')) showmessdialog('无权操作！', 300, HTTP_REFERER, 'noajax');

		//咨询员途径报表
		$rndate=self::get_daterange();
		$stdate=$rndate['stdate'];
		$endate=$rndate['endate'];
		//$sedate=$stdate.' 至 '.$endate;
		
		$arr_yytj = $this->db->select("lydate >= '$stdate' and lydate <= '$endate'", 'yytj', '', 'yytj desc', 'yytj');
		array_unshift($arr_yytj,array('yytj'=>'咨询员'));
		array_push($arr_yytj,array('yytj'=>'合计'));
		
		//表头设置
		$arr_thead=array();
		
		foreach($arr_yytj as $row){
			foreach($row as $key=>$rowb){
				//echo $key;
				//json_encode($rowb);
				$arr_thead[]=$row[$key];
			}
		}
		
		$infos=array();
		$arr=array();
		$arr_yyzxy = $this->db->select("lydate >= '$stdate' and lydate <= '$endate'", 'yyzxy', '', 'yyzxy desc', 'yyzxy');
		$arr_yyzxy[]=array('yyzxy'=>'合计');
		
		foreach($arr_yyzxy as $row){
			$arr='';
			foreach($arr_yytj as $rowb){
				if($rowb['yytj']=='咨询员'){
					$arr[]=$row['yyzxy'];
				}elseif($rowb['yytj']=='合计'){
					if($row['yyzxy']=='合计'){
						$tdata=$this->db->count("lydate >= '$stdate' and lydate <= '$endate'");
					}else{
						$tdata=$this->db->count("lydate >= '$stdate' and lydate <= '$endate' and yyzxy='$row[yyzxy]'");
					}
					$arr[]=$tdata;
				}else{
					if($row['yyzxy']=='合计'){
						$tdata=$this->db->count("lydate >= '$stdate' and lydate <= '$endate' and yytj='$rowb[yytj]'");
					}else{
						$tdata=$this->db->count("lydate >= '$stdate' and lydate <= '$endate' and yyzxy='$row[yyzxy]' and yytj='$rowb[yytj]'");
					}
					$arr[]=$tdata;
				}
			}
			$infos[]=$arr;
		}

		if(isset($stdate)&&isset($endate)){
			$stdate=date('Y-m-d',$stdate);
			$endate=date('Y-m-d',$endate);
			$sedate=$stdate.' 至 '.$endate;
		}

		if($_GET['echo']=='export'){
			$filename=str_replace(' ', '', $sedate.$actioname);
			self::data_export($filename, $arr_thead, $infos);
		}
		
		include $this->admin_tpl('repo_comm');
	}
	
	public function public_zxyuan() {
		$action=__FUNCTION__;
		$actioname='咨询员报表';
		$ctrl=$action;

		//权限判断
		if(!admin::check_roid('|A2,')) showmessdialog('无权操作！', 300, HTTP_REFERER, 'noajax');

		//咨询员报表
		$rndate=self::get_daterange();
		$stdate=$rndate['stdate'];
		$endate=$rndate['endate'];
		$sedate=$stdate.' 至 '.$endate;
		
		//表头设置
		$arr_thead=explode(',','咨询员,总预约,总到院,到院率,未消费(&lt;50),消费率,业绩,占总业绩');
		
		$infos=array();
		$arr=array();
		$arr_yyzxy = $this->db->select("(yydate >= '$stdate' and yydate <= '$endate') or (lydate >= '$stdate' and lydate <= '$endate')", 'yyzxy', '', 'yyzxy desc', 'yyzxy');
		$arr_yyzxy[]=array('yyzxy'=>'合计');
		
		$zyy='';
		$zdy='';
		$wxf='';
		$zyj='';
		
		$hjyj=$this->db->sum('sjxf', "lydate >= '$stdate' and lydate <= '$endate'");
		
		foreach($arr_yyzxy as $row){
			$arr='';
			$where=" and yyzxy='$row[yyzxy]'";
			$where=$row['yyzxy']=='合计' ? '' : $where;
			
			foreach($arr_thead as $rowb){
				if($rowb=='咨询员'){
					$arr[]=$row['yyzxy'];
				}
				
				if($rowb=='总预约'){
					$zyy=$this->db->count("yydate >= '$stdate' and yydate <= '$endate'".$where);
					$arr[]=$zyy;
				}
				
				if($rowb=='总到院'){
					$zdy=$this->db->count("lydate >= '$stdate' and lydate <= '$endate'".$where);
					$arr[]=$zdy;
				}
				
				if($rowb=='到院率'){
					if(!$zyy){
						$arr[]='0.00%';
					}else{
						$arr[]=sprintf('%.2f', $zdy/$zyy*100).'%';
					}
				}
				
				if($rowb=='未消费(&lt;50)'){
					$wxf=$this->db->count("lydate >= '$stdate' and lydate <= '$endate' and sjxf<50".$where);
					$arr[]=$wxf;
				}
				
				if($rowb=='消费率'){
					if(!$zdy){
						$arr[]='0.00%';
					}else{
						$arr[]=sprintf('%.2f', ($zdy-$wxf)/$zdy*100).'%';
					}
				}
				
				if($rowb=='业绩'){
					$zyj=$this->db->sum('sjxf', "lydate >= '$stdate' and lydate <= '$endate'".$where);
					$arr[]=self::get_capital($zyj);
				}
				
				if($rowb=='占总业绩'){
					if(!$hjyj){
						$arr[]='0.00%';
					}else{
						$arr[]=sprintf('%.2f', $zyj/$hjyj*100).'%';
					}
				}
			}
			$infos[]=$arr;
		}

		if(isset($stdate)&&isset($endate)){
			$stdate=date('Y-m-d',$stdate);
			$endate=date('Y-m-d',$endate);
			$sedate=$stdate.' 至 '.$endate;
		}

		if($_GET['echo']=='export'){
			$filename=str_replace(' ', '', $sedate.$actioname);
			self::data_export($filename, $arr_thead, $infos);
		}

		include $this->admin_tpl('repo_comm');
	}
	
	public function public_tjing() {
		$action=__FUNCTION__;
		$actioname='咨询途径报表';
		$ctrl=$action;

		//权限判断
		if(!admin::check_roid('|A3,')) showmessdialog('无权操作！', 300, HTTP_REFERER, 'noajax');

		//咨询途径报表
		$rndate=self::get_daterange();
		$stdate=$rndate['stdate'];
		$endate=$rndate['endate'];
		$sedate=$stdate.' 至 '.$endate;
		
		//表头设置
		$arr_thead=explode(',','途径,说明,总预约,总到院,到院率,未消费(&lt;50),消费率,业绩,占总业绩');
		
		$infos=array();
		$arr=array();
		$arr_yytj = $this->db->select("(yydate >= '$stdate' and yydate <= '$endate') or (lydate >= '$stdate' and lydate <= '$endate')", 'yytj', '', 'yytj desc', 'yytj');
		$arr_yytj[]=array('yytj'=>'合计');
		
		$zyy='';
		$zdy='';
		$wxf='';
		$zyj='';
		
		$hjyj=$this->db->sum('sjxf', "lydate >= '$stdate' and lydate <= '$endate'");
		
		foreach($arr_yytj as $row){
			$arr='';
			$where=" and yytj='$row[yytj]'";
			$where=$row['yytj']=='合计' ? '' : $where;
			
			foreach($arr_thead as $rowb){
				if($rowb=='途径'){
					$arr[]=$row['yytj'];
				}
				
				if($rowb=='说明'){
					$exp=$this->yytj_db->get_one(array('cname'=>$row['yytj']));
					$arr[]=$exp['explains'];
				}
				
				if($rowb=='总预约'){
					$zyy=$this->db->count("yydate >= '$stdate' and yydate <= '$endate'".$where);
					$arr[]=$zyy;
				}
				
				if($rowb=='总到院'){
					$zdy=$this->db->count("lydate >= '$stdate' and lydate <= '$endate'".$where);
					$arr[]=$zdy;
				}
				
				if($rowb=='到院率'){
					if(!$zyy){
						$arr[]='0.00%';
					}else{
						$arr[]=sprintf('%.2f', $zdy/$zyy*100).'%';
					}
				}
				
				if($rowb=='未消费(&lt;50)'){
					$wxf=$this->db->count("lydate >= '$stdate' and lydate <= '$endate' and sjxf<50".$where);
					$arr[]=$wxf;
				}
				
				if($rowb=='消费率'){
					if(!$zdy){
						$arr[]='0.00%';
					}else{
						$arr[]=sprintf('%.2f', ($zdy-$wxf)/$zdy*100).'%';
					}
				}
				
				if($rowb=='业绩'){
					$zyj=$this->db->sum('sjxf', "lydate >= '$stdate' and lydate <= '$endate'".$where);
					$arr[]=self::get_capital($zyj);
				}
				
				if($rowb=='占总业绩'){
					if(!$hjyj){
						$arr[]='0.00%';
					}else{
						$arr[]=sprintf('%.2f', $zyj/$hjyj*100).'%';
					}
				}
			}
			$infos[]=$arr;
		}

		if(isset($stdate)&&isset($endate)){
			$stdate=date('Y-m-d',$stdate);
			$endate=date('Y-m-d',$endate);
			$sedate=$stdate.' 至 '.$endate;
		}

		if($_GET['echo']=='export'){
			$filename=str_replace(' ', '', $sedate.$actioname);
			self::data_export($filename, $arr_thead, $infos);
		}
		
		include $this->admin_tpl('repo_comm');
	}
	
	public function public_bzhong() {
		$action=__FUNCTION__;
		$actioname='病种统计报表';
		$ctrl=$action;

		//权限判断
		if(!admin::check_roid('|A4,')) showmessdialog('无权操作！', 300, HTTP_REFERER, 'noajax');

		$depart=trim($_GET['depart']);
		$depart=self::get_vdepart($depart);
		
		$depart_list = self::get_depart_list();
		
		$comingsoon='<div class="alert alert-info">模块正在开发中，敬请期待！…</div>';
		
		//视图
		include $this->admin_tpl('repo_comm');
	}
	
	public function public_zzbi() {
		$action=__FUNCTION__;
		$actioname='增长比报表';
		$ctrl=$action;
		
		//权限判断
		if(!admin::check_roid('|A6,')) showmessdialog('无权操作！', 300, HTTP_REFERER, 'noajax');

		$depart=trim($_GET['depart']);
		$depart=self::get_vdepart($depart);
		
		$depart_list = self::get_depart_list();

		$comingsoon='<div class="alert alert-info">模块正在开发中，敬请期待！…</div>';
		
		//视图
		include $this->admin_tpl('repo_comm');
	}

	private function get_depart_list() {
		$dplist = $this->yytj_db->select('', 'explains', '', 'explains desc', 'explains');
		//array_splice($dplist,0,0,array(array('explains'=>'全部')));
		array_unshift($dplist,array('explains'=>'全部'));
		array_push($dplist,array('explains'=>'未分类'));
		return $dplist;
	}

	private function get_vdepart($depart='') {
		//部门分组COOKIE设置判断
		if($depart==''){
			$depart=param::get_cookie('vdepart_data');
		}else{
			param::set_cookie('vdepart_data',$depart,(SYS_TIME+86400*30));
		}
		
		if($depart=='')
		$depart='全部';

		return $depart;
	}

	/**
	 * 获取日期范围 按月份
	 */
	private function get_daterange(){
		$param = array();
		$rndate = array();
		// $param = $_POST['p'];
		$param = $_GET['p'];
		$param_fields = array('stdate', 'endate', 'keyword');
		if(is_array($param)){
			foreach ($param as $k=>$value) {
				$info[$k]=trim($value);
				if (!in_array($k, $param_fields)){
					unset($param[$k]);
				}
			}

			if($param['stdate']!=''&&$param['endate']!=''){
				//$rndate=date('Y-m',strtotime($param['stdate']));
				$rndate['stdate']=strtotime($param['stdate']);
				$rndate['endate']=strtotime($param['endate']);
			}
		}
		if(!$rndate||$rndate['stdate']>SYS_TIME){
			$smonth=date('Y-m',SYS_TIME);
			$stdate=strtotime($smonth.'-1');
			$endate=strtotime(date('Y-m-t',$stdate));
			$rndate['stdate']=$stdate;
			$rndate['endate']=$endate;
		}
		return $rndate;
	}

	private function get_capital($val) {
		if(admin::check_roid('|82,')){
			return $val;
		}else{
			return '****';
		}
	}

	private function data_export($filename, $arr_thead, $infos){
		$csv_data = implode(',',$arr_thead)."\n";
		ob_start();
		echo $csv_data;
		foreach($infos as $k=>$info) {
			$csv_data = '';
			$csv_data .= implode(',',$info)."\n";
			echo $csv_data;
		}
		export_csv($filename);
	}

}
?>