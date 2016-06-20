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
			<h4 class="pull-left v1"><span class="label label-primary">历史编辑</span></h4>
			<div class="pull-left v2">列表 -&gt;
				<?php
				if(isset($stdate)&&isset($endate)){
				?>
				日期范围[<span class="red"><?php echo $stdate ?>至<?php echo $endate ?></span>]
				<?php
				}
				?>
				<?php
				if(isset($keywd)){
				?>
				关键字[<span class="red"><?php echo $keywd ?></span>]
				<?php
				}
				?>
				<!--<a href="#" class="navbar-link"><i class="fa fa-download"></i> 导出excel</a>-->
			</div>
			<div class="pull-right v3">
				<form class="navbar-form navbar-left" role="search" noajax="noajax" style="width: 540px;" method="post" action="./?m=admin&c=quer&fromer=<?php echo $fromer ?>&ctrl=<?php echo $ctrl ?>">
					<div class="col-sm-6">
						<input type="hidden" name="p[stdate]" value="<?php echo $stdate ?>" />
						<input type="hidden" name="p[endate]" value="<?php echo $endate ?>" />
						<button class="btn btn-default sc_fithd_btn rdatepicker dropens-left" type="button" bind="p[stdate]|p[endate]|date-title"><span class="date-title" id="date-title"><?php echo $sedate ?></span> <i class="fa fa-caret-down"></i></button>
					</div>
					<div class="col-sm-6">
						<div class="input-group input-group-sm">
							<input type="text" name="p[keyword]" size="10" maxlength="20" class="form-control" value="<?php echo $keywd ?>" placeholder="姓名、电话、预约号" />
							<span class="input-group-btn">
								<button type="submit" class="btn btn-default">查询</button>
							</span>
						</div>
					</div>
				</form>
			</div><!-- pull-right -->
		</div><!-- cs_navbar -->
		<div class="col-sm-12">
			
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="alert alert-info">模块正在开发中，敬请期待！…</div>
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