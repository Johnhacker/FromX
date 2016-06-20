<?php defined('IN_ADMIN') or exit('No permission resources.'); //模板 ?>
<div class="navbar navbar-inverse mb0" role="navigation">
	<!-- <div class="container"> -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
			<a class="navbar-brand" href="#"><i class="fa fa-leaf"></i> 拉萨恒大医院预约管理系统</a>
		</div>
		<div class="collapse navbar-collapse">
			<ul class="nav navbar-nav" id="cx_nav">
				<!-- <li class="active"><a href="./">系统主页</a></li> -->
				<?php
				/*$array=admin::admin_menu(0);
				foreach($array as $_value){
					$dclass='';
					if($_value['id']==10){		
						$dclass=' cur_month';
					}
					echo '<li class="top_menu'.$dclass.'"><a href="javascript:void(0)">'.$_value['name'].'</a></li>';   	
				}*/
				?>
				<li<?php if(ROUTE_C=='main'||ROUTE_C=='edlg') echo ' class="active"' ?>><a href="javascript:void(0)">预约数据</a></li>
				<li<?php if(ROUTE_C=='dyua') echo ' class="active"' ?>><a href="javascript:void(0)">到院数据</a></li>
				<li<?php if(ROUTE_C=='comp') echo ' class="active"' ?>><a href="javascript:void(0)">综合数据</a></li>
				<li<?php if(ROUTE_C=='anls') echo ' class="active"' ?>><a href="javascript:void(0)">统计分析</a></li>
				<li<?php if(ROUTE_C=='repo') echo ' class="active"' ?>><a href="javascript:void(0)">统计报表</a></li>
				<li<?php if(ROUTE_C=='line') echo ' class="active"' ?>><a href="javascript:void(0)">排班表</a></li>
				<li<?php if(ROUTE_C=='user') echo ' class="active"' ?>><a href="javascript:void(0)">用户管理</a></li>
				<li<?php if(ROUTE_C=='sysm') echo ' class="active"' ?>><a href="javascript:void(0)">系统设置</a></li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li class="divider-vertical"></li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle">管理员<strong class="caret"></strong></a>
					<!--<a href="#" class="dropdown-toggle" data-toggle="dropdown">管理员<strong class="caret"></strong></a>-->
					<ul class="dropdown-menu">
						<li> <a class="ajax" href="./?action=logout">退出管理</a> </li>
					</ul>
				</li>
			</ul>
		</div>
		<!--/.nav-collapse -->
	<!-- </div> -->
