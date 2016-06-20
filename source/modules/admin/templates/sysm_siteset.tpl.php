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
				<li class="active"><a><b class="blue">常量设置</b></a></li>
			</ul>
			<div class="panel panel-default mt">
				<div class="panel-body">
					<div class="alert alert-success">基于Bootstrap前端的信息管理系统 由Yokit开发 QQ182860914。</div>
					<form class="form-horizontal" role="form" name="form1" method="post" action="./?m=admin&c=sysm&a=<?php echo $action ?>&dosubmit=1">
						<div class="form-group">
							<label class="col-sm-2 control-label">系统标题：</label>
							<div class="col-sm-4"><input type="text" class="form-control" name="stitle" value="<?php echo $r['sitetitle'] ?>" required /></div>
							<div class="col-sm-6"></div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Cookies时长：</label>
							<div class="col-sm-4"><input type="text" class="form-control" name="cktime" value="<?php echo $r['cookietime'] ?>" required pattern="^\d+$" /></div>
							<div class="col-sm-6"><span class="help-block">* 单位：小时</span></div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">发送邮箱：</label>
							<div class="col-sm-4"><input type="text" class="form-control" name="semail" value="<?php echo $r['fsemail'] ?>" required pattern="^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$" /></div>
							<div class="col-sm-6"></div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">发送邮箱密码：</label>
							<div class="col-sm-4"><input type="password" class="form-control" name="semailpw" value="??????" required /></div>
							<div class="col-sm-6"></div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">样   式：</label>
							<div class="col-sm-4">
								<select class="form-control" name="cstyle">
									<option value="0" selected="selected">默认</option>
								</select>
							</div>
							<div class="col-sm-6"></div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">授 权 号：</label>
							<div class="col-sm-4"><input type="text" class="form-control" name="syssn" value="<?php echo $r['systemsn'] ?>" readonly="readonly" /></div>
							<div class="col-sm-6"></div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label"></label>
							<div class="col-sm-4"><button type="submit" class="btn btn-primary">提 交</button></div>
							<div class="col-sm-6"></div>
						</div>
					</form>
				</div>
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