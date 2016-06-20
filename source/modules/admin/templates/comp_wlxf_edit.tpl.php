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
		<div class="col-sm-12">
			
			<ul class="nav nav-tabs mb-1">
				<li class="active"><a><b class="blue">综合数据</b></a></li>
			</ul>
			<div class="panel panel-default mt">
				<div class="panel-body">
					<form class="form-horizontal" role="form" name="form1" method="post" action="./?m=admin&c=comp&a=<?php echo $action ?>&dosubmit=1">
						<div class="form-group">
							<label class="col-sm-2 control-label">日期：</label>
							<div class="col-sm-3">
								<div class="input-prepend input-group">
									<span class="add-on input-group-addon"><i class="fa fa-calendar"></i></span>
									<input name="info[rcdate]" type="text" class="form-control sc_readonly-nbg sdatepicker" value="<?php echo $r['rcdate'] ?>" maxlength="20" readonly="readonly" required />
								</div>
							</div>
							<div class="col-sm-7"><span class="help-block">* 注：日期默认为昨天</span></div>
						</div>
						<?php 
						if(is_array($infos)){
							foreach($infos as $info){
							?>
							<div class="form-group">
								<label class="col-sm-2 control-label"><?php echo $info['cname'] ?>：</label>
								<div class="col-sm-3"><input type="text" class="form-control" name="info[wlxf<?php echo $info['id'] ?>]" placeholder="请输入推广费用 格式(100)" value="<?php echo $info['tgcost'] ?>" pattern="^[0-9]{0,}$" /></div>
								<div class="col-sm-7"></div>
							</div>
							<?php
							}
						}
						?>
						<div class="form-group">
							<label class="col-sm-2 control-label"></label>
							<div class="col-sm-4">
								<button type="submit" class="btn btn-primary">提 交</button>
							</div>
							<div class="col-sm-6"></div>
						</div>
					</form>
				</div><!-- panel-body -->
			</div><!-- panel panel-default -->
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