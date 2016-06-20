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
			<h4 class="pull-left v1"><span class="label label-primary"><?php echo $actioname ?></span></h4>
			<div class="pull-left v2">
				<?php if(isset($stdate)&&isset($endate)){ ?>
				日期范围[<span class="red"><?php echo $stdate ?>至<?php echo $endate ?></span>]
				<?php } ?>
				<a href="<?php echo get_url() ?>&echo=export" target="_blank" class="navbar-link"><i class="fa fa-download"></i> 导出excel</a>
			</div>
			<div class="pull-right v3">
				<?php if(isset($sedate)){ ?>
				<form class="navbar-form navbar-left" role="search" noajax="noajax" style="width: 540px;"  method="post" action="./?m=admin&c=quer&fromer=<?php echo ROUTE_C ?>&ctrl=<?php echo $ctrl ?>">
					<div class="col-sm-6"></div>
					<div class="col-sm-6">
						<input type="hidden" name="p[stdate]" value="<?php echo $stdate ?>" />
						<input type="hidden" name="p[endate]" value="<?php echo $endate ?>" />
						<button class="btn btn-default sc_fithd_btn mdatepicker dropens-left" type="button" bind="p[stdate]|p[endate]|date-title" autoact="autopost"><span class="date-title" id="date-title"><?php echo $sedate ?></span> <i class="fa fa-caret-down"></i></button>
					</div>
				</form>
				<?php } ?>
			</div><!-- pull-right -->
		</div><!-- cs_navbar -->
		<div class="col-sm-12">
			
			<div class="panel panel-default">
				<div class="panel-body">
					<form name="myform" id="myform" method="post" action="">
					<div class="cs_table_panel-scroll">
					<table class="table table-striped cs_table-st1">
						<thead>
							<tr>
								<th>日期</th>
								<th>患者姓名</th>
								<th>性别/年龄</th>
								<th>预约号</th>
								<th>科室</th>
								<th>病种</th>
								<th>接诊专家</th>
								<th>咨询员</th>
								<th>预约途径</th>
								<th>就诊情况</th>
								<th>实际消费</th>
								<th>关键词</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							if(is_array($infos)){
								foreach($infos as $info){
								?>
								<tr>
									<td><?php echo date('m-d',$info['lydate']) ?></td>
									<td title="<?php echo $info['hzname'] ?>"><?php echo str_cut($info['hzname'],3*4) ?></td>
									<td><?php echo $info['hzsex'] ?><?php if($info['hzage']!=''){ echo '|'.$info['hzage']; } ?></td>
									<td title="<?php echo $info['yynum'] ?>"><?php echo str_cut($info['yynum'],3*3) ?></td>
									<td><?php echo $info['bingzx'] ?></td>
									<td title="<?php echo $info['bingzm'] ?>"><?php echo str_cut($info['bingzm'],3*8) ?></td>
									<td><?php echo $info['jzzj'] ?></td>
									<td><?php echo $info['yyzxy'] ?></td>
									<td><?php echo $info['yytj'] ?></td>
									<td>
									<?php
									if($info['jzqk']=='待定')
									$info['jzqk']='<span class="red">'.$info['jzqk'].'</span>';
									
									if($info['jzqk']=='挂号没消费')
									$info['jzqk']='<span class="orange">'.$info['jzqk'].'</span>';
									echo $info['jzqk'];
									?>
									</td>
									<td><?php echo self::get_capital($info['sjxf']) ?></td>
									<td title="<?php echo $info['yykey'] ?>"><div class="txt_fixed"><?php echo str_cut($info['yykey'],3*12) ?></div></td>
								</tr>
								<?php
								}
							}
							?>
						</tbody>
					</table>
					</div><!--cs_table_panel-scroll-->
					</form>
					<div id="pagelist" class="pagelist"><ul class="pagination"><?php echo $pages ?></ul></div>
				</div>
			</div>
		</div><!-- col-sm-12 -->
		<footer class="col-sm-12">
			<p>&copy; Bootstrap Company 2013</p>
		</footer>
	</div>
	<!-- /.container -->
</div>
<?php
include PC_PATH.'modules'.DIRECTORY_SEPARATOR.'admin'.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'footer.tpl.php';
?>