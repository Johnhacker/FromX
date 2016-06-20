<?php defined('IN_ADMIN') or exit('No permission resources.'); //模板 ?>
<div class="navbar navbar-inverse mb0" role="navigation">
	<!-- <div class="container"> -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
			<a class="navbar-brand" href="./?m=admin&c=main"><i class="fa fa-leaf"></i> <?php echo self::$sitename ?></a>
		</div>
		<div class="collapse navbar-collapse">
			<ul class="nav navbar-nav" id="cx_nav">
				<!-- <li class="active"><a href="./">系统主页</a></li> -->
				<?php
				$array=admin::admin_menu(0);
				foreach($array as $_value){
					$dclass='';
					if(str_replace('edlg','main',ROUTE_C)==$_value['c']){		
						$dclass=' active';
					}
					echo '<li class="cs_nav-li'.$dclass.'"><a href="javascript:void(0)">'.$_value['name'].'</a></li>';   	
				}
				?>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li class="divider-vertical"></li>
				<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown"><?php echo self::$username ?><strong class="caret"></strong></a>
					<ul class="dropdown-menu">
						<li><a class="ajax" href="./?m=admin&c=webctrl&a=public_logout">退出管理</a></li>
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
		<?php echo admin::submenu(1) ?>
		<!-- <li><a href="./">追访</a></li> -->
	</ol>
	<ol class="breadcrumb<?php if(ROUTE_C!='dyua') echo ' disno' ?>">
		<li><i class="fa fa-caret-right"></i> 到院数据：</li>
		<?php echo admin::submenu(2) ?>
		<!-- <li><i class="fa fa-caret-right"></i> 后期消费到院：</li>
		<li><a href="./">本月</a></li>
		<li><a href="./">上个月</a></li>
		<li><a href="./">录入</a></li> -->
	</ol>
	<ol class="breadcrumb<?php if(ROUTE_C!='comp') echo ' disno' ?>">
		<li><i class="fa fa-caret-right"></i> 综合数据：</li>
		<li>推广费用数据</li>
		<?php echo admin::submenu(3) ?>
		<li>咨询员数据</li>
		<!--<li><a href="./">本月</a></li>
		<li><a href="./">上个月</a></li>
		<li><a href="./">录入</a></li>-->
	</ol>
	<ol class="breadcrumb<?php if(ROUTE_C!='anls') echo ' disno' ?>">
		<li><i class="fa fa-caret-right"></i> 统计分析：</li>
		<?php echo admin::submenu(4) ?>
	</ol>
	<ol class="breadcrumb<?php if(ROUTE_C!='repo') echo ' disno' ?>">
		<li><i class="fa fa-caret-right"></i> 统计报表：</li>
		<?php echo admin::submenu(5) ?>
		<!--<li><a href="./?m=admin&c=repo&a=public_hqxfei">后期消费到院数据报表</a></li>-->
	</ol>
	<ol class="breadcrumb<?php if(ROUTE_C!='line') echo ' disno' ?>">
		<li><i class="fa fa-caret-right"></i> 排班表：</li>
		<?php echo admin::submenu(6) ?>
	</ol>
	<ol class="breadcrumb<?php if(ROUTE_C!='user') echo ' disno' ?>">
		<li><i class="fa fa-caret-right"></i> 用户管理：</li>
		<?php echo admin::submenu(7) ?>
	</ol>
	<ol class="breadcrumb<?php if(ROUTE_C!='sysm') echo ' disno' ?>">
		<li><i class="fa fa-caret-right"></i> 系统管理：</li>
		<?php echo admin::submenu(8) ?>
		<!-- <li><a href="#">数据安全监控</a></li> -->
	</ol>
</div>