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
				<li class="active"><a><b class="blue">修改密码</b></a></li>
			</ul>
			<div class="panel panel-default mt">
				<div class="panel-body">
					<form class="form-horizontal" role="form" name="form1" method="post" action="./?m=admin&c=user&a=<?php echo $action ?>&dosubmit=1">
						<div class="form-group">
							<label class="col-sm-2 control-label">登录名：</label>
							<div class="col-sm-4"><input type="text" class="form-control" name="username" value="<?php echo $r['username'] ?>" readonly="readonly" /></div>
							<div class="col-sm-6"></div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">新密码：</label>
							<div class="col-sm-4"><input type="password" class="form-control" name="info[password]" value="" required /></div>
							<div class="col-sm-6"></div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">确认密码：</label>
							<div class="col-sm-4"><input type="password" class="form-control" name="info[pwdconfirm]" value="" required /></div>
							<div class="col-sm-6"></div>
						</div>
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