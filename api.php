<?php 
/**
 *  index.php API 入口
 *
 * @copyright			(C) 2015-2030 YANG
 * @license				
 */
define('RUN_PATH', dirname(__FILE__).DIRECTORY_SEPARATOR);
include RUN_PATH.'source/base.php';
$param = pc_base::load_sys_class('param');

$op = isset($_GET['op']) && trim($_GET['op']) ? trim($_GET['op']) : exit('Operation can not be empty');
if (isset($_GET['callback']) && !preg_match('/^[a-zA-Z_][a-zA-Z0-9_]+$/', $_GET['callback']))  unset($_GET['callback']);
if (!preg_match('/([^a-z_]+)/i',$op) && file_exists(RUN_PATH.'api/'.$op.'.php')) {
	include RUN_PATH.'api/'.$op.'.php';
} else {
	exit('API handler does not exist');
}
?>