</div>
<div class="navbar-sub cs_nav-sub" id="cs_nav-sub">
	<ol class="breadcrumb<?php if(ROUTE_C!='main'&&ROUTE_C!='edlg') echo ' disno' ?>">
		<li><i class="fa fa-caret-right"></i> 预约数据：</li>
		<li><a href="./?m=admin&c=main&a=public_list">全部</a></li>
		<li><a href="./?m=admin&c=main&a=public_list&ctrl=cmonth">本月</a></li>
		<li><a href="./?m=admin&c=main&a=public_list&ctrl=pmonth">上个月</a></li>
		<li><a href="./?m=admin&c=main&a=public_list&ctrl=cweek">本周</a></li>
		<li><a href="./?m=admin&c=main&a=public_list&ctrl=teday">昨天</a></li>
		<li><a href="./?m=admin&c=main&a=public_list&ctrl=today">今天</a></li>
		<li><a href="./?m=admin&c=main&a=public_list&ctrl=prtomor">预计明天</a></li>
		<li><a href="./?m=admin&c=main&a=public_list&ctrl=prtoday">预计今天</a></li>
		<li><a href="./?m=admin&c=main&a=public_list&ctrl=prnear">预计近期</a></li>
		<li><a href="./?m=admin&c=main&a=public_list&ctrl=prnonat">预计不到院</a></li>
		
		<li><a href="./?m=admin&c=edlg&a=public_list">历史编辑</a></li>
		<li><a href="./?m=admin&c=main&a=public_add">录入预约数据</a></li>
		<!-- <li><a href="./">追访</a></li> -->
	</ol>
	<ol class="breadcrumb<?php if(ROUTE_C!='dyua') echo ' disno' ?>">
		<li><i class="fa fa-caret-right"></i> 到院数据：</li>
		<li><a href="./?m=admin&c=dyua&a=public_list&ctrl=cmonth">本月</a></li>
		<li><a href="./?m=admin&c=dyua&a=public_list&ctrl=pmonth">上个月</a></li>
		<li><a href="./?m=admin&c=dyua&a=public_list&ctrl=cweek">本周</a></li>
		<li><a href="./?m=admin&c=dyua&a=public_list&ctrl=teday">昨天</a></li>
		<li><a href="./?m=admin&c=dyua&a=public_list&ctrl=today">今天</a></li>
		<li><a href="./">录入到院数据</a></li>
		<!-- <li><i class="fa fa-caret-right"></i> 后期消费到院：</li>
		<li><a href="./">本月</a></li>
		<li><a href="./">上个月</a></li>
		<li><a href="./">录入</a></li> -->
	</ol>
	<ol class="breadcrumb<?php if(ROUTE_C!='comp') echo ' disno' ?>">
		<li><i class="fa fa-caret-right"></i> 综合数据：</li>
		<li>推广费用数据</li>
		<li><a href="./?m=admin&c=comp&a=public_wlxf_list&ctrl=cmonth">本月</a></li>
		<li><a href="./?m=admin&c=comp&a=public_wlxf_list&ctrl=pmonth">上个月</a></li>
		<li><a href="./?m=admin&c=comp&a=public_wlxf_add">录入</a></li>
		<li>咨询员数据</li>
		<!--<li><a href="./">本月</a></li>
		<li><a href="./">上个月</a></li>
		<li><a href="./">录入</a></li>-->
	</ol>
	<ol class="breadcrumb<?php if(ROUTE_C!='anls') echo ' disno' ?>">
		<li><i class="fa fa-caret-right"></i> 统计分析：</li>
		<li><a href="./?m=admin&c=anls&a=public_dyuan">到院统计</a></li>
		<li><a href="./?m=admin&c=anls&a=public_yydh">预约＆有效对话</a></li>
		<li><a href="./?m=admin&c=anls&a=public_wlxf">推广费用</a></li>
		<li><a href="./?m=admin&c=anls&a=public_sduan">时段统计</a></li>
		<li><a href="./?m=admin&c=anls&a=public_tjing">途径统计</a></li>
		<li><a href="./?m=admin&c=anls&a=public_bzhong">病种统计</a></li>
		<li><a href="./?m=admin&c=anls&a=public_qiqu">地区分布</a></li>
		<li><a href="./?m=admin&c=anls&a=public_zxyuan">咨询员数据</a></li>
		<li><a href="./?m=admin&c=anls&a=public_bmen">部门数据</a></li>
		<li><a href="./?m=admin&c=anls&a=public_ndzh">年度综合数据</a></li>
	</ol>
	<ol class="breadcrumb<?php if(ROUTE_C!='repo') echo ' disno' ?>">
		<li><i class="fa fa-caret-right"></i> 统计报表：</li>
		<li><a href="./?m=admin&c=repo&a=public_zxytj">咨询员途径报表</a></li>
		<li><a href="./?m=admin&c=repo&a=public_zxyuan">咨询员报表</a></li>
		<li><a href="./?m=admin&c=repo&a=public_tjing">咨询途径报表</a></li>
		<li><a href="./?m=admin&c=repo&a=public_bzhong">病种统计报表</a></li>
		<li><a href="./?m=admin&c=repo&a=public_dyuan">到院数据报表</a></li>
		<li><a href="./?m=admin&c=repo&a=public_zzbi">增长比报表</a></li>
		<!--<li><a href="./?m=admin&c=repo&a=public_hqxfei">后期消费到院数据报表</a></li>-->
	</ol>
	<ol class="breadcrumb<?php if(ROUTE_C!='line') echo ' disno' ?>">
		<li><i class="fa fa-caret-right"></i> 排班表：</li>
		<li><a href="./?m=admin&c=line&a=public_list&ctrl=1">咨询排班表</a></li>
		<li><a href="./?m=admin&c=line&a=public_list&ctrl=2">导医排班表</a></li>
		<li><a href="./?m=admin&c=line&a=public_list&ctrl=3">竞价排班表</a></li>
		<li><a href="./?m=admin&c=line&a=public_pbset">录入/修改</a></li>
	</ol>
	<ol class="breadcrumb<?php if(ROUTE_C!='user') echo ' disno' ?>">
		<li><i class="fa fa-caret-right"></i> 用户管理：</li>
		<li><a href="./?m=admin&c=user&a=public_changepwd">修改密码</a></li>
		<li><a href="./?m=admin&c=user&a=public_userlist">用户列表</a></li>
		<li><a href="./?m=admin&c=user&a=public_adduser">添加用户</a></li>
	</ol>
	<ol class="breadcrumb<?php if(ROUTE_C!='sysm') echo ' disno' ?>">
		<li><i class="fa fa-caret-right"></i> 系统管理：</li>
		<li><a href="./?m=admin&c=sysm&a=public_loginlogs">用户登录日志</a></li>
		<li><a href="./?m=admin&c=sysm&a=public_siteset">常量设置</a></li>
		<li><a href="./?m=admin&c=sysm&a=public_bmfzset">部门设置</a></li>
		<li><a href="./?m=admin&c=sysm&a=public_emailset">邮箱设置</a></li>
		<li><a href="./?m=admin&c=sysm&a=public_pbqkset">排班设置</a></li>
		<li><a href="./?m=admin&c=sysm&a=public_zjysset">专 家</a></li>
		<li><a href="./?m=admin&c=sysm&a=public_zxzyset">咨询员</a></li>
		<li><a href="./?m=admin&c=sysm&a=public_yytjset">咨询途径</a></li>
		<li><a href="./?m=admin&c=sysm&a=public_jzqkset">就诊情况</a></li>
		<li><a href="./?m=admin&c=sysm&a=public_lyfsset">来院方式</a></li>
		<li><a href="./?m=admin&c=sysm&a=public_diquset">地区校验</a></li>
		<li><a href="./?m=admin&c=sysm&a=public_bzksset">病种校验</a></li>
		<li><a href="./?m=admin&c=sysm&a=public_wlxfset">推广消费</a></li>
		<!-- <li><a href="#">数据安全监控</a></li> -->
	</ol>
</div>