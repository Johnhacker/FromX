<?php 
defined('IN_SYS') or exit('No permission resources.');
/**
 * 检查管理员名称
 * @param array $data 管理员数据
 */
function checkuserinfo($data) {
	if(!is_array($data)){
		showmessdialog('参数不完整！');return false;
	} elseif (!is_username($data['username'])){
		showmessdialog('用户名不合法！');return false;
	}
	return $data;
}
/**
 * 检查管理员密码合法性
 * @param string $password 密码
 */
function checkpasswd($password){
	if (!is_password($password)){
		return false;
	}
	return true;
}
?>