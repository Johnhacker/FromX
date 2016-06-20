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
			<h4 class="pull-left v1"><span class="label label-primary">用户列表</span></h4>
			<div class="pull-left v2"></div>
			<div class="pull-right v3">
			</div><!-- pull-right -->
		</div><!-- cs_navbar -->
		<div class="col-sm-12">
			
			<div class="panel panel-default">
				<div class="panel-body">
					<form name="myform" id="myform" method="post" action="">
					<table class="table table-striped cs_table-st1">
						<thead>
							<tr>
								<th><input type="checkbox" id="check_all_ckbox" onclick="selectall('ids[]');" aria-label="全选/取消" /></th>
								<th>生效</th>
								<th>用户名</th>
								<th>部门</th>
								<th>★★★操作范围★★★（点击表头展开操作范围 点'修改'查看描述）</th>
								<th>最近登录时间</th>
								<th>最近登录IP</th>
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
									<td><input type="checkbox" name="ids[]" value="<?php echo $info['userid'] ?>" aria-label="选择" /></td>
									<td><?php if($info['useing']==1){ echo '<i class="fa fa-check-square-o"></i>'; }else{ echo '<i class="fa fa-square-o"></i>'; } ?></td>
									<td><?php echo $info['username'] ?></td>
									<td><?php echo $info['depart'] ?></td>
									<td class="txt_fixed_lb" col="c1"><div class="txt_fixed2" col="c1"><?php echo $info['purview'] ?></div></td>
									<td><?php echo date('Y-m-d H:i:s',$info['lastlogintime']) ?></td>
									<td><?php echo $info['lastloginip'] ?></td>
									<td><?php echo date('Y-m-d H:i:s',$info['addtime']) ?></td>
									<td><a href="./?m=admin&c=user&a=public_adduser&ctrl=copy&cid=<?php echo $info['userid'] ?>"><i class="fa fa-files-o"></i> 复制</a>　<a href="./?m=admin&c=user&a=public_edituser&cid=<?php echo $info['userid'] ?>">修改</a></td>
								</tr>
								<?php
								}
							}
							?>
						</tbody>
					</table>
					<div class="ctrlbtn">
						<label for="check_box" class="select_all_ckbox">全选/反选</label>
						<input type="button" class="btn btn-info btn-sm" value="删除" onclick="confirmdo('您真的要执行删除数据操作吗？',function(){fsubmit('myform','./?m=admin&c=sysm&a=deleteds&ctrl=<?php echo $action ?>&dosubmit=1')});" />
					</div><!-- ctrlbtn -->
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