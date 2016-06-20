<?php
defined('IN_ADMIN') or exit('No permission resources.'); //模板
$soblock='000-003-006';
include PC_PATH.'modules'.DIRECTORY_SEPARATOR.'admin'.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'header.tpl.php';
?>
<div id="mainpage">

	<?php
	include PC_PATH.'modules'.DIRECTORY_SEPARATOR.'admin'.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'navier.tpl.php';
	?>
	<div class="cs_container"><!-- container -->
		<div class="col-sm-12">
			
			<ul class="nav nav-tabs mb-1">
				<li class="active"><a><b class="blue">录入预约数据</b></a></li>
			</ul>
			<div class="panel panel-default mt">
				<div class="panel-body">
					<form class="form-horizontal" role="form" name="form1" method="post" action="./?m=admin&c=main&a=<?php echo $action ?>&dosubmit=1">
						<div class="form-group">
							<label class="col-sm-2 control-label">日期：</label>
							<div class="col-sm-2">
								<div class="input-prepend input-group">
									<span class="add-on input-group-addon"><i class="fa fa-calendar"></i></span>
									<?php if($action=='public_add'||admin::check_roid('|14,')){ ?>
									<input name="info[yydate]" type="text" class="form-control sc_readonly-nbg sdatepicker" value="<?php echo $r['yydate'] ?>" maxlength="20" readonly="readonly" required />
									<?php }else{ ?>
									<input name="info[yydate]" type="text" class="form-control" value="<?php echo $r['yydate'] ?>" maxlength="20" readonly="readonly" required />	
									<?php } ?>
								</div>
							</div>
							<div class="col-sm-8"></div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">患者姓名：</label>
							<div class="col-sm-2">
								<div class="input-prepend input-group">
									<span class="add-on input-group-addon"><i class="fa fa-user"></i></span>
									<input type="text" class="form-control" name="info[hzname]" value="<?php echo $r['hzname'] ?>" maxlength="20" required />
								</div>
							</div>
							<?php
							//if($r['djname']!=''){
							if(true){
							?>
							<label class="col-sm-1 control-label">登记姓名：</label>
							<div class="col-sm-2"><input type="text" class="form-control" name="info[djname]" value="<?php echo $r['djname'] ?>" maxlength="20" readonly="readonly" /></div>
							<div class="col-sm-5"></div>
							<?php
							}else{
							?>
							<div class="col-sm-8"></div>
							<?php
							}
							?>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">预约号：</label>
							<div class="col-sm-2">
								<div class="input-prepend input-group">
									<span class="add-on input-group-addon"><i class="fa fa-exclamation-circle"></i></span>
									<input type="text" class="form-control sc_label_tb01" name="info[yynum]" value="<?php echo $r['yynum'] ?>" maxlength="20" required />
								</div>
							</div>
							<label class="col-sm-1 control-label">联系电话：</label>
							<?php
							$calltel_edtime=pc_base::load_config('sub_config','calltel_edit');
							if(($calltel_edtime==0 || (SYS_TIME-strtotime($info['addtime']))>60*$calltel_edtime) && $calltel_edtime!=1){ ?>
							<div class="col-sm-2"><input type="text" class="form-control" name="info[hztel]" value="<?php self::judge_role(3, $r) ?>" maxlength="50" readonly="readonly" /></div>
							<?php }else{ ?>
							<div class="col-sm-2"><input type="text" class="form-control" name="info[hztel]" value="<?php self::judge_role(3, $r) ?>" maxlength="50"<?php if(self::judge_role(4, $r)) echo ' readonly="readonly"' ?> required pattern="^(-){0,}[0-9]{5,}$" /></div>
							<div class="col-sm-5"><?php if(self::judge_role(4, $r)) echo '<span class="help-block orange">* 注：接管记录不能修改电话</span>' ?></div>
							<?php } ?>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">患者性别：</label>
							<div class="col-sm-2">
								<label class="radio-inline"><input name="info[hzsex]" type="radio" value="男"<?php if($r['hzsex']=='男') echo ' checked="checked"' ?> />男</label>
								<label class="radio-inline"><input name="info[hzsex]" type="radio" value="女"<?php if($r['hzsex']=='女') echo ' checked="checked"' ?> />女</label>
							</div>
							<label class="col-sm-1 control-label">科室病种：</label>
							<div class="col-sm-3">
								<div class="input-prepend input-group sc_swbtn">
									<span class="add-on input-group-addon"><i class="fa fa-th-list"></i></span>
									<input type="text" class="form-control sc_readonly-nbg" name="info[bingz]" value="<?php if($r['bingzm']!=''){ echo $r['bingzm'].'['.$r['bingzx'].']'; } ?>" placeholder="--请选择--" readonly="readonly" required />
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
							<div class="col-sm-4"></div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">患者年龄：</label>
							<div class="col-sm-1"><input type="text" class="form-control" name="info[hzage]" value="<?php echo $r['hzage'] ?>" maxlength="5" pattern="^[0-9].$" /></div>
							<div class="col-sm-1"></div>
							<label class="col-sm-1 control-label">所在地区：</label>
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
							</div><!--col-sm-3-->
							<div class="col-sm-4"></div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">预约时间：</label>
							<div class="col-sm-3">
								<div class="input-prepend input-group">
									<input type="hidden" name="info[yytime1]" value="<?php echo $r['yytime1'] ?>" />
									<input type="hidden" name="info[yytime2]" value="<?php echo $r['yytime2'] ?>" />
									<span class="add-on input-group-addon"><i class="fa fa-calendar"></i></span>
									<input type="text" class="form-control sc_readonly-nbg rdatepicker" name="info[yytime]" bind="info[yytime1]|info[yytime2]|null" value="<?php echo $r['yytimes'] ?>" readonly="readonly" required />
								</div>
							</div>
							<div class="col-sm-7"></div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">预约专家：</label>
							<div class="col-sm-3">
								<div class="input-prepend input-group sc_swbtn">
									<span class="add-on input-group-addon"><i class="fa fa-th-list"></i></span>
									<input type="text" class="form-control sc_readonly-nbg" name="info[yyzj]" value="<?php echo $r['yyzj'] ?>" placeholder="--请选择--" readonly="readonly" required />
								</div>
								<div class="sc_panel sc_panel_drop_st01" style="display: none; width: 260px;">
										<div class="sc_panel_drop_vc">
										<div class="sc_mselect_st01" bind="info[yyzj]|noparent">
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
							<label class="col-sm-2 control-label">预约途径：</label>
							<div class="col-sm-3">
								<div class="input-prepend input-group sc_swbtn">
									<span class="add-on input-group-addon"><i class="fa fa-th-list"></i></span>
									<input type="text" class="form-control sc_readonly-nbg" name="info[yytj]" value="<?php echo $r['yytj'] ?>" placeholder="--请选择--" readonly="readonly" required />
								</div>
								<div class="sc_panel sc_panel_drop_st01" style="display: none; width: 260px;">
										<div class="sc_panel_drop_vc">
										<div class="sc_mselect_st01" bind="info[yytj]|noparent">
											<div class="sc_mselect_data1">
												<ul style="display: block;">
													<?php 
													if(is_array($yytj_list)){
														foreach($yytj_list as $k=>$info){
														
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
												if(is_array($yytj_list)){
													foreach($yytj_list as $k=>$info){
													
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
							<?php if(1==0){ ?>
							<div class="col-sm-9">
								<?php 
								if(is_array($yytj_list)){
									foreach($yytj_list as $k=>$info){
									
									if($r['yytj']==$info['cname']){
									?>
									<label class="radio-inline"><input name="info[yytj]" type="radio" value="<?php echo $info['cname'] ?>" checked="checked" /><?php echo $info['cname'] ?></label>
									<?php
									}else{
									?>
									<label class="radio-inline"><input name="info[yytj]" type="radio" value="<?php echo $info['cname'] ?>" /><?php echo $info['cname'] ?></label>
									<?php
									}
									if(($k+1)%9==0){echo '<br/>';}
									
									}
								}
								?>
							</div>
							<div class="col-sm-1"></div>
							<?php } ?>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">咨询员：</label>
							<div class="col-sm-2">
							<select class="form-control" name="info[yyzxy]">
								<?php 
								if(is_array($zxzy_list)){
									foreach($zxzy_list as $info){
										if($action=='public_add'){
										?>
										<option value="<?php echo $info['cname'] ?>"<?php if($r['yyzxy']==$info['cname']){ echo ' selected="selected"'; }elseif(!admin::check_roid('|12,')){ echo ' disabled="disabled"'; } ?>><?php echo $info['cname'] ?></option>
										<?php
										}else{
											if(admin::check_roid('|18,') && $ctrl!='revisit'){
											?>
												<option value="<?php echo $info['cname'] ?>"<?php if($username==$info['cname']){ echo ' selected="selected"'; }elseif(!admin::check_roid('|14,')){ echo ' disabled="disabled"'; } ?>><?php echo $info['cname'] ?></option>
											<?php
											}else{
											?>
												<option value="<?php echo $info['cname'] ?>"<?php if($r['yyzxy']==$info['cname']){ echo ' selected="selected"'; }elseif(!admin::check_roid('|14,')){ echo ' disabled="disabled"'; } ?>><?php echo $info['cname'] ?></option>
											<?php
											}
										}
									}
								}
								?>
							</select>
							</div>
							<div class="col-sm-8"></div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">关键词：</label>
							<div class="col-sm-2"><input type="text" class="form-control" name="info[yykey]" value="<?php echo $r['yykey'] ?>" maxlength="50" /></div>
							<div class="col-sm-8"></div>
						</div>
						
						<?php if($action!='public_add'){ ?>

						<div class="form-group">
							<label class="col-sm-2 control-label">回访结果：</label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="info[hfjg]" value="<?php echo $r['yykey'] ?>" maxlength="100" />
							</div>
							<div class="col-sm-6"><span class="help-block">* 注：回访结果不能随时修改请认真填写</span></div>
						</div>
						<?php } ?>

						<?php
						if($r['jzremark']!=''){
						?>
						<div class="form-group">
							<label class="col-sm-2 control-label">接诊备注：</label>
							<div class="col-sm-6"><label class="control-label sc_label_tb02" style="text-align: left;"><?php echo $r['jzremark'] ?></label></div>
							<div class="col-sm-4"></div>
						</div>
						<?php
						}
						?>
						<div class="form-group">
							<label class="col-sm-2 control-label">备注：</label>
							<div class="col-sm-6"><textarea name="info[remark]" rows="5" class="form-control"><?php echo $r['remark'] ?></textarea></div>
							<div class="col-sm-4"></div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label"></label>
							<div class="col-sm-4">
							<input type="hidden" name="ctrl" value="<?php echo $ctrl ?>" />
							<input type="hidden" name="info[cid]" id="recid" value="<?php echo $r['id'] ?>" />
							<?php if($action=='public_edit'){ ?>
							<button type="button" class="btn btn-warning sc_swbtn">历 史</button>&nbsp;
							<?php } ?>
							<button type="button" class="btn btn-info" onclick="history.back(-1)">返 回</button>&nbsp;
							<?php self::judge_role(2, $r) ?>
							</div>
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