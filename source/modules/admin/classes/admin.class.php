<?php
defined('IN_SYS') or exit('No permission resources.');
$session_storage = 'session_'.pc_base::load_config('system','session_storage');
pc_base::load_sys_class($session_storage);
if(param::get_cookie('sys_lang')) {
	define('SYS_STYLE',param::get_cookie('sys_lang'));
} else {
	define('SYS_STYLE','zh-cn');
}
//定义在后台
define('IN_ADMIN',true);
class admin {
	public static $userid;
	public static $username;
	public static $purview;
	public static $sitename;
	public static $admin_super;
	
	public function __construct() {
		self::check_admin();
		if(!module_exists(ROUTE_M)) showmessdialog('此模块未安装或已禁用！', 300, HTTP_REFERER, 'noajax');
		self::manage_log();
		self::check_ip();
		self::lock_screen();
		self::check_hash();
		if(pc_base::load_config('system','admin_url') && $_SERVER["HTTP_HOST"]!= pc_base::load_config('system','admin_url')) {
			Header("http/1.1 403 Forbidden");
			exit('No permission resources.');
		}
	}
	
	/**
	 * 判断用户是否已经登陆
	 */
	final public static function check_admin() {
		if(ROUTE_M =='admin' && ROUTE_C =='webctrl' && in_array(ROUTE_A, array('login', 'public_card'))) {
			return true;
		} else {
			if(!$_SESSION['ctrl_userid']){//用SESSION会话时间控制减少验次数
				$admin_userid = param::get_cookie('admin_userid');
				$admin_username = param::get_cookie('admin_username');
				//$admin_purview = param::get_cookie('admin_purview');
				$admin_purview = true;

				if(!$admin_userid || !$admin_username || !$admin_purview){
					if($_GET['follow']=='webctrl'){
						showmessdialog('请先登录后台管理', 300, './?m=admin&c=index&a=webctrl', 'noajax');
					}else{
						showmessdialog('请先登录后台管理', 300, APP_PATH.'?session=0', 'noajax');
					}
				}
				
				$admindb=pc_base::load_model('admin_model');
				$r = $admindb->get_one(array('username'=>$admin_username, 'userid'=>$admin_userid));
				if(!$r) showmessdialog('您还没有登录',300,'./?m=admin&c=webctrl&a=login','noajax');

				if(param::get_cookie('admin_token')!=md5($r['username'].date('Y-m-d',SYS_TIME).$r['encrypt'])){
					showmessdialog('您还没有登录',300,'./?m=admin&c=webctrl&a=login','noajax'); //防止cookies伪造
				}
				//重构SESSION
				$_SESSION['ctrl_userid'] = $r['userid'];
			}
		}
		self::get_purview();
	}
	
	/**
	 * 获取用户权限
	 */
	final public static function get_purview() {
		if(ROUTE_M =='admin' && ROUTE_C =='webctrl' && in_array(ROUTE_A, array('login'))) return true;
		self::$userid = $_SESSION['ctrl_userid'];

		//self::$sitename = param::get_cookie('sys_name');
		//self::$userid = param::get_cookie('admin_userid');
		self::$username = param::get_cookie('admin_username');

		$admindb=pc_base::load_model('admin_model');
		$r = $admindb->get_one(array('username'=>self::$username, 'userid'=>self::$userid));
		if(!$r) showmessdialog('您还没有登录',300,'./?m=admin&c=webctrl&a=login','noajax');
		self::$purview = $r['purview'];
		
		$sitedb=pc_base::load_model('site_model');
		$s = $sitedb->get_one(array('id'=>1));
		self::$sitename = $s['sitetitle'];
		self::$admin_super = pc_base::load_config('system','admin_super');
	}
	
	/**
	 * 加载后台模板
	 * @param string $file 文件名
	 * @param string $m 模型名
	 */
	final public static function admin_tpl($file, $m = '') {
		$m = empty($m) ? ROUTE_M : $m;
		if(empty($m)) return false;
		return PC_PATH.'modules'.DIRECTORY_SEPARATOR.$m.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.$file.'.tpl.php';
	}
	
