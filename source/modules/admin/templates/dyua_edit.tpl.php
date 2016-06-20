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
				<li class="active"><a><b class="blue">录入到院数据</b></a></li>
			</ul>
			<div class="panel panel-default mt">
				<div class="panel-body">
					<form class="form-horizontal" role="form" name="form1" method="post" action="./?m=admin&c=dyua&a=<?php echo $action ?>&dosubmit=1">
						<div class="form-group">
							<label class="col-sm-2 control-label">预约号：</label>
							<div class="col-sm-2">
								<label class="control-label sc_label_tb01">
									<i class="fa fa-exclamation-circle"></i>
									<?php echo $r['yynum'] ?>
								</label>
							</div>
							<div class="col-sm-8"></div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">患者姓名：</label>
							<div class="col-sm-2">
								<label class="control-label">
									<i class="fa fa-user"></i>
									<?php echo $r['hzname'] ?>
								</label>
							</div>
							<label class="col-sm-1 control-label">咨询员：</label>
							<div class="col-sm-2">
								<label class="control-label sc_label_tb01">
									<i class="fa fa-commenting"></i>
									<?php echo $r['yyzxy'] ?>
								</label>
							</div>
							<div class="col-sm-5"></div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">年龄性别：</label>
							<div class="col-sm-2"><label class="control-label"><?php echo $r['hzsex'] ?> | <?php echo $r['hzage'] ?></label></div>
							<label class="col-sm-1 control-label">联系电话：</label>
							<div class="col-sm-2"><label class="control-label sc_label_tb01"><?php echo $r['hztel'] ?></label></div>
							<div class="col-sm-5"></div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">预约时间：</label>
							<div class="col-sm-2"><label class="control-label"><?php echo $r['yytime1'] ?> 至 <?php echo $r['yytime2'] ?></label></div>
							<label class="col-sm-1 control-label">预约专家：</label>
							<div class="col-sm-2"><label class="control-label"><?php echo $r['yyzj'] ?></label></div>
							<div class="col-sm-5"></div>
						</div>
						<div class="form-group">
							<div class="col-sm-12"><div class="sc_spline01"></div></div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">登记姓名：</label>
							<div class="col-sm-2"><input type="text" class="form-control" name="info[djname]" value="<?php echo $r['djname'] ?>" maxlength="20" /></div>
							<div class="col-sm-8"><span class="help-block">* 注：与预约姓名不一致时填写</span></div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">科室病种：</label>
							<div class="col-sm-3">
								<div class="input-prepend input-group sc_swbtn">
									<span class="add-on input-group-addon"><i class="fa fa-th-list"></i></span>
									<input type="text" class="form-control sc_readonly-nbg" name="info[bingz]" value="<?php echo $r['bingz'] ?>" placeholder="--请选择--" readonly="readonly" required />
								</div>
								<div class="sc_panel sc_panel_drop_st01" style="display: none; width: 260px;">
										<div class="sc_panel_drop_vc">
										<div class="sc_mselect_st01" bind="info[bingz]">
											<div class="sc_mselect_data1">
												<ul style="display: block;">
													<?php 
													if(is_array($bzks_list)){
														foreach($bzks_list as $k=>$info){
														
														if($k==0){
														?>
														<li class="on"><?php echo $info['cname'] ?></li>
														<?php
														}else{
														?>
														<li><?php echo $info['cname'] ?></li>
														<?php
														}
														
														}
													}
													?>
												</ul>
											</div>
											<div class="sc_mselect_data2">
												<?php 
												if(is_array($bzks_list)){
													foreach($bzks_list as $k=>$info){
													
													if($k==0){
													?>
													<ul style="display: block;">
													
													<?php
													$info_subs=explode('，',$info['explains']);
													if(is_array($info_subs)){foreach($info_subs as $n=>$info_sub){
													?>
													<li><?php echo $info_sub ?></li>
													<?php
													}}
													?>
													
													</ul>
													<?php
													}else{
													?>
													<ul style="display: none;">
													
													<?php
													$info_subs=explode('，',$info['explains']);
													if(is_array($info_subs)){foreach($info_subs as $n=>$info_sub){
													?>
													<li><?php echo $info_sub ?></li>
													<?php
													}}
													?>
													
													</ul>
													<?php
													}
													
													}
												}
												?>
											</div>
											<div class="clearfix"></div>
										</div><!--sc_mselect_st01-->
										</div><!--sc_panel_drop_vc-->
								</div><!--sc_panel-->
							</div><!--col-sm-3-->
							<div class="col-sm-7"></div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">所在地区：</label>
							<div class="col-sm-3">
								<div class="input-prepend input-group sc_swbtn">
									<span class="add-on input-group-addon"><i class="fa fa-th-list"></i></span>
									<input type="text" class="form-control sc_readonly-nbg" name="info[hzcity]" value="<?php echo $r['hzcity'] ?>" placeholder="--请选择--" readonly="readonly" />
								</div>
								<div class="sc_panel sc_panel_drop_st01" style="display: none; width: 260px;">
										<div class="sc_panel_drop_vc">
										<div class="sc_mselect_st01" bind="info[hzcity]">
											<div class="sc_mselect_data1">
												<ul style="display: block;">
													<?php 
													if(is_array($diqu_list)){
														foreach($diqu_list as $k=>$info){
														
														if($k==0){
														?>
														<li class="on"><?php echo $info['cname'] ?></li>
														<?php
														}else{
														?>
														<li><?php echo $info['cname'] ?></li>
														<?php
														}
														
														}
													}
													?>
												</ul>
											</div>
											<div class="sc_mselect_data2">
												<?php 
												if(is_array($diqu_list)){
													foreach($diqu_list as $k=>$info){
													
													if($k==0){
													?>
													<ul style="display: block;">
													
													<?php
													$info_subs=explode('，',$info['explains']);
													if(is_array($info_subs)){foreach($info_subs as $n=>$info_sub){
													?>
													<li><?php echo $info_sub ?></li>
													<?php
													}}
													?>
													
													</ul>
													<?php
													}else{
													?>
													<ul style="display: none;">
													
													<?php
													$info_subs=explode('，',$info['explains']);
													if(is_array($info_subs)){foreach($info_subs as $n=>$info_sub){
													?>
													<li><?php echo $info_sub ?></li>
													<?php
													}}
													?>
													
													</ul>
													<?php
													}
													
													}
												}
												?>
											</div>
											<div class="clearfix"></div>
										</div><!--sc_mselect_st01-->
										</div><!--sc_panel_drop_vc-->
								</div><!--sc_panel-->
							</div>
							<div class="col-sm-7"></div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">到院时间：</label>
							<div class="col-sm-2">
								<div class="input-prepend input-group">
									<span class="add-on input-group-addon"><i class="fa fa-calendar"></i></span>
									<input type="text" class="form-control sc_readonly-nbg sdatepicker" name="info[lydate]" value="<?php echo $r['lydate'] ?>" readonly="readonly" required />
								</div>
							</div>
							<?php if(admin::check_roid('|26,')){ ?>
							<label class="col-sm-1 control-label">实际消费：</label>
							<div class="col-sm-2"><input type="text" class="form-control sc_label_tb01" name="info[sjxf]" value="<?php echo $r['sjxf'] ?>" maxlength="50" required pattern="^[0-9]{1,}(.)[0-9]{2}$" /></div>
							<?php } ?>
							<div class="col-sm-5"></div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">接诊专家：</label>
							<div class="col-sm-3">
								<div class="input-prepend input-group sc_swbtn">
									<span class="add-on input-group-addon"><i class="fa fa-th-list"></i></span>
									<input type="text" class="form-control sc_readonly-nbg" name="info[jzzj]" value="<?php echo $r['jzzj'] ?>" placeholder="--请选择--" readonly="readonly" required />
								</div>
								<div class="sc_panel sc_panel_drop_st01" style="display: none; width: 260px;">
										<div class="sc_panel_drop_vc">
										<div class="sc_mselect_st01" bind="info[jzzj]|noparent">
											<div class="sc_mselect_data1">
												<ul style="display: block;">
													<?php 
													if(is_array($zjys_list)){
														foreach($zjys_list as $k=>$info){
														
														if($k==0){
														?>
														<li class="on"><?php echo $info['cname'] ?></li>
														<?php
														}else{
														?>
														<li><?php echo $info['cname'] ?></li>
														<?php
														}
														
														}
													}
													?>
												</ul>
											</div>
											<div class="sc_mselect_data2">
												<?php 
												if(is_array($zjys_list)){
													foreach($zjys_list as $k=>$info){
													
													if($k==0){
													?>
													<ul style="display: block;">
													
													<?php
													$info_subs=explode('，',$info['explains']);
													if(is_array($info_subs)){foreach($info_subs as $n=>$info_sub){
													?>
													<li><?php echo $info_sub ?></li>
													<?php
													}}
													?>
													
													</ul>
													<?php
													}else{
													?>
													<ul style="display: none;">
													
													<?php
													$info_subs=explode('，',$info['explains']);
													if(is_array($info_subs)){foreach($info_subs as $n=>$info_sub){
													?>
													<li><?php echo $info_sub ?></li>
													<?php
													}}
													?>
													
													</ul>
													<?php
													}
													
													}
												}
												?>
											</div>
											<div class="clearfix"></div>
										</div><!--sc_mselect_st01-->
										</div><!--sc_panel_drop_vc-->
								</div><!--sc_panel-->
							</div><!--col-sm-3-->
							<div class="col-sm-4"></div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">就诊情况：</label>
							<div class="col-sm-9">
								<?php 
								if(is_array($jzqk_list)){
									foreach($jzqk_list as $k=>$info){
									
									if($r['jzqk']==$info['cname']){
									?>
									<label class="radio-inline"><input name="info[jzqk]" type="radio" value="<?php echo $info['cname'] ?>" checked="checked" /><?php echo $info['cname'] ?></label>
									<?php
									}else{
									?>
									<label class="radio-inline"><input name="info[jzqk]" type="radio" value="<?php echo $info['cname'] ?>" /><?php echo $info['cname'] ?></label>
									<?php
									}
									if(($k+1)%7==0){echo '<br/>';}
									
									}
								}
								?>
							</div>
							<div class="col-sm-1"></div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">来院方式：</label>
							<div class="col-sm-9">
								<?php 
								if(is_array($lyfs_list)){
									foreach($lyfs_list as $k=>$info){
									
									if($r['lyfs']==$info['cname']){
									?>
									<label class="radio-inline"><input name="info[lyfs]" type="radio" value="<?php echo $info['cname'] ?>" checked="checked" /><?php echo $info['cname'] ?></label>
									<?php
									}else{
									?>
									<label class="radio-inline"><input name="info[lyfs]" type="radio" value="<?php echo $info['cname'] ?>" /><?php echo $info['cname'] ?></label>
									<?php
									}
									if(($k+1)%9==0){echo '<br/>';}
									
									}
								}
								?>
							</div>
							<div class="col-sm-1"></div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">预约备注：</label>
							<div class="col-sm-6"><textarea name="info[remark]" rows="3" class="form-control" style="background:#F8F8F8;"><?php echo $r['remark'] ?></textarea></div>
							<div class="col-sm-4"></div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">接诊备注：</label>
							<div class="col-sm-6"><textarea name="info[jzremark]" rows="5" class="form-control"><?php echo $r['jzremark'] ?></textarea></div>
							<div class="col-sm-4"></div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label"></label>
							<div class="col-sm-4">
							<input type="hidden" name="info[cid]" value="<?php echo $r['id'] ?>" />
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