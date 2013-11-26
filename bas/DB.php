<?php

/*
 * Class DB of MYSQL
 *
 * update : 2013-11-25
 * ----------------------------------------------------------------------*
 * @author : ZYP            @time : 2012-01-16
 * ----------------------------------------------------------------------*
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
 * ----------------------------------------------------------------------*
 */

class DB {
    private $tname;
    private $table;
    private $insertid;
    private $where;
    private $sql;
    private static $config = array();
    private $link = null;
    private static $_instance;

    private function __construct() {
        $this->connect(self::$config['HOST'], self::$config['USER'], self::$config['PWD'], self::$config['NAME'], self::$config['CHARSET'],self::$config['TIMEZONE']);
    }
    
    public function __destruct() {}

    private function __clone() {}
    
    private function __sleep() {}

    public static function getInstance($config) {
        if (!(self::$_instance instanceof self)) {
            self::$config =$config;
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function table($tablename) {
        $this->table = self::$config['TABLEPRE'] . $tablename;
        return $this;
    }

    public function where($where = 1) {
        $this->where = $where;
        return $this;
    }

    public function selectone($what = '*') {
        $this->sql = "select " . $what . " from " . $this->table . " where " . $this->where;
        return $this->fetch_array($this->query($this->sql));
    }

    public function selectall($what = '*') {
        $this->sql = "select " . $what . " from " . $this->table . " where " . $this->where;
        return $this->fetch_all($this->sql);
    }

    public function selectgroup($what = '*') {
        $this->sql = "select " . $what . " from " . $this->table;
        return $this->fetch_group($this->sql);
    }

    public function selectcount($what = '*') {
        $this->sql = "select count($what) from $this->table where $this->where";
        $query = $this->query($this->sql);
        $sum_arr = $this->fetch_array($query, MYSQL_NUM);
        return $sum_arr[0];
    }

    public function update($set) {
        $this->sql = "update " . $this->table . " set " . $set . " where " . $this->where;
        $this->query($this->sql);
    }

    public function insert($value) {
        $this->sql = "insert into " . $this->table . $value;
        $this->query($this->sql);
        $this->insertid = $this->insert_id();
    }

    public function _insertid() {
        return $this->insertid;
    }

    public function delete() {
        $this->sql = "delete from " . $this->table . " where " . $this->where;
        $this->query($this->sql);
    }

    public function sql() {
        return $this->sql;
    }

    public function close() {
        return mysql_close($this->link);
    }

    private function connect($dbhost, $dbuser, $dbpw, $dbname,$dbcharset='utf8', $timezone='+8:00',$pconnect = 0) {
        if($pconnect){
            $this->link = mysql_pconnect($dbhost, $dbuser, $dbpw);
        }else{
            $this->link = mysql_connect($dbhost, $dbuser, $dbpw);
        }
        if(!$this->link){
            $this->halt('Can not connect to MySQL server');
        }
        mysql_query("set character_set_connection=".$dbcharset.", character_set_results=".$dbcharset.", character_set_client=binary", $this->link);
        mysql_query("set sql_mode=''", $this->link);
        mysql_query("set time_zone = '".$timezone."';");
        mysql_select_db($dbname, $this->link);
    }

    private function fetch_array($query, $result_type = MYSQL_ASSOC) {
        return mysql_fetch_array($query, $result_type);
    }

    private function fetch_all($sql) {
        $rearr = array();
        $query=$this->query($sql);
        while ($re = $this->fetch_array( $query)){
            $rearr[] = $re;
        }
        return $rearr;
    }

    private function fetch_group($sql) {
        $res = $this->fetch_all($sql);
        $rearr = array();
        foreach ($res as $re) {
            $rearr[$re['key']] = $re['value'];
        }
        return $rearr;
    }

    private function query($sql) {
       if (!($query = mysql_query($sql, $this->link))) {
            $this->halt('MySQL Query Error', $sql);
        }
        return $query;
    }

    private function error() {
        return (($this->link) ? mysql_error($this->link) : mysql_error()); //返回mysql错误描述
    }

    private function errno() {
        return intval(($this->link) ? mysql_errno($this->link) : mysql_errno()); //返回mysql错误编号
    }

    private function halt($message = '', $sql = '') {
        header('Content-Type:text/html;');
        if ($message) {
            $note = '<b>Info: </b>' . $message . '<br />';
        }
        $note .= '<b>Errno: </b>' . $this->error() . '<br />';
        $note .= '<b>Error: </b>' . $this->errno() . '<br />';
        if ($sql) {
            $note .= '<b>SQL: </b>' . htmlspecialchars($sql) . '<br />';
        }
        $note .= '<b>Script: </b>' . $_SERVER['PHP_SELF'] . '<br />';
        $note .= '<b>Time: </b>' . date("Y-n-j H:i:s", time()) . '<br />';
        ErrorDiv($note);
    }
}