	/**
	 * 按父ID查找菜单子项
	 * @param integer $parentid   父菜单ID  
	 * @param integer $with_self  是否包括他自己
	 */
	final public static function admin_menu($parentid, $with_self = 0) {
		$parentid = intval($parentid);
		$menudb = pc_base::load_model('menu_model');
		$where = array('parentid'=>$parentid,'display'=>1);
		
		//echo json_encode($where);
		$result = $menudb->select($where,'*',1000,'listorder ASC');
		if($with_self) {
			$result2[] = $menudb->get_one(array('id'=>$parentid));
			$result = array_merge($result2,$result);
		}
		//权限检查
		if($_SESSION['userid'] == 1) return $result;
		
		return $result;
		
		$array = array();
		/*$privdb = pc_base::load_model('admin_role_priv_model');
		$siteid = param::get_cookie('siteid');
		foreach($result as $v) {
			$action = $v['a'];
			if(preg_match('/^public_/',$action)) {
				$array[] = $v;
			} else {
				if(preg_match('/^ajax_([a-z]+)_/',$action,$_match)) $action = $_match[1];
				$r = $privdb->get_one(array('m'=>$v['m'],'c'=>$v['c'],'a'=>$action,'roleid'=>$_SESSION['roleid'],'siteid'=>$siteid));
				if($r) $array[] = $v;
			}
		}*/
		return $array;
	}
	/**
	 * 获取菜单 头部菜单导航
	 * 
	 * @param $parentid 菜单id
	 */
	final public static function submenu($parentid = '', $big_menu = false) {
		if(empty($parentid)) {
			$menudb = pc_base::load_model('menu_model');
			$r = $menudb->get_one(array('m'=>ROUTE_M,'c'=>ROUTE_C,'a'=>ROUTE_A));
			$parentid = $_GET['menuid'] = $r['id'];
		}
		$array = self::admin_menu($parentid,1);
		
		$numbers = count($array);
		if($numbers==1 && !$big_menu) return '';
		$string = '';
		$pc_hash = $_SESSION['pc_hash'];
		foreach($array as $_value) {
			if (!isset($_GET['s'])) {
				$classname = ROUTE_M == $_value['m'] && ROUTE_C == $_value['c'] && ROUTE_A == $_value['a'] && empty($_value['data']) ? ' class="active"' : '';
			} else {
				$_s = !empty($_value['data']) ? str_replace('=', '', strstr($_value['data'], '=')) : '';
				$classname = ROUTE_M == $_value['m'] && ROUTE_C == $_value['c'] && ROUTE_A == $_value['a'] && $_GET['s'] == $_s ? ' class="active"' : '';
			}
			if($_value['parentid'] == 0 || $_value['m']=='') continue;
			
			$param='';
			if(!empty($_value['data'])){
				$param='&'.$_value['data'];
			}
			$bwroid=false;
			$aroids=explode(',',$_value['roid']);
			foreach($aroids as $roid) {
				$bwroid=$bwroid||self::check_roid('|'.$roid.',');
			}
			if($_value['roid']=='0' || $bwroid){
				$string .= '<li'.$classname.'><a href="?m='.$_value['m'].'&c='.$_value['c'].'&a='.$_value['a'].$param.'">'.$_value['name'].'</a></li>';
			}
		}
		return $string;
	}
	/**
	 * 当前位置
	 * 
	 * @param $id 菜单id
	 */
	final public static function current_pos($id) {
		$menudb = pc_base::load_model('menu_model');
		$r =$menudb->get_one(array('id'=>$id),'id,name,parentid');
		$str = '';
		if($r['parentid']) {
			$str = self::current_pos($r['parentid']);
		}
		return $str.L($r['name']).' > ';
	}
	
	/**
	 * 获取当前的站点ID
	 */
	final public static function get_siteid() {
		return get_siteid();
	}
	
	/**
	 * 获取当前站点信息
	 * @param integer $siteid 站点ID号，为空时取当前站点的信息
	 * @return array
	 */
	final public static function get_siteinfo($siteid = '') {
		if ($siteid == '') $siteid = self::get_siteid();
		if (empty($siteid)) return false;
		$sites = pc_base::load_app_class('sites', 'admin');
		return $sites->get_by_id($siteid);
	}
	
	final public static function return_siteid() {
		$sites = pc_base::load_app_class('sites', 'admin');
		$siteid = explode(',',$sites->get_role_siteid($_SESSION['roleid']));
		return current($siteid);
	}
	
	
	/**
	 * 权限判断
	 */
	final public static function check_roid($roid) {
		if(self::$userid==1) return true;
		if(!self::$purview) return false;
		if(self::$purview=='') return false;
		if(strstr(self::$purview,$roid)) return true;
	}

