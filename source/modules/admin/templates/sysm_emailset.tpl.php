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
				<li class="active"><a><b class="blue"><?php echo $iname ?>设置</b></a></li>
			</ul>
			<div class="panel panel-default mt">
				<div class="panel-body">
					<form class="form-horizontal" role="form" name="form1" method="post" action="./?m=admin&c=sysm&a=<?php echo $action ?>&dosubmit=1">
						<div class="form-group">
							<label class="col-sm-2 control-label">邮箱名称：</label>
							<div class="col-sm-4"><input type="text" class="form-control" name="emname" value="<?php echo $r['emname'] ?>" required /></div>
							<div class="col-sm-6"></div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">生效：</label>
							<div class="col-sm-4"><label class="checkbox"><input type="checkbox" name="useing" value="true"<?php if($r['useing']==1){ echo ' checked="checked"'; } ?> />&nbsp;</label></div>
							<div class="col-sm-6"></div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">邮箱地址：</label>
							<div class="col-sm-4"><input type="text" class="form-control" name="emaddr" value="<?php echo $r['emaddr'] ?>" required pattern="^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$" /></div>
							<div class="col-sm-6"></div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">备注说明：</label>
							<div class="col-sm-4"><textarea rows="3" class="form-control" name="explains"><?php echo $r['explains'] ?></textarea></div>
							<div class="col-sm-6"></div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label"></label>
							<div class="col-sm-4">
								<input name="cid" type="hidden" value="<?php echo $r['cid'] ?>" />
								<input name="ctrl" type="hidden" value="<?php echo $ctrl ?>" />
								<button type="submit" class="btn btn-primary">提 交</button>
							</div>
							<div class="col-sm-6"></div>
						</div>
					</form>
					
					<form name="myform" id="myform" method="post" action="">
					<table class="table table-striped cs_table-st1">
						<thead>
							<tr>
								<th><input type="checkbox" id="check_all_ckbox" onclick="selectall('ids[]');" aria-label="全选/取消" /></th>
								<th>排序</th>
								<th>记录ID</th>
								<th>生效</th>
								<th>邮箱名称</th>
								<th>邮箱地址</th>
								<th>备注说明</th>
								<th>创建时间</th>
								<th>操作</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							if(is_array($infos)){
								foreach($infos as $info){
								?>
								<tr>
									<td><input type="checkbox" name="ids[]" value="<?php echo $info['id'] ?>" aria-label="选择" /></td>
									<td><input type="text" class="form-control cs_listorder" value="<?php echo $info['listorder'] ?>" size="4" name="listorders[<?php echo $info['id'] ?>]" /></td>
									<td><?php echo $info['id'] ?></td>
									<td><?php if($info['useing']==1){ echo '<i class="fa fa-check-square-o"></i>'; }else{ echo '<i class="fa fa-square-o"></i>'; } ?></td>
									<td><?php echo $info['emname'] ?></td>
									<td><?php echo $info['emaddr'] ?></td>
									<td><?php echo $info['explains'] ?></td>
									<td><?php echo date('Y-m-d H:i:s',$info['addtime']) ?></td>
									<td><a href="./?m=admin&c=sysm&a=<?php echo $action ?>&ctrl=modify&cid=<?php echo $info['id'] ?>">修改</a></td>
								</tr>
								<?php
								}
							}
							?>
						</tbody>
					</table><!-- table-striped cs_table-st1 -->
					<div class="ctrlbtn">
						<label for="check_box" class="select_all_ckbox">全选/反选</label>
						<input type="button" class="btn btn-info btn-sm" value="删除" onclick="confirmdo('您真的要执行删除数据操作吗？',function(){fsubmit('myform','./?m=admin&c=sysm&a=deleteds&ctrl=<?php echo $action ?>&dosubmit=1')});" />
						<input type="button" class="btn btn-info btn-sm" value="排序" onclick="fsubmit('myform','./?m=admin&c=sysm&a=listorder&ctrl=<?php echo $action ?>&dosubmit=1');" />
					</div><!-- ctrlbtn -->
					</form>
					<div id="pagelist" class="pagelist"><ul class="pagination"><?php echo $pages ?></ul></div>
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