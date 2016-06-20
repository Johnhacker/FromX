<?php
defined('IN_ADMIN') or exit('No permission resources.'); //模板
$soblock='000-003';
include PC_PATH.'modules'.DIRECTORY_SEPARATOR.'admin'.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'header.tpl.php';
?>
<div id="mainpage">

	<?php
	include PC_PATH.'modules'.DIRECTORY_SEPARATOR.'admin'.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'navier.tpl.php';
	?>
	<div class="cs_container"><!-- container -->
		<div class="cs_navbar col-sm-12">
			<h4 class="pull-left v1"><span class="label label-primary">统计分析</span></h4>
			<div class="pull-left v2"><span class="cs_navbar_span-sele">选择 -&gt;</span>
				<?php if(isset($depart)){ ?>
				<div class="btn-group cs_navbar_btn-group">
					<button type="button" class="btn btn-info btn-sm"><?php echo $depart ?></button>
					<button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<span class="caret"></span>
					</button>
					<ul class="dropdown-menu">
						<?php 
						if(is_array($depart_list)){
							foreach($depart_list as $k=>$info){
							?>
							<li<?php if($depart==$info['explains']){ echo ' class="disabled"'; } ?>><a href="./?m=admin&c=anls&a=<?php echo $action ?>&depart=<?php echo $info['explains'] ?>"><?php echo $info['explains'] ?></a></li>
							<?php
							}
						}
						?>
					</ul>
				</div><!--btn-group-->
				<?php } ?>
				
				<?php if(isset($sdata)){ ?>
				<div class="btn-group cs_navbar_btn-group">
					<button type="button" class="btn btn-warning btn-sm"><?php if($sdata=='dydata'){ echo '到院数据'; } if($sdata=='yydata'){ echo '预约数据'; } ?></button>
					<button type="button" class="btn btn-warning btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<span class="caret"></span>
					</button>
					<ul class="dropdown-menu">
						<li<?php if($sdata=='dydata'){ echo ' class="disabled"'; } ?>><a href="./?m=admin&c=anls&a=<?php echo $action ?>&s=dydata">到院数据</a></li>
						<li<?php if($sdata=='yydata'){ echo ' class="disabled"'; } ?>><a href="./?m=admin&c=anls&a=<?php echo $action ?>&s=yydata">预约数据</a></li>
					</ul>
				</div><!--btn-group-->
				<?php } ?>
			</div><!--pull-left-->
			<div class="pull-right v3">
				<?php if(!isset($sedate)){ $cs_vis='visibility: hidden;'; } ?>
				<form class="navbar-form navbar-left" role="search" noajax="noajax" style="width: 540px;<?php echo $cs_vis ?>" method="post" action="./?m=admin&c=quer&fromer=<?php echo ROUTE_C ?>&ctrl=<?php echo $ctrl ?>">
					<div class="col-sm-6"></div>
					<div class="col-sm-6">
						<input type="hidden" name="p[stdate]" value="<?php echo $stdate ?>" />
						<input type="hidden" name="p[endate]" value="<?php echo $endate ?>" />
						<button class="btn btn-default sc_fithd_btn mdatepicker dropens-left" type="button" bind="p[stdate]|p[endate]|date-title" autoact="autopost"><span class="date-title" id="date-title"><?php echo $sedate ?></span> <i class="fa fa-caret-down"></i></button>
					</div>
				</form>
			</div><!-- pull-right -->
		</div><!-- cs_navbar -->
		<div class="col-sm-12">
			
			<div class="panel panel-default">
				<div class="panel-body">
					<?php
					if($chart_type=='line'){
						if(isset($comingsoon)){
							echo $comingsoon;
						}else{
							include PC_PATH.'modules'.DIRECTORY_SEPARATOR.'admin'.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'anls_chart_line.tpl.php';
						}
					}
					?>
					
					<?php
					if($chart_type=='pie'){
						if(isset($comingsoon)){
							echo $comingsoon;
						}else{
							include PC_PATH.'modules'.DIRECTORY_SEPARATOR.'admin'.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'anls_chart_pie.tpl.php';
						}
					}
					?>
					
					<?php
					if($chart_type=='column'){
						if(isset($comingsoon)){
							echo $comingsoon;
						}else{
							include PC_PATH.'modules'.DIRECTORY_SEPARATOR.'admin'.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'anls_chart_column.tpl.php';
						}
					}
					?>
					<!--position:absolute;top:80px;left:14px;-->
					<div id="container" style="min-width:700px;height:<?php echo $chart_height ?>;margin-right:5%;"></div>
					<?php
					if($chart_info!=''){
					?>
					<div class="alert alert-info"><?php echo $chart_info ?></div>
					<?php
					}
					?>
				</div><!--panel-body-->
			</div>
		</div><!-- col-sm-12 -->
		<footer class="col-sm-12">
			<p>&copy; Bootstrap Company 2013</p>
		</footer>
	</div>
	<!-- /.container -->
</div>
<?php
$JSCSS='<script type="text/javascript" src="'.JS_PATH.'highcharts.js"></script>';
include PC_PATH.'modules'.DIRECTORY_SEPARATOR.'admin'.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'footer.tpl.php';
?>