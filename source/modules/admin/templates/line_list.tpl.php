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
			<h4 class="pull-left v1"><span class="label label-primary"><?php echo $r['cname'] ?></span></h4>
			<div class="pull-left v2">
				<a href="<?php echo get_url() ?>&echo=export" target="_blank" class="navbar-link"><i class="fa fa-download"></i> 导出excel</a>
			</div>
			<div class="pull-right v3">
				
			</div><!-- pull-right -->
		</div><!-- cs_navbar -->
		<div class="col-sm-12">
			
			<div class="panel panel-default">
				<div class="panel-body">
					<form class="form-horizontal" role="form" name="form1" method="post" action="./?m=admin&c=line&a=<?php echo $action ?>&dosubmit=1" onsubmit="return dealForm()">
						
						<div class="form-group clearfix">
							<div class="col-sm-12">
								<div class="alert alert-info cs_hdti-pbedit"><center><span class="i1"><?php echo $r['cname'] ?></span><br /><span class="i2"><?php echo $r['explains'] ?></span></center></div>
							</div>
						</div>
						<table class="table table-bordered table-condensed table-striped cs_table-st1 cs_table-pbedit" id="mode01_data_main">
						<tbody>
							<tr>
								<td height="44" rowspan="2" width="60">日期<br/>&nbsp;&nbsp;&nbsp;&nbsp;姓名<input type="hidden" id="pbdata" name="pbdata" value="" /><input type="hidden" id="pbmonth" name="pbmonth" value="<?php echo date('m',SYS_TIME) ?>" /></td>
								<?php
								if(is_array($thead)){
									foreach($thead as $key=>$info){
									$dstyle='';
									if($key>($maxday-1)){
										$dstyle=' style="display:none;"';
									}
									?>
									<td width="25" align="center" id="days_<?php echo $info ?>"<?php echo $dstyle ?>><?php echo $info ?></td>
									<?php
									}
								}
								?>
							</tr>
							<tr>
								<?php
								if(is_array($weeks)){
									foreach($weeks as $key=>$info){
									$dstyle='';
									if($key>($maxday-1)){
										$dstyle=' style="display:none;"';
									}
									?>
									<td align="center" id="weeks_<?php echo $key+1 ?>"<?php echo $dstyle ?>><?php echo str_replace('日','<strong style="color:red;">日</strong>',$info) ?></td>
									<?php
									}
								}
								?>
							</tr>
							<?php
							if(is_array($pblist)){
								foreach($pblist as $key=>$info){
								$pbv=explode(',', $info[0][1]);
								?>
								<tr class="datarow">
									<td align="center"><?php echo $info[0][0] ?></td>
									<?php
									if(is_array($pbval)){
										foreach($pbval as $index=>$value){
										$dstyle='';
										if($index>($maxday-1)){
											$dstyle=' style="display:none;"';
										}
										?>
										<td align="center" class="pbv_r_<?php echo $value ?>"<?php echo $dstyle ?>><?php echo $pbv[$index] ?></td>
										<?php
										}
									}
									?>
								</tr>
								<?php
								}
							}
							?>
						</tbody>
						</table>
					</form>
					
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
include PC_PATH.'modules'.DIRECTORY_SEPARATOR.'admin'.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'footer.tpl.php';
?>