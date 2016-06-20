<?php
defined('IN_ADMIN') or exit('No permission resources.'); //模板
$soblock='000-003-005';
include PC_PATH.'modules'.DIRECTORY_SEPARATOR.'admin'.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'header.tpl.php';
?>
<div id="mainpage">

	<?php
	include PC_PATH.'modules'.DIRECTORY_SEPARATOR.'admin'.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'navier.tpl.php';
	?>
	<div class="cs_container"><!-- container -->
		<div class="cs_navbar col-sm-12">
			<h4 class="pull-left v1"><span class="label label-primary">排班设置</span></h4>
			<div class="pull-left v2">
				<!-- <a href="#" class="navbar-link"><i class="fa fa-download"></i> 导出excel</a> -->
			</div>
			<div class="pull-right v3">
				
			</div><!-- pull-right -->
		</div><!-- cs_navbar -->
		<div class="col-sm-12">
			
			<div class="panel panel-default">
				<div class="panel-body">
					<form class="form-horizontal" role="form" name="form1" method="post" action="./?m=admin&c=line&a=<?php echo $action ?>&dosubmit=1" onsubmit="return dealForm()">
						<div class="form-group">
							<label class="col-sm-1 control-label">名称：</label>
							<div class="col-sm-2">
								<label class="control-label">
									<select class="form-control" name="pbsort">
										<?php 
										if(is_array($pbqk_list)){
											foreach($pbqk_list as $info){
											if($r['pbsort']==$info['cname']){
											?>
											<option value="<?php echo $info['cname'] ?>" selected="selected"><?php echo $info['cname'] ?></option>
											<?php
											}else{
											?>
											<option value="<?php echo $info['cname'] ?>"><?php echo $info['cname'] ?></option>
											<?php
											}
											}
										}
										?>
									</select>
								</label>
							</div>
							<div class="col-sm-9"></div>
						</div>
						<div class="form-group clearfix">
							<label class="col-sm-1 control-label">选择月份：</label>
							<div class="col-sm-8">
								<label class="control-label month_h" id="month_h">
									<?php
									for($i=12; $i>=1; $i--){
									$dclass='';
									if(isset($r['pbmonth'])){
										$dclass=$r['pbmonth']==$i?' cur_month':'';
									}else{
										$dclass=date('m',SYS_TIME)==$i?' cur_month':'';
									}
									?>
									<a bd="<?php echo $i ?>" href="javascript:void(0)" class="sele_month<?php echo $dclass ?>"><?php echo $i ?>月份</a>&nbsp;&nbsp;
									<?php
									}
									?>
								</label>
							</div>
							<div class="col-sm-3"></div>
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
								<td rowspan="2" align="center">删除</td>
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
										<td align="center"><input type="text" class="form-control pbinput_name" bd="datais" name="pbname" value="<?php echo $info[0][0] ?>" size="6" maxlength="6" /></td>
										<?php
										if(is_array($pbval)){
											foreach($pbval as $index=>$value){
											$dstyle='';
											if($index>($maxday-1)){
												$dstyle=' style="display:none;"';
											}
											?>
											<td align="center" class="pbv_r_<?php echo $value ?>"<?php echo $dstyle ?>><input type="text" class="form-control pbinput" bd="datais" name="pbv<?php echo $value ?>" value="<?php echo $pbv[$index] ?>" size="3" maxlength="2" /></td>
											<?php
											}
										}
										?>
										<td align="center"><button type="button" name="delrow" class="btn btn-primary pbinput_button">删</button></td>
								</tr>
								<?php
								}
							}
							?>
						</tbody>
						</table>
						<div class="form-group">
							<div class="col-sm-1"><button type="button" name="addrow" id="addrow" class="btn btn-primary">新增一行</button></div>
							<label class="col-sm-2 control-label">自动填充当前行：</label>
							<div class="col-sm-1"><input type="text" class="form-control" name="autoinp" id="autoinp" value="" maxlength="5" /></div>
							<div class="col-sm-3"><button type="button" name="autorow" id="autorow" class="btn btn-primary">填充</button>&nbsp;(早 中 晚 全 白 夜 休)</div>
							<div class="col-sm-5">
								<input name="cid" type="hidden" value="<?php echo $r['cid'] ?>" />
								<input name="ctrl" type="hidden" value="<?php echo $ctrl ?>" />
								<button type="submit" name="submit" id="submit" class="btn btn-success">保存</button>
							</div>
						</div>
					</form>
					<div class="form-group clearfix">
						<div class="col-sm-12"></div>
					</div>
					<form name="myform" id="myform" method="post" action="">
					<table class="table table-striped cs_table-st1">
						<thead>
							<tr>
								<th><input type="checkbox" id="check_all_ckbox" onclick="selectall('ids[]');" aria-label="全选/取消" /></th>
								<th>记录ID</th>
								<th>月份</th>
								<th>说明</th>
								<th>更新时间</th>
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
									<td><?php echo $info['id'] ?></td>
									<td><?php echo $info['pbmonth'] ?></td>
									<td><?php echo $info['pbsort'] ?></td>
									<td><?php echo date('Y-m-d H:i:s',$info['addtime']) ?></td>
									<td><a href="./?m=admin&c=line&a=<?php echo $action ?>&ctrl=modify&cid=<?php echo $info['id'] ?>">修改</a></td>
								</tr>
								<?php
								}
							}
							?>
						</tbody>
					</table><!-- table-striped cs_table-st1 -->
					<div class="ctrlbtn">
						<label for="check_box" class="select_all_ckbox">全选/反选</label>
						<input type="button" class="btn btn-info btn-sm" value="删除" onclick="confirmdo('您真的要执行删除数据操作吗？',function(){fsubmit('myform','./?m=admin&c=line&a=deleteds&ctrl=<?php echo $action ?>&dosubmit=1')});" />
					</div><!-- ctrlbtn -->
					</form>
					<div id="pagelist" class="pagelist"><ul class="pagination"><?php echo $pages ?></ul></div>
					
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