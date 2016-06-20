<?php
defined('IN_SYS') or exit('No permission resources.');
pc_base::load_app_class('admin','admin',0);
pc_base::load_app_func('comm');

class anls extends admin {
	public function __construct() {
		parent::__construct();
		
		$this->db = pc_base::load_model('yuyue_model');
		$this->yytj_db = pc_base::load_model('yytj_model');
		$this->diqu_db = pc_base::load_model('diqu_model');
		$this->wlxf_db_dt = pc_base::load_model('wlxf_data_model');
	}
	
	public function init () {
		self::public_dyuan();
	}
	
	public function public_dyuan() {
		$action=__FUNCTION__;
		$ctrl=$action;

		//权限判断
		if(!admin::check_roid('|41,')) showmessdialog('无权操作！', 300, HTTP_REFERER, 'noajax');
		
		$depart=trim($_GET['depart']);
		$depart=self::get_vdepart($depart);
		if($depart!='全部') $chart_ti_depart='『'.$depart.'』';
		
		$depart_list = self::get_depart_list();
		
		//$sdata='YYDY';
		$rndate=self::get_daterange();
		$rndate=date('Y-m',$rndate['stdate']); //???图表的局限只有限制在某个月份 后期修复
		
		$chart_type='line';
		$chart_height='360px';
		$chart_colors="'#2F7ED8', '#8BBC21', '#0D233A', '#910000', '#1AADCE', '#492970', '#F28F43', '#77A1E5', '#C42525', '#A6C96A'";
		$chart_ti=$rndate.'月份'.$chart_ti_depart.'总到院数据统计图';
		$chart_dw='人';
		$chart_yti='人数';
		$chart_ytick=2;

		$chart_xdata='';
		
		$chart_ssets=array(
		array('总到院','true'),
		array('总预约','false')
		);
		
		$chart_sdatas=array();
		$chart_stips=array();

		for ($i=1; $i<=date('t',strtotime($rndate.'-1')); $i++){
			$chart_xdata=$chart_xdata."'{$i}号',";
			
			$arr_condit=array('lydate'=>strtotime($rndate.'-'.$i));
			if($depart!='全部')
			$arr_condit['bmfz']=$depart;
			
			$tdata=$this->db->count($arr_condit);
			$chart_sdatas['ZDY']=$chart_sdatas['ZDY'].$tdata.',';
			$chart_stips['ZDY']=$chart_stips['ZDY']."'到院{$tdata}{$chart_dw}',";
			
			$arr_condit=array('yydate'=>strtotime($rndate.'-'.$i));
			if($depart!='全部')
			$arr_condit['bmfz']=$depart;
			
			$tdata=$this->db->count($arr_condit);
			$chart_sdatas['ZYY']=$chart_sdatas['ZYY'].$tdata.',';
			$chart_stips['ZYY']=$chart_stips['ZYY']."'预约{$tdata}{$chart_dw}',";
			
		}
		
		
		//合计计算
		$ispast=false;
		$stdate=strtotime($rndate.'-1');
		$nowymd=date('Y-m-d',SYS_TIME);
		if( strtotime(date('Y-m-t',$stdate))<strtotime($nowymd) || date('d',SYS_TIME)==1){
			$ispast=true;
			$endate=strtotime(date('Y-m-t',$stdate));
			$ndays=intval(date('t',$stdate));
			$shownday='';
		}else{
			$endate=strtotime(date('Y-m-d',strtotime('-1 day',SYS_TIME)));
			$ndays=intval(date('d',strtotime('-1 day',SYS_TIME)));
			$shownday='<font style="font-size:12px"> (截止'.date('Y-m-d',strtotime('-1 day',SYS_TIME)).'日) </font>';
		}
		$sedate=date('Y-m-d',$stdate).' 至 '.date('Y-m-d',$endate);
		
		$str_sql="lydate >= '$stdate' and lydate <= '$endate'";
		if($depart!='全部')
		$str_sql=$str_sql." and bmfz='$depart'";
		
		$tdata=$this->db->count($str_sql);
		$chart_info='合计：'.$rndate.'月份'.$shownday.' 一共到院 <span class="label label-primary">'.$tdata.'</span> 个，日均到院 <span class="label label-primary">'.sprintf('%.2f', $tdata/$ndays).'</span> 个。<!--其中预约到院 <span class="label label-primary">'.$tdata.'</span> 个，日均预约到院 <span class="label label-primary">6.50</span> 个；-->';
		
		//视图
		include $this->admin_tpl('anls_chart');
	}
	
