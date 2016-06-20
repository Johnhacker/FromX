<?php
defined('IN_ADMIN') or exit('No permission resources.'); //模板
include PC_PATH.'modules'.DIRECTORY_SEPARATOR.'admin'.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'header.tpl.php';
?>
<div id="signpage">
	<div class="container">
		<form name="myform" class="form-signin" role="form" action="./?m=admin&c=webctrl&a=login&dosubmit=true" method="post">
			<div class="login_panel">
				<h2 class="sc_form-signin-heading">系统管理登录</h2>
				<input type="text" name="username" class="form-control i1" placeholder="UserName" required />
				<input type="password" name="password" class="form-control i2" placeholder="Password" required />
				
				<div class="input-group sc_form-signin_group01">
					<input type="text" name="code" class="form-control i3" placeholder="VerifyCode" required />
					<span class="input-group-btn">
						<span class="btn btn-default"><?php echo form::checkcode('code_img')?></span>
					</span>
				</div>
				
				<label class="checkbox"><input type="checkbox" value="remember-me" checked="checked" />记住密码</label>
				<button class="btn btn-lg btn-primary btn-block" name="submitis" type="submit">登录</button>
			</div>
		</form>
	</div>
	<!-- /container -->
</div>
<?php
include PC_PATH.'modules'.DIRECTORY_SEPARATOR.'admin'.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'footer.tpl.php';
?>