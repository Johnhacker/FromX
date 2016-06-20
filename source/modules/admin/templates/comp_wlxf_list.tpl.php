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
			<h4 class="pull-left v1"><span class="label label-primary">推广费用数据</span></h4>
			<div class="pull-left v2">
				<a href="#" class="navbar-link"><i class="fa fa-download"></i> 导出excel</a>
			</div>
			<div class="pull-right v3">
				
			</div><!-- pull-right -->
		</div><!-- cs_navbar -->
		<div class="col-sm-12">
			
			<div class="panel panel-default">
				<div class="panel-body">
					<form name="myform" id="myform" method="post" action="">
					<div class="table-responsive">
					<table class="table table-bordered table-condensed table-striped cs_table-st1">
						<thead>
							<tr>
								<?php 
								if(is_array($arr_thead)){
									foreach($arr_thead as $info){
									?>
									<th><?php echo $info ?></th>
									<?php
									}
								}
								?>
							</tr>
						</thead>
						<tbody>
							<?php 
							if(is_array($infos)){
								foreach($infos as $info){
								?>
								<tr>
									<?php 
									if($info[0]=='合计'){
										$boldst='<b>{$1}</b>';
									}else{
										$boldst='{$1}';
									}
									if(is_array($info)){
										foreach($info as $arr){
										?>
										<td><?php echo str_replace('{$1}', $arr, $boldst) ?></td>
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
					</div><!--table-responsive-->
					</form>
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