	public function public_yydh() {
		$action=__FUNCTION__;
		$ctrl=$action;

		//权限判断
		if(!admin::check_roid('|42,')) showmessdialog('无权操作！', 300, HTTP_REFERER, 'noajax');
		
		$depart=trim($_GET['depart']);
		$depart=self::get_vdepart($depart);
		if($depart!='全部') $chart_ti_depart='『'.$depart.'』';
		
		$depart_list = self::get_depart_list();
		
		//$sdata='YYDY';
		$rndate=self::get_daterange();
		$rndate=date('Y-m',$rndate['stdate']); //???图表的局限只有限制在某个月份 后期修复
		
		$chart_type='line';
		$chart_height='360px';
		$chart_colors="'#8BBC21', '#2F7ED8', '#0D233A', '#910000', '#1AADCE', '#492970', '#F28F43', '#77A1E5', '#C42525', '#A6C96A'";
		$chart_ti=$rndate.'月份'.$chart_ti_depart.'总预约数据统计图';
		$chart_dw='人';
		$chart_yti='人数';
		$chart_ytick='null';

		$chart_xdata='';
		
		$chart_ssets=array(
		array('总预约','true'),
		array('总对话','false'),
		);
		
		$chart_sdatas=array();
		$chart_stips=array();

		for ($i=1; $i<=date('t',strtotime($rndate.'-1')); $i++){
			$chart_xdata=$chart_xdata."'".$i."号',";

			$arr_condit=array('yydate'=>strtotime($rndate.'-'.$i));
			if($depart!='全部')
			$arr_condit['bmfz']=$depart;
			
			$tdata=$this->db->count($arr_condit);
			$chart_sdatas['ZYY']=$chart_sdatas['ZYY'].$tdata.',';
			$chart_stips['ZYY']=$chart_stips['ZYY']."'预约{$tdata}{$chart_dw}',";
			
			/*$tdata=self::get_rcnum($sdata,$rndate.'-'.$i,'ZDH');
			$chart_sdatas['ZDH']=$chart_sdatas['ZDH'].$tdata.',';
			$chart_stips['ZDH']=$chart_stips['ZDH']."'对话".$tdata."条',";*/
			
		}
		
		//合计计算
		$ispast=false;
		$stdate=strtotime($rndate.'-1');
		$nowymd=date('Y-m-d',SYS_TIME);
		if( strtotime(date('Y-m-t',$stdate))<strtotime($nowymd) || date('d',SYS_TIME)==1){
			$ispast=true;
			$endate=strtotime(date('Y-m-t',$stdate));
			$ndays=intval(date('t',$stdate));
			$shownday='';
		}else{
			$endate=strtotime(date('Y-m-d',strtotime('-1 day',SYS_TIME)));
			$ndays=intval(date('d',strtotime('-1 day',SYS_TIME)));
			$shownday='<font style="font-size:12px"> (截止'.date('Y-m-d',strtotime('-1 day',SYS_TIME)).'日) </font>';
		}
		$sedate=date('Y-m-d',$stdate).' 至 '.date('Y-m-d',$endate);
		
		$str_sql="yydate >= '$stdate' and yydate <= '$endate'";
		if($depart!='全部')
		$str_sql=$str_sql." and bmfz='$depart'";
		
		$tdata=$this->db->count($str_sql);
		$chart_info='合计：'.$rndate.'月份'.$shownday.' 一共预约 <span class="label label-primary">'.$tdata.'</span> 个，日均预约 <span class="label label-primary">'.sprintf('%.2f', $tdata/$ndays).'</span> 个。';
		
		//视图
		include $this->admin_tpl('anls_chart');
	}
	
