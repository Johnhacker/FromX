<?php
/**
 *  index.php 入口
 *
 * @copyright			(C) 2015-2030 YANG QQ182860914
 * @license				
 */

define('RUN_PATH', dirname(__FILE__).DIRECTORY_SEPARATOR);
if($_GET['m']==''){
	exit();
}

include RUN_PATH.'source/base.php';

pc_base::creat_app();