	/**
	 * 权限判断
	 */
	final public static function check_priv() {
		if(ROUTE_M =='admin' && ROUTE_C =='index' && in_array(ROUTE_A, array('webctrl', 'init', 'public_card'))) return true;
		if($_SESSION['roleid'] == 1) return true;
		$siteid = param::get_cookie('siteid');
		$action = ROUTE_A;
		$privdb = pc_base::load_model('admin_role_priv_model');
		if(preg_match('/^public_/',ROUTE_A)) return true;
		if(preg_match('/^ajax_([a-z]+)_/',ROUTE_A,$_match)) {
			$action = $_match[1];
		}
		$r =$privdb->get_one(array('m'=>ROUTE_M,'c'=>ROUTE_C,'a'=>$action,'roleid'=>$_SESSION['roleid'],'siteid'=>$siteid));
		if(!$r) showmessage('您没有权限操作该项','blank');
	}

	/**
	 * 
	 * 记录日志 
	 */
	final private function manage_log() {
		//判断是否记录
		$setconfig = pc_base::load_config('system');
		extract($setconfig);
 		if($admin_log==1){
 			$action = ROUTE_A;
 			if(strchr($action,'delete') || ROUTE_C=='sysm' || ROUTE_C=='user') {
				$ip = ip();
				$log = pc_base::load_model('log_model');
				$username = self::$username;
				$userid = isset($_SESSION['userid']) ? $_SESSION['userid'] : '';
				$time = date('Y-m-d H-i-s',SYS_TIME);
				$url = '?m='.ROUTE_M.'&c='.ROUTE_C.'&a='.ROUTE_A;
				$ptdata = $_SERVER['REQUEST_URI']."\n".urldecode(file_get_contents("php://input"));//日志增强$GLOBALS['HTTP_RAW_POST_DATA'];//$_SERVER['REQUEST_URI']
				$log->insert(array('module'=>ROUTE_M,'username'=>$username,'userid'=>$userid,'action'=>ROUTE_C, 'querystring'=>$url, 'data'=>$ptdata,'time'=>$time,'ip'=>$ip));
			}else {
				return false;
			}
	  	}
	}
	
	/**
	 * 
	 * 后台IP禁止判断 ...
	 */
	final private function check_ip(){
		//$this->ipbanned = pc_base::load_model('ipbanned_model');
		//$this->ipbanned->check_ip();
 	}
 	/**
 	 * 检查锁屏状态
 	 */
	final private function lock_screen() {
		/*if(isset($_SESSION['lock_screen']) && $_SESSION['lock_screen']==1) {
			if(preg_match('/^public_/', ROUTE_A) || (ROUTE_M == 'content' && ROUTE_C == 'create_html') || (ROUTE_M == 'release') || (ROUTE_A == 'login') || (ROUTE_M == 'search' && ROUTE_C == 'search_admin' && ROUTE_A=='createindex')) return true;
			showmessage(L('admin_login'),'./?m=admin&c=index&a=webctrl');
		}*/
	}

	/**
 	 * 检查hash值，验证用户数据安全性
 	 */
	final private function check_hash() {
		/*if(ROUTE_M =='admin' && ROUTE_C =='webctrl' || in_array(ROUTE_A, array('login'))) {
			return true;
		}
		$pc_hash=param::get_cookie('pc_hash');
		if(isset($_GET['pc_hash']) && $pc_hash != '' && $pc_hash == $_GET['pc_hash']) {
			return true;
		} elseif(isset($_POST['pc_hash']) && $pc_hash != '' && $pc_hash == $_POST['pc_hash']) {
			return true;
		} else {
			showmessdialog('[hash]数据验证失败', 300, HTTP_REFERER, 'noajax');
		}*/
	}

	/**
	 * 后台信息列表模板
	 * @param string $id 被选中的模板名称
	 * @param string $str form表单中的属性名
	 */
	final public function admin_list_template($id = '', $str = '') {
		$templatedir = PC_PATH.DIRECTORY_SEPARATOR.'modules'.DIRECTORY_SEPARATOR.'content'.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR;
		$pre = 'content_list';
		$templates = glob($templatedir.$pre.'*.tpl.php');
		if(empty($templates)) return false;
		$files = @array_map('basename', $templates);
		$templates = array();
		if(is_array($files)) {
			foreach($files as $file) {
				$key = substr($file, 0, -8);
				$templates[$key] = $file;
			}
		}
		ksort($templates);
		return form::select($templates, $id, $str,L('please_select'));
	}
}