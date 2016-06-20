<?php 
defined('IN_SYS') or exit('No permission resources.');

//获取指定日期范围
function getdaterange($str){
	$rdate=array();
	//本月
	if($str=='cmonth'){
		$stdate=strtotime(date('Y',SYS_TIME).'-'.date('m',SYS_TIME).'-1');
		$endate=strtotime(date('Y-m-t',$stdate));
	}
	
	//上月
	if($str=='pmonth'){
		$stdate=strtotime('-1 month',strtotime(date('Y',SYS_TIME).'-'.date('m',SYS_TIME).'-1'));
		$endate=strtotime(date('Y-m-t',$stdate));
	}
	
	//本周
	if($str=='cweek'){
		$stdate=strtotime('-1 week Monday',SYS_TIME);
		$endate=strtotime('+0 week Sunday',SYS_TIME);
	}
	
	//昨天
	if($str=='teday'){
		$stdate=strtotime(date('Y-m-d',strtotime('-1 day',SYS_TIME)));
		$endate=$stdate;
	}
	
	//今天
	if($str=='today'){
		$stdate=strtotime(date('Y-m-d',SYS_TIME));
		$endate=$stdate;
	}
	
	//明天
	if($str=='tomor'){
		$stdate=strtotime(date('Y-m-d',strtotime('+1 day',SYS_TIME)));
		$endate=$stdate;
	}
	$rdate['stdate']=$stdate;
	$rdate['endate']=$endate;
	return $rdate;
}
?>