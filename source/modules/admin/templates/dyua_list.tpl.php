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
			<h4 class="pull-left v1"><span class="label label-primary">到院数据</span></h4>
			<div class="pull-left v2">列表 -&gt;
				<?php if(isset($stdate)&&isset($endate)){ ?>
				到院日期[<span class="red"><?php echo $stdate ?>至<?php echo $endate ?></span>]
				<?php } ?>

				<?php if(isset($keywd)){ ?>
				关键字[<span class="red"><?php echo $keywd ?></span>]
				<?php } ?>
				
				<?php if(admin::check_roid('|84,')){ ?>
				<a href="<?php echo get_url() ?>&echo=export" target="_blank" class="navbar-link"><i class="fa fa-download"></i> 导出excel</a>
				<?php } ?>
			</div>
			<div class="pull-right v3">
				<form class="navbar-form navbar-left" role="search" noajax="noajax" style="width: 540px;" method="post" action="./?m=admin&c=quer&fromer=<?php echo $fromer ?>&ctrl=<?php echo $ctrl ?>">
					<div class="col-sm-6">
						<input type="hidden" name="p[stdate]" value="<?php echo $stdate ?>" />
						<input type="hidden" name="p[endate]" value="<?php echo $endate ?>" />
						<button class="btn btn-default sc_fithd_btn rdatepicker dropens-left" type="button" bind="info[stdate]|info[endate]|date-title"><span class="date-title" id="date-title"><?php echo $sedate ?></span> <i class="fa fa-caret-down"></i></button>
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
					<form name="myform" id="myform" method="post" action="">
					<div class="cs_table_panel-scroll">
					<table class="table table-striped cs_table-st1">
						<thead>
							<tr>
								<th><input type="checkbox" id="check_all_ckbox" onclick="selectall('ids[]');" aria-label="全选/取消" /></th>
								<th>日期</th>
								<th>患者信息</th>
								<th>登记姓名</th>
								<th>地区</th>
								<th>电话</th>
								<th>病种</th>
								<th>预约号</th>
								<th>接诊专家</th>
								<th>咨询员</th>
								<th>预约途径</th>
								<!--<th>关键词</th>-->
								<th>就诊情况</th>
								<th>实际消费</th>
								<th>备注</th>
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
									<td><?php echo date('m-d',$info['lydate']) ?></td>
									<td title="<?php echo $info['hzname'] ?>"><?php echo str_cut($info['hzname'],3*4) ?>|<?php echo $info['hzsex'] ?>|<?php echo $info['hzage'] ?></td>
									<td><?php echo $info['djname'] ?></td>
									<td><?php echo $info['hzcity'] ?></td>
									<td><?php self::judge_role(0, $info) ?></td>
									<td title="<?php echo $info['bingzm'].'['.$info['bingzx'].']' ?>"><?php echo str_cut($info['bingzm'].'['.$info['bingzx'].']',3*8) ?></td>
									<td title="<?php echo $info['yynum'] ?>"><?php echo str_cut($info['yynum'],3*3) ?></td>
									<td><?php echo $info['jzzj'] ?></td>
									<td><?php echo $info['yyzxy'] ?></td>
									<td><?php echo $info['yytj'] ?></td>
									<!--<td title="<?php echo $info['yykey'] ?>"><div class="txt_fixed"><?php echo str_cut($info['yykey'],3*12) ?></div></td>-->
									<td>
									<?php
									if($info['jzqk']=='待定')
									$info['jzqk']='<span class="red">'.$info['jzqk'].'</span>';
									
									if($info['jzqk']=='消费|不足50元')
									$info['jzqk']='<span class="red">'.$info['jzqk'].'</span>';
									
									if($info['jzqk']=='挂号没消费')
									$info['jzqk']='<span class="orange">'.$info['jzqk'].'</span>';
									
									if($info['sjxf']<50)
									$info['jzqk']='<span class="red">'.$info['jzqk'].'</span>';
									
									echo $info['jzqk'];
									?>
									</td>
									<td><?php self::judge_role(8, $info) ?></td>
									<td class="txt_fixed_lb" col="c1" title="<?php echo $info['remark'] ?>"><div class="txt_fixed" col="c1"><?php echo str_cut($info['remark'],3*20) ?></div></td>
									<td>
										<?php if(admin::check_roid('|23,')){ ?>
										<a href="./?m=admin&c=dyua&a=public_edit&cid=<?php echo $info['id'] ?>">修改</a>
										<?php } ?>
									</td>
								</tr>
								<?php
								}
							}
							?>
						</tbody>
					</table>
					</div><!--cs_table_panel-scroll-->
					<div class="ctrlbtn">
						<label for="check_box" class="select_all_ckbox">全选/反选</label>
						<?php if(admin::check_roid('|24,')){ ?>
						<input type="button" class="btn btn-info btn-sm" value="删除" onclick="confirmdo('您真的要执行删除数据操作吗？',function(){fsubmit('myform','./?m=admin&c=dyua&a=deleteds&ctrl=<?php echo $action ?>&dosubmit=1')});" />
						<?php } ?>
					</div><!-- ctrlbtn -->
					</form>
					<div id="pagelist" class="pagelist"><ul class="pagination"><?php echo $pages ?></ul></div>
					<center>
					<?php
					//echo $page['string'];
					?>
					<!--<ul class="pagination">
						<li class="disabled"><a href="#">«</a></li>
						<li class="active"><a href="#">1 <span class="sr-only">(current)</span></a></li>
						<li><a href="#">2</a></li>
						<li><a href="#">3</a></li>
						<li><a href="#">4</a></li>
						<li><a href="#">5</a></li>
						<li><a href="#">»</a></li>
					</ul>-->
					</center>
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