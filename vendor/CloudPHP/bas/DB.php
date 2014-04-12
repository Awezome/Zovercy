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

    private $table;
    private $where='';
    private $query=null;
    private $sql;
    private static $config = array();
    private $link = null;
    private static $_instance=null;

    private function __construct() {
        $this->connect(self::$config['HOST'], self::$config['USER'], self::$config['PWD'], self::$config['NAME'], self::$config['CHARSET'], self::$config['TIMEZONE']);
    }

    public function __destruct() {}

    private function __clone() {}

    private function __sleep() {}

    public static function getInstance($config) {
        if (!(self::$_instance instanceof self)) {
            self::$config = $config;
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function table($tablename) {
        $this->table = self::$config['TABLEPRE'] .'_'. $tablename;
        return $this;
    }

    public function where($where='1=1') {
        $this->where ='  where  '.$where;
        return $this;
    }

    public function findOne($what='*') {
        $this->sqlSelect($what);
        $this->query();
        return $this->fetchArray();
    }

    public function find($what='*') {
        $this->sqlSelect($what);
        return $this->fetchAll();
    }

    public function findGroup($what = '*') {
        $this->sqlSelect($what);
        return $this->fetchGroup();
    }

    private function sqlSelect($what='*'){
         $this->sql = 'select '.$what.'  from '.$this->table.$this->where;
    }
    
    public function count($what = '*') {
        $this->sqlSelect("count($what)");
        $this->query();
        $sum_arr = $this->fetchArray(MYSQL_NUM);
        return $sum_arr[0];
    }

    public function update($set) {
        if (is_array($set)) {
            $sql_temp = '';
            foreach ($set as $key => $value) {
                $sql_temp.=$key . "='" . $value . "',";
            }
            $sql = substr($sql_temp, 0, -1);
        } else {
            $sql = $set;
        }
        $this->sql = 'update ' . $this->table . ' set ' . $sql . $this->where;
        $this->query();
    }

    public function save($values) {
        if (is_array($values)) {
            $sql_key_temp = '';
            $sql_value_temp = '';
            foreach ($values as $key => $value) {
                $sql_key_temp.=$key . ',';
                $sql_value_temp.="'" . $value . "',";
            }
            $sql_key = substr($sql_key_temp, 0, -1);
            $sql_value = substr($sql_value_temp, 0, -1);

            $sql = '(' . $sql_key . ') values (' . $sql_value . ')';
        } else {
            $sql = $values;
        }
        $this->sql = 'insert into ' . $this->table . $sql;
        $this->query();
    }

    public function saveId() {
        $this->sql='select last_insert_id()';
        return ($id = mysql_insert_id($this->link)) >= 0 ? $id : $this->result($this->query(), 0);
    }

    public function delete() {
        $this->sql = 'delete from ' . $this->table . $this->where;
        $this->query();
    }

    public function sql() {
        return $this->sql;
    }

    public function close() {
        return mysql_close($this->link);
    }

    private function connect($dbhost, $dbuser, $dbpw, $dbname, $dbcharset = 'utf8', $timezone = '+8:00', $pconnect = 0) {
        if ($pconnect) {
            $this->link = mysql_pconnect($dbhost, $dbuser, $dbpw);
        } else {
            $this->link = mysql_connect($dbhost, $dbuser, $dbpw);
        }
        if (!$this->link) {
            $this->halt('Can not connect to MySQL server');
        }
        mysql_query("set character_set_connection=" . $dbcharset . ", character_set_results=" . $dbcharset . ", character_set_client=binary", $this->link);
        mysql_query("set sql_mode=''", $this->link);
        mysql_query("set time_zone = '" . $timezone . "';");
        mysql_select_db($dbname, $this->link);
    }

    private function fetchArray($result_type = MYSQL_ASSOC) {
        return mysql_fetch_array($this->query, $result_type);
    }

    private function fetchAll() {
        $rearr = array();
        $this->query();
        while ($re = $this->fetchArray()) {
            $rearr[] = $re;
        }
        return $rearr;
    }

    private function fetchGroup() {
        $res = $this->fetchAll();
        $rearr = array();
        foreach ($res as $re) {
            $rearr[$re['key']] = $re['value'];
        }
        return $rearr;
    }

    private function query() {
        if (!($this->query = mysql_query($this->sql, $this->link))) {
            $this->halt('MySQL Query Error', $this->sql);
        }
    }

    private function result($query, $row) {
        $query = mysql_result($query, $row);
        return $query;
    }

    private function error() {
        return (($this->link) ? mysql_error($this->link) : mysql_error()); //返回mysql错误描述
    }

    private function errno() {
        return intval(($this->link) ? mysql_errno($this->link) : mysql_errno()); //返回mysql错误编号
    }

    private function halt($message = '', $sql = '') {
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
        Func::errorMessage($note);
    }

}