	public function public_wlxf() {
		$action=__FUNCTION__;
		$ctrl=$action;

		//权限判断
		if(!admin::check_roid('|43,')) showmessdialog('无权操作！', 300, HTTP_REFERER, 'noajax');
		
		//$sdata='YYDY';
		$rndate=self::get_daterange();
		$rndate=date('Y-m',$rndate['stdate']); //???图表的局限只有限制在某个月份 后期修复
		$rcdate='';
		
		$chart_type='line';
		$chart_height='360px';
		$chart_colors="'#2F7ED8', '#8BBC21', '#0D233A', '#910000', '#1AADCE', '#492970', '#F28F43', '#77A1E5', '#C42525', '#A6C96A'";
		$chart_ti=$rndate.'月份网络推广费用数据统计图';
		$chart_dw='元';
		$chart_yti='金额';
		$chart_ytick='null';

		$chart_xdata='';
		
		$chart_ssets=array(
		array('网络推广费用','true'),
		array('总对话','false'),
		);
		
		$chart_sdatas=array();
		$chart_stips=array();

		for ($i=1; $i<=date('t',strtotime($rndate.'-1')); $i++){
			$chart_xdata=$chart_xdata."'".$i."号',";
			$rcdate=strtotime($rndate.'-'.$i);
			$tdata=$this->wlxf_db_dt->sum('tgcost', "rcdate='$rcdate'");
			$tdata=$tdata=='' ? 0.00 : $tdata;
			$chart_sdatas['ZXF']=$chart_sdatas['ZXF'].$tdata.',';
			$chart_stips['ZXF']=$chart_stips['ZXF']."'费用{$tdata}{$chart_dw}',";
		}
		
		//合计计算
		$ispast=false;
		$stdate=strtotime($rndate.'-1');
		$nowymd=date('Y-m-d',SYS_TIME);
		if( strtotime(date('Y-m-t',$stdate))<strtotime($nowymd) || date('d',SYS_TIME)==1){
			$ispast=true;
			$endate=strtotime(date('Y-m-t',$stdate));
			$ndays=intval(date('t',$stdate));
			$shownday='';
		}else{
			$endate=strtotime(date('Y-m-d',strtotime('-1 day',SYS_TIME)));
			$ndays=intval(date('d',strtotime('-1 day',SYS_TIME)));
			$shownday='<font style="font-size:12px"> (截止'.date('Y-m-d',strtotime('-1 day',SYS_TIME)).'日) </font>';
		}
		$sedate=date('Y-m-d',$stdate).' 至 '.date('Y-m-d',$endate);
		
		$tdata=$this->wlxf_db_dt->sum('tgcost', "rcdate >= '$stdate' and rcdate <= '$endate'");
		$chart_info='合计：'.$rndate.'月份'.$shownday.' 一共费用 <span class="label label-primary">'.$tdata.'</span> 元，日均费用 <span class="label label-primary">'.sprintf('%.2f', $tdata/$ndays).'</span> 元。';
		
		//视图
		include $this->admin_tpl('anls_chart');
	}
	
	public function public_sduan() {
		$action=__FUNCTION__;
		$ctrl=$action;

		//权限判断
		if(!admin::check_roid('|45,')) showmessdialog('无权操作！', 300, HTTP_REFERER, 'noajax');

		$depart=trim($_GET['depart']);
		$depart=self::get_vdepart($depart);

		$str_sql='';
		if($depart!='全部'){
			$chart_ti_depart='『'.$depart.'』';
			$str_sql=$str_sql."bmfz='$depart' and ";
		}
		
		$depart_list = self::get_depart_list();
		
		//$sdata='YYDY';
		$rndate=self::get_daterange();
		$rndate=date('Y-m',$rndate['stdate']); //???图表的局限只有限制在某个月份 后期修复
		
		$chart_type='line';
		$chart_height='360px';
		$chart_colors="'#2F7ED8', '#8BBC21', '#0D233A', '#910000', '#1AADCE', '#492970', '#F28F43', '#77A1E5', '#C42525', '#A6C96A'";
		$chart_ti=$rndate.'月份预约人数时段数据统计图';
		$chart_dw='人';
		$chart_yti='人数';
		$chart_ytick='null';

		$chart_xdata='';
		
		$chart_ssets=array(
		array('预约人数时段','true'),
		array('总对话','false'),
		);
		
		$comingsoon='<div class="alert alert-info">模块正在开发中，敬请期待！…</div>';
		
		//视图
		include $this->admin_tpl('anls_chart');
	}
	
	public function public_tjing() {
		$action=__FUNCTION__;
		$ctrl=$action;

		//权限判断
		if(!admin::check_roid('|46,')) showmessdialog('无权操作！', 300, HTTP_REFERER, 'noajax');
		
		$depart=trim($_GET['depart']);
		$depart=self::get_vdepart($depart);

		$str_sql='1=1 and ';
		if($depart!='全部'){
			$chart_ti_depart='『'.$depart.'』';
			$str_sql=$str_sql."bmfz='$depart' and ";
		}
		
		$depart_list = self::get_depart_list();
		
		$sdata=trim($_GET['s']);
		if($sdata=='') $sdata='dydata';

		$rndate=self::get_daterange();
		$rndate=date('Y-m',$rndate['stdate']); //???图表的局限只有限制在某个月份 后期修复
		
		$chart_type='pie';
		$chart_height='430px';
		//$chart_colors="'#2F7ED8', '#8BBC21', '#0D233A', '#910000', '#1AADCE', '#492970', '#F28F43', '#77A1E5', '#C42525', '#A6C96A'";
		
		$comingsoon='<div class="alert alert-info">模块正在开发中，敬请期待！…</div>';
		//视图
		include $this->admin_tpl('anls_chart');
	}
	
	public function public_bzhong() {
		$action=__FUNCTION__;
		$ctrl=$action;

		//权限判断
		if(!admin::check_roid('|47,')) showmessdialog('无权操作！', 300, HTTP_REFERER, 'noajax');
		
		$depart=trim($_GET['depart']);
		$depart=self::get_vdepart($depart);

		$str_sql='1=1 and ';
		if($depart!='全部'){
			$chart_ti_depart='『'.$depart.'』';
			$str_sql=$str_sql."bmfz='$depart' and ";
		}
		
		$depart_list = self::get_depart_list();

		$rndate=self::get_daterange();
		$rndate=date('Y-m',$rndate['stdate']); //???图表的局限只有限制在某个月份 后期修复
		
		$chart_type='column';
		$chart_height='360px';
		$chart_colors="'#2F7ED8', '#8BBC21', '#0D233A', '#910000', '#1AADCE', '#492970', '#F28F43', '#77A1E5', '#C42525', '#A6C96A'";
		$chart_ti=$rndate.'月份'.$chart_ti_depart.'到院病种数据统计图';
		$chart_dw='人';
		$chart_ytick='null';

		$chart_xdata='';
		
		$chart_ssets=array(
		array('到院病种','true'),
		array('预约病种','true'),
		);
		
		$comingsoon='<div class="alert alert-info">模块正在开发中，敬请期待！…</div>';
		//视图
		include $this->admin_tpl('anls_chart');
	}
	
	public function public_qiqu() {
		$action=__FUNCTION__;
		$ctrl=$action;

		//权限判断
		if(!admin::check_roid('|48,')) showmessdialog('无权操作！', 300, HTTP_REFERER, 'noajax');
		
		$depart=trim($_GET['depart']);
		$depart=self::get_vdepart($depart);

		$str_sql='1=1 and ';
		if($depart!='全部'){
			$chart_ti_depart='『'.$depart.'』';
			$str_sql=$str_sql."bmfz='$depart' and ";
		}
		
		$depart_list = self::get_depart_list();

		$rndate=self::get_daterange();
		$rndate=date('Y-m',$rndate['stdate']); //???图表的局限只有限制在某个月份 后期修复
		
		$chart_type='column';
		$chart_height='360px';
		$chart_colors="'#2F7ED8', '#8BBC21', '#0D233A', '#910000', '#1AADCE', '#492970', '#F28F43', '#77A1E5', '#C42525', '#A6C96A'";
		$chart_ti=$rndate.'月份'.$chart_ti_depart.'到院患者地区数据统计图';
		$chart_dw='人';
		$chart_ytick='null';

		$chart_xdata='';
		
		$chart_ssets=array(
		array('到院患者地区','true'),
		array('预约患者地区','true'),
		);
		
		$chart_sdatas=array();
		$chart_stips=array();
		
		$stdate=strtotime($rndate.'-1');
		$endate=strtotime(date('Y-m-t',$stdate));
		$sedate=date('Y-m-d',$stdate).' 至 '.date('Y-m-d',$endate);
		
		$infos = $this->diqu_db->listinfo('', 'listorder desc, id asc', 1, 100);
		array_push($infos,array('cname'=>'不详'));
		
		foreach($infos as $k=>$info) {
			
			$chart_xdata=$chart_xdata."'{$info[cname]}',";
			if($info['cname']=='不详'){
				$tdata=$this->db->count($str_sql."hzcity='' and lydate >= '$stdate' and lydate <= '$endate'");
			}else{
				$tdata=$this->db->count($str_sql."hzcity like '%$info[cname]%' and lydate >= '$stdate' and lydate <= '$endate'");
			}
			$chart_sdatas['ZDY']=$chart_sdatas['ZDY'].$tdata.',';
			$chart_stips['ZDY']=$chart_stips['ZDY']."'到院{$tdata}{$chart_dw}',";
			
			if($info['cname']=='不详'){
				$tdata=$this->db->count($str_sql."hzcity='' and yydate >= '$stdate' and yydate <= '$endate'");
			}else{
				$tdata=$this->db->count($str_sql."hzcity like '%$info[cname]%' and yydate >= '$stdate' and yydate <= '$endate'");
			}
			$chart_sdatas['ZYY']=$chart_sdatas['ZYY'].$tdata.',';
			$chart_stips['ZYY']=$chart_stips['ZYY']."'预约{$tdata}{$chart_dw}',";
		}
		
		//视图
		include $this->admin_tpl('anls_chart');
	}
	
	public function public_zxyuan() {
		$action=__FUNCTION__;
		$actioname='咨询员数据';
		$ctrl=$action;

		//权限判断
		if(!admin::check_roid('|49,')) showmessdialog('无权操作！', 300, HTTP_REFERER, 'noajax');
		
		//咨询员报表
		$rndate=self::get_daterange();
		$stdate=$rndate['stdate'];
		$endate=$rndate['endate'];
		$sedate=$stdate.' 至 '.$endate;
		
		//表头设置
		$arr_thead=explode(',','咨询员,全部对话,极佳对话,极佳对话率,总预约,预约率,总到院,到院率,未消费(&lt;50),消费率');
		
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
				
				if($rowb=='全部对话'){
					$arr[]='0';
				}
				
				if($rowb=='极佳对话'){
					$arr[]='0';
				}
				
				if($rowb=='极佳对话率'){
					$arr[]='0.00%';
				}
				
				if($rowb=='总预约'){
					$zyy=$this->db->count("yydate >= '$stdate' and yydate <= '$endate'".$where);
					$arr[]=$zyy;
				}
				
				if($rowb=='预约率'){
					$arr[]='0.00%';
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
	
	public function public_bmen() {
		$action=__FUNCTION__;

		//权限判断
		if(!admin::check_roid('|410,')) showmessdialog('无权操作！', 300, HTTP_REFERER, 'noajax');
		
		//$sdata='YYDY';
		$rndate=date('Y-m',SYS_TIME);
		
		$chart_type='line';
		$chart_height='360px';
		//$chart_colors="'#8BBC21', '#2F7ED8', '#0D233A', '#910000', '#1AADCE', '#492970', '#F28F43', '#77A1E5', '#C42525', '#A6C96A'";
		
		$chart_ti='部门分组到院数据统计图';
		if($sdata=='yydata')
		$chart_ti='部门分组预约数据统计图';
		if($sdata=='yjdata')
		$chart_ti='部门分组业绩数据统计图';
		
		$chart_dw='人';
		$chart_yti='人数';
		$chart_ytick='null';
		$chart_offdatalab=true;

		$chart_xdata='';
		
		$stdate=strtotime($rndate.'-1');
		$endate=strtotime(date('Y-m-t',$stdate));
		$stdate=strtotime('-1 month',strtotime($rndate.'-1'));
		
		//echo date('Y-m-d',$stdate).':::'.date('Y-m-t',$endate);
		
		$arr_bmfz = $this->db->select("lydate >= '$stdate' and lydate <= '$endate'", 'bmfz', '', 'bmfz desc', 'bmfz');
		array_unshift($arr_bmfz,array('bmfz'=>'全部'));
		
		$chart_ssets=array();
		
		$comingsoon='<div class="alert alert-info">模块正在开发中，敬请期待！…</div>';
		//视图
		include $this->admin_tpl('anls_chart');
	}
	
	public function public_ndzh() {
		$action=__FUNCTION__;

		//权限判断
		if(!admin::check_roid('|411,')) showmessdialog('无权操作！', 300, HTTP_REFERER, 'noajax');
		
		//$sdata='YYDY';
		$rndate=date('Y-m',SYS_TIME);
		
		$chart_type='line';
		$chart_height='360px';
		//$chart_colors="'#8BBC21', '#2F7ED8', '#0D233A', '#910000', '#1AADCE', '#492970', '#F28F43', '#77A1E5', '#C42525', '#A6C96A'";
		
		$chart_ti='年度到院数据统计图';
		if($sdata=='yydata')
		$chart_ti='年度预约数据统计图';
		if($sdata=='yjdata')
		$chart_ti='年度业绩数据统计图';
		
		$chart_dw='人';
		$chart_yti='人数';
		$chart_ytick='null';
		$chart_offdatalab=true;

		$chart_xdata='';
		
		$stdate=strtotime($rndate.'-1');
		$endate=strtotime(date('Y-m-t',$stdate));
		$stdate=strtotime('-1 month',strtotime($rndate.'-1'));
		
		//echo date('Y-m-d',$stdate).':::'.date('Y-m-t',$endate);
		
		$arr_yyzxy = $this->db->select("lydate >= '$stdate' and lydate <= '$endate'", 'yyzxy', '', 'yyzxy desc', 'yyzxy');
		array_unshift($arr_yyzxy,array('yyzxy'=>'全部'));
		
		$chart_ssets=array();

		$comingsoon='<div class="alert alert-info">模块正在开发中，敬请期待！…</div>';
		//视图
		include $this->admin_tpl('anls_chart');
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