<?php
define('IN_HISUNPHP', true);
define('SITE_ROOT', dirname(dirname(__FILE__)).'/');

class APP{
	static $CONFIG;
	private $db;

	function __construct(){
		$this->_define();
		include SITE_ROOT.'./config.inc.php';
		session_start();
		header('Content-Type:text/html;charset=utf-8');
		include SITE_ROOT.'HisunPHP/lib/function_global.php';
		self::$CONFIG=$CONFIG;
		self::$CONFIG['THEME']=array(
				'INDEX'=>$THEME,
				'ADMIN'=>'admin/view/',
			);

		$this->_class();
		$this->_magic();
		$this->_check();
		$this->db=new db();//链接数据库

	}

	function load_index($allow_array){
		$get=rewrite::run();//虚静态转换

		$ac=in_array($get[1],$allow_array)?$get[1]:'index';
		
		$op = isset($_GET['op'])?$_GET['op']:'default';
		
		//$lan=isset($_SESSION['lan'])?$_SESSION['lan']:'zh-cn';
		//include SITE_ROOT.'theme/language/'.$lan.'.php';
		
		global $gid;
		$C = new Cookie();
		$username=$C->get_cookie("username");
		$uid=$C->get_cookie('uid');
		$gid=$C->get_cookie('gid');
		if(!empty($uid)){
			$time=time();
			$this->db->table('user')->where("uid='$uid'")->update("last_logtime='$time'");
		}
		
		define('THIS_DIR',THIS_HOST.self::$CONFIG['THEME']['INDEX']);

		include SITE_ROOT.'./source/'.$ac.'.php';
		include SITE_ROOT.'./source/common.php';
		include SITE_ROOT.self::$CONFIG['THEME']['INDEX'].'header.html';
		include SITE_ROOT.self::$CONFIG['THEME']['INDEX'].$ac.'.html';
		include SITE_ROOT.self::$CONFIG['THEME']['INDEX'].'footer.html';		
	}

	function load_admin(){
		$ac = isset($_GET['ac'])?$_GET['ac']:'index';
		$op = isset($_GET['op'])?$_GET['op']:'default';
		//if(!in_array($ac,array('index','reg','indeximg','user_say','newmessage','logoup','agreelist','agreement','agreeshow','user','link','page','album','albumadd','tour','tourtype','touredit','tourneed','msnall','msnunread','msn','msnreply','message','messageedit','news','newsedit','newstype','file','login','tool')))
			//Jump('admin.php');

		global $gid;
		$C = new Cookie();
		$username=$C->get_cookie("username");
		$uid=$C->get_cookie('uid');
		$gid=$C->get_cookie('gid');
		
		if(!empty($uid)){			
			$time=time();
			$this->db->table('user')->where("uid='$uid'")->update("last_logtime='$time'");
		}
		
		include SITE_ROOT.'admin/language/zh-cn.php';

		define('THIS_DIR',THIS_HOST.self::$CONFIG['THEME']['ADMIN']);

		include SITE_ROOT.'./admin/'.$ac.'.php';
		include SITE_ROOT.self::$CONFIG['THEME']['ADMIN'].'header.html';
		include SITE_ROOT.self::$CONFIG['THEME']['ADMIN'].'sidebar.html';
		include SITE_ROOT.self::$CONFIG['THEME']['ADMIN'].$ac.'.html';
		include SITE_ROOT.self::$CONFIG['THEME']['ADMIN'].'footer.html';
	}

	private function _define(){
		date_default_timezone_set('PRC');//设置中国时区
		define('DEBUG_MODE',true);                //调试模式开关
		define('NOROBOT',false);                  //限制蜘蛛程序访问开关
		define('THIS_HOME',$_SERVER['HTTP_HOST']);
		define('THIS_HOST','http://'.THIS_HOME.dirname($_SERVER['SCRIPT_NAME']).'/');
	}

	private function _magic(){
		if(!get_magic_quotes_gpc()){
			$_GET = Str::cleanSql($_GET);
			$_POST = Str::cleanSql($_POST);
			//$_COOKIE = Str::cleanSql($_COOKIE);
		}
	}

	private function _class(){
		spl_autoload_register("self::_autoload");
	}

	static function _autoload($class_name) {
		$class_name=strtolower($class_name);
		$class_array=array();
		$class_array[]=SITE_ROOT.'HisunPHP/lib/class_'.$class_name.'.php';
		$class_array[]=SITE_ROOT.'HisunPHP/bas/class_'.$class_name.'.php';
		foreach($class_array as $class)
			if(is_file($class))
				include $class;
	}

	private function _check(){
		Debug();//错误报告
		GetRobot();//限制蜘蛛程序访问
	}
}

?>