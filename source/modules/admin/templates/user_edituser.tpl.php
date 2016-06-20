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
				<li class="active"><a><b class="blue">用户编辑</b></a></li>
			</ul>
			<div class="panel panel-default mt">
				<div class="panel-body">
					<form class="form-horizontal" role="form" name="form1" method="post" action="./?m=admin&c=user&a=<?php echo $action ?>&dosubmit=1">
						<div class="form-group">
							<label class="col-sm-2 control-label"><span class="label label-primary">用户信息</span></label>
							<div class="col-sm-4"><label class="checkbox" style="padding-left: 0px;"><span class="label label-warning sc_swbtn">展开</span></label></div>
							<div class="col-sm-6"></div>
						</div>
						<div class="sc_panel"<?php if(ROUTE_A=='public_edituser'){ echo ' style="display: none;"'; } ?>>
						<div class="form-group">
							<label class="col-sm-2 control-label">登录名：</label>
							<div class="col-sm-4"><input type="text" class="form-control" name="info[username]" value="<?php echo $r['username'] ?>"<?php if(ROUTE_A=='public_edituser'){ echo ' readonly="readonly"'; } ?> /></div>
							<div class="col-sm-6"></div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">生效：</label>
							<div class="col-sm-4"><label class="checkbox"><input type="checkbox" name="info[useing]" value="true"<?php if($r['useing']==1){ echo ' checked="checked"'; } ?> />&nbsp;</label></div>
							<div class="col-sm-6"></div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">部门：</label>
							<div class="col-sm-4">
								<select class="form-control" name="info[depart]">
									<?php 
									if(is_array($infos)){
										foreach($infos as $info){
										if($r['depart']==$info['cname']){
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
							</div>
							<div class="col-sm-6"></div>
						</div>
						<div class="form-group hidden">
							<label class="col-sm-2 control-label">隐密码：</label>
							<div class="col-sm-4"><input type="password" class="form-control" name="hid_password" autocomplete="off" value="" /></div>
							<div class="col-sm-6"></div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">新密码：</label>
							<div class="col-sm-4"><input type="password" class="form-control" name="info[password]" autocomplete="off" value=""<?php if(ROUTE_A=='public_adduser'){ echo ' required'; } ?> /></div>
							<div class="col-sm-6"></div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">确认密码：</label>
							<div class="col-sm-4"><input type="password" class="form-control" name="info[pwdconfirm]" autocomplete="off" value=""<?php if(ROUTE_A=='public_adduser'){ echo ' required'; } ?> /></div>
							<div class="col-sm-6"></div>
						</div>
						</div><!--sc_userinfo_panel-->
						<div class="form-group">
							<label class="col-sm-2 control-label"><span class="label label-primary">权限设置</span></label>
							<div class="col-sm-4"></div>
							<div class="col-sm-6"></div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">预约数据：</label>
							<div class="col-sm-10">
								<label class="radio-inline"><input name="purview[x11]" bd="[11]" type="radio" value="|11,"<?php if(in_array('|11', $purview)){ echo ' checked="checked"'; } ?> />查看(<font color="red">仅限自己</font>)</label>
								<label class="radio-inline"><input name="purview[x11]" bd="[12]" type="radio" value="|12,"<?php if(in_array('|12', $purview)){ echo ' checked="checked"'; } ?> />查看(<font color="red">所有人</font>)</label>&nbsp;
								<label class="checkbox-inline"><input name="purview[x13]" bd="[13]" type="checkbox" value="|13," group="group01"<?php if(in_array('|13', $purview)){ echo ' checked="checked"'; } ?> />修改(<font color="red">仅限自己</font>)</label>
								<label class="checkbox-inline"><input name="purview[x14]" bd="[14]" type="checkbox" value="|14," group="group01"<?php if(in_array('|14', $purview)){ echo ' checked="checked"'; } ?> />修改(<font color="red">所有人</font>)</label>
								<label class="checkbox-inline"><input name="purview[x15]" bd="[15]" type="checkbox" value="|15," group="group02"<?php if(in_array('|15', $purview)){ echo ' checked="checked"'; } ?> />删除(<font color="red">仅限自己</font>)</label>
								<label class="checkbox-inline"><input name="purview[x16]" bd="[16]" type="checkbox" value="|16," group="group02"<?php if(in_array('|16', $purview)){ echo ' checked="checked"'; } ?> />删除(<font color="red">所有人</font>)</label>
								<?php 
								$aroids=array();
								$aroids[]=array('rid'=>'17','txt'=>'录入');
								$aroids[]=array('rid'=>'18','txt'=>'接管');
								$aroids[]=array('rid'=>'19','txt'=>'回访');
								$aroids[]=array('rid'=>'');
								$aroids[]=array('rid'=>'110','txt'=>'历史编辑');
								$aroids[]=array('rid'=>'111','txt'=>'查看详细');
								foreach($aroids as $aroid){
									if(empty($aroid['rid'])){
										echo '<br />';
									}else{
										$chked = in_array('|'.$aroid['rid'], $purview) ? ' checked="checked"' : '';
										echo '<label class="checkbox-inline"><input name="purview[x'.$aroid['rid'].']" bd="['.$aroid['rid'].']" type="checkbox" value="|'.$aroid['rid'].',"'.$chked.' />'.$aroid['txt'].'</label>'."\n";
									}
								}
								?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">到院数据：</label>
							<div class="col-sm-10">
								<label class="radio-inline"><input name="purview[x21]" bd="[21]" type="radio" value="|21,"<?php if(in_array('|21', $purview)){ echo ' checked="checked"'; } ?> />查看(<font color="red">仅限自己</font>)</label>
								<label class="radio-inline"><input name="purview[x21]" bd="[22]" type="radio" value="|22,"<?php if(in_array('|22', $purview)){ echo ' checked="checked"'; } ?> />查看(<font color="red">所有人</font>)</label>&nbsp;
								<?php 
								$aroids=array();
								$aroids[]=array('rid'=>'23','txt'=>'录入/修改');
								$aroids[]=array('rid'=>'24','txt'=>'删除');
								$aroids[]=array('rid'=>'25','txt'=>'查看实际消费');
								$aroids[]=array('rid'=>'26','txt'=>'录入/修改实际消费');
								foreach($aroids as $aroid){
									if(empty($aroid['rid'])){
										echo '<br />';
									}else{
										$chked = in_array('|'.$aroid['rid'], $purview) ? ' checked="checked"' : '';
										echo '<label class="checkbox-inline"><input name="purview[x'.$aroid['rid'].']" bd="['.$aroid['rid'].']" type="checkbox" value="|'.$aroid['rid'].',"'.$chked.' />'.$aroid['txt'].'</label>'."\n";
									}
								}
								?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">综合数据：</label>
							<div class="col-sm-10">
								<?php 
								$aroids=array();
								$aroids[]=array('rid'=>'31','txt'=>'查看推广费用');
								$aroids[]=array('rid'=>'32','txt'=>'录入/修改/删除推广费用');
								$aroids[]=array('rid'=>'33','txt'=>'查看咨询员数据');
								$aroids[]=array('rid'=>'34','txt'=>'录入/修改/删除咨询员数据');
								foreach($aroids as $aroid){
									if(empty($aroid['rid'])){
										echo '<br />';
									}else{
										$chked = in_array('|'.$aroid['rid'], $purview) ? ' checked="checked"' : '';
										echo '<label class="checkbox-inline"><input name="purview[x'.$aroid['rid'].']" bd="['.$aroid['rid'].']" type="checkbox" value="|'.$aroid['rid'].',"'.$chked.' />'.$aroid['txt'].'</label>'."\n";
									}
								}
								?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">统计分析：</label>
							<div class="col-sm-10">
								<?php 
								$aroids=array();
								$aroids[]=array('rid'=>'41','txt'=>'到院统计');
								$aroids[]=array('rid'=>'42','txt'=>'预约＆有效对话');
								$aroids[]=array('rid'=>'43','txt'=>'推广费用');
								/*$aroids[]=array('rid'=>'44','txt'=>'来路统计');*/
								$aroids[]=array('rid'=>'45','txt'=>'时段统计');
								$aroids[]=array('rid'=>'46','txt'=>'途径统计');
								$aroids[]=array('rid'=>'47','txt'=>'病种统计');
								$aroids[]=array('rid'=>'48','txt'=>'到院地区分布');
								$aroids[]=array('rid'=>'49','txt'=>'咨询员数据');
								$aroids[]=array('rid'=>'');
								$aroids[]=array('rid'=>'410','txt'=>'部门数据');
								$aroids[]=array('rid'=>'411','txt'=>'年度综合数据');
								foreach($aroids as $aroid){
									if(empty($aroid['rid'])){
										echo '<br />';
									}else{
										$chked = in_array('|'.$aroid['rid'], $purview) ? ' checked="checked"' : '';
										echo '<label class="checkbox-inline"><input name="purview[x'.$aroid['rid'].']" bd="['.$aroid['rid'].']" type="checkbox" value="|'.$aroid['rid'].',"'.$chked.' />'.$aroid['txt'].'</label>'."\n";
									}
								}
								?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">排班表：</label>
							<div class="col-sm-10">
								<?php 
								$aroids=array();
								$aroids[]=array('rid'=>'51','txt'=>'查看排班表');
								$aroids[]=array('rid'=>'52','txt'=>'录入/修改排班表');
								foreach($aroids as $aroid){
									if(empty($aroid['rid'])){
										echo '<br />';
									}else{
										$chked = in_array('|'.$aroid['rid'], $purview) ? ' checked="checked"' : '';
										echo '<label class="checkbox-inline"><input name="purview[x'.$aroid['rid'].']" bd="['.$aroid['rid'].']" type="checkbox" value="|'.$aroid['rid'].',"'.$chked.' />'.$aroid['txt'].'</label>'."\n";
									}
								}
								?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">用户管理：</label>
							<div class="col-sm-10">
								<?php 
								$aroids=array();
								$aroids[]=array('rid'=>'61','txt'=>'修改密码');
								$aroids[]=array('rid'=>'62','txt'=>'添加/编辑用户');
								foreach($aroids as $aroid){
									if(empty($aroid['rid'])){
										echo '<br />';
									}else{
										$chked = in_array('|'.$aroid['rid'], $purview) ? ' checked="checked"' : '';
										echo '<label class="checkbox-inline"><input name="purview[x'.$aroid['rid'].']" bd="['.$aroid['rid'].']" type="checkbox" value="|'.$aroid['rid'].',"'.$chked.' />'.$aroid['txt'].'</label>'."\n";
									}
								}
								?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">统计报表：</label>
							<div class="col-sm-10">
								<?php 
								$aroids=array();
								$aroids[]=array('rid'=>'A1','txt'=>'咨询员途径报表');
								$aroids[]=array('rid'=>'A2','txt'=>'咨询员报表');
								$aroids[]=array('rid'=>'A3','txt'=>'咨询途径报表');
								$aroids[]=array('rid'=>'A4','txt'=>'病种统计报表');
								$aroids[]=array('rid'=>'A5','txt'=>'到院数据报表');
								$aroids[]=array('rid'=>'A6','txt'=>'增长比报表');
								foreach($aroids as $aroid){
									if(empty($aroid['rid'])){
										echo '<br />';
									}else{
										$chked = in_array('|'.$aroid['rid'], $purview) ? ' checked="checked"' : '';
										echo '<label class="checkbox-inline"><input name="purview[x'.$aroid['rid'].']" bd="['.$aroid['rid'].']" type="checkbox" value="|'.$aroid['rid'].',"'.$chked.' />'.$aroid['txt'].'</label>'."\n";
									}
								}
								?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">系统管理：</label>
							<div class="col-sm-10">
								<?php 
								$aroids=array();
								
								$aroids[]=array('rid'=>'71','txt'=>'常量设置');
								$aroids[]=array('rid'=>'72','txt'=>'邮箱设置');
								$aroids[]=array('rid'=>'73','txt'=>'部门设置');
								$aroids[]=array('rid'=>'74','txt'=>'排班表设置');
								$aroids[]=array('rid'=>'75','txt'=>'数据库操作');
								$aroids[]=array('rid'=>'76','txt'=>'数据安全监控');
								$aroids[]=array('rid'=>'77','txt'=>'用户登录日志');
								$aroids[]=array('rid'=>'');
								$aroids[]=array('rid'=>'78','txt'=>'专家设置');
								$aroids[]=array('rid'=>'79','txt'=>'咨询员设置');
								$aroids[]=array('rid'=>'710','txt'=>'咨询途径设置');
								$aroids[]=array('rid'=>'711','txt'=>'病种校验');
								$aroids[]=array('rid'=>'712','txt'=>'地区校验');
								$aroids[]=array('rid'=>'713','txt'=>'来院方式设置');
								$aroids[]=array('rid'=>'714','txt'=>'就诊情况设置');
								$aroids[]=array('rid'=>'715','txt'=>'推广消费设置');
								foreach($aroids as $aroid){
									if(empty($aroid['rid'])){
										echo '<br />';
									}else{
										$chked = in_array('|'.$aroid['rid'], $purview) ? ' checked="checked"' : '';
										echo '<label class="checkbox-inline"><input name="purview[x'.$aroid['rid'].']" bd="['.$aroid['rid'].']" type="checkbox" value="|'.$aroid['rid'].',"'.$chked.' />'.$aroid['txt'].'</label>'."\n";
									}
								}
								?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">数据安全：</label>
							<div class="col-sm-10">
								<?php 
								$aroids=array();
								$aroids[]=array('rid'=>'81','txt'=>'显示电话');
								$aroids[]=array('rid'=>'82','txt'=>'显示业绩数据');
								$aroids[]=array('rid'=>'83','txt'=>'导出预约数据');
								$aroids[]=array('rid'=>'84','txt'=>'导出到院数据');
								$aroids[]=array('rid'=>'85','txt'=>'导出网络数据');
								$aroids[]=array('rid'=>'86','txt'=>'发送预计到院邮件');
								foreach($aroids as $aroid){
									if(empty($aroid['rid'])){
										echo '<br />';
									}else{
										$chked = in_array('|'.$aroid['rid'], $purview) ? ' checked="checked"' : '';
										echo '<label class="checkbox-inline"><input name="purview[x'.$aroid['rid'].']" bd="['.$aroid['rid'].']" type="checkbox" value="|'.$aroid['rid'].',"'.$chked.' />'.$aroid['txt'].'</label>'."\n";
									}
								}
								?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label"></label>
							<div class="col-sm-4">
								<input type="hidden" name="info[cid]" value="<?php echo $userid ?>" />
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