<?php
/*
 * Class DB of MYSQL
 *
 * update : 2012-05-02
 *----------------------------------------------------------------------*
 * @author : ZYP            @time : 2012-01-16
 *----------------------------------------------------------------------*
 * Notes :
 *
 * $d = new db ();
 * $d -> table()->where()->selectone();
 * $d -> table()->where()->selectall();
 * $d -> table()->where()->selectcount();
 * $d -> table()->where()->selectgroup();
 * $d -> table()->where()->update();
 * $d -> table()->where()->delete();
 * $d -> table()->where()->insert();
 * $d -> sql(); //return a line of sql you just used , good for checking error
 *----------------------------------------------------------------------*
 */
if(!defined('IN_HISUNPHP'))	exit('Access Denied');

class db{
	private $db;
	private $tname;
	private $table;
	private $insertid;
	private $sql;
	private $config=array();

	function __construct(){
		$this->config=APP::$CONFIG['DB'];
		include_once SITE_ROOT.'HisunPHP/bas/class_mysql.php';
		$this->db=new MYSQL_DB();
		$this->db->connect($this->config['HOST'], $this->config['USER'], $this->config['PWD'], $this->config['NAME'], 0,$this->config['CHARSET'],TRUE);
		$this->db->query("set time_zone = '+8:00';");
		$this->tname=$this->config['TABLEPRE'];
	}

	public function table($tablename){
		$this->table=$this->tname.$tablename;
		return $this;
	}
	public function where($where=1){
		$this->where = $where;
		return $this;
	}
//-------------------------------------------------------------select
	public function selectone($what='*'){
		$this->sql = "select ".$what." from ".$this->table." where ".$this->where;
		return $this->db->fetch_first($this->sql);
	}
	public function selectall($what='*'){
		$this->sql = "select ".$what." from ".$this->table." where ".$this->where;
		return $this->db->fetch_all($this->sql);
	}
	public function selectgroup($what='*'){
		$this->sql= "select ".$what." from ".$this->table;
		return $this->db->fetch_group($this->sql);
	}
	public function selectcount($what='*'){
		$this->sql = "select count($what) from $this->table where $this->where";
		$query = $this->db->query($this->sql);
		$sum_arr=$this->db->fetch_array($query,MYSQL_NUM);
		return $sum_arr[0];
	}

//-------------------------------------------------------------update
	public function update($set){
		$this->sql="update ".$this->table." set ".$set." where ".$this->where;
		$this->db->query($this->sql);
	}
//-------------------------------------------------------------insert
	public function insert($value){
		$this->sql= "insert INTO ".$this->table.$value;
		$this->db->query($this->sql);
		$this->insertid=$this->db->insert_id();
	}
	public function _insertid(){
		return $this->insertid;
	}

//-------------------------------------------------------------delete
	public function delete(){
		$this->sql = "delete from ".$this->table." where ".$this->where;
		$this->db->query($this->sql);
	}

//-------------------------------------------------------------delete
	public function sql(){
		return $this->sql;
	}

}

?>
