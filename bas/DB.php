<?php

/*
 * Class DB of MYSQL
 *
 * update : 2012-05-02
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

    private $db;
    private $tname;
    private $table;
    private $insertid;
    private $sql;
    private $config = array();
    private static $_instance;

    private function __construct() {
        $this->config = APP::$CONFIG['DB'];
        $this->connect($this->config['HOST'], $this->config['USER'], $this->config['PWD'], $this->config['NAME'], 0, $this->config['CHARSET'], TRUE);
        $this->query("set time_zone = '+8:00';");
        $this->tname = $this->config['TABLEPRE'];
    }

    private function __clone() {
        
    }

    public static function getInstance() {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function table($tablename) {
        $this->table = $this->tname . $tablename;
        return $this;
    }

    public function where($where = 1) {
        $this->where = $where;
        return $this;
    }

//-------------------------------------------------------------select
    public function selectone($what = '*') {
        $this->sql = "select " . $what . " from " . $this->table . " where " . $this->where;
        return $this->fetch_first($this->sql);
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

//-------------------------------------------------------------update
    public function update($set) {
        $this->sql = "update " . $this->table . " set " . $set . " where " . $this->where;
        $this->query($this->sql);
    }

//-------------------------------------------------------------insert
    public function insert($value) {
        $this->sql = "insert INTO " . $this->table . $value;
        $this->query($this->sql);
        $this->insertid = $this->insert_id();
    }

    public function _insertid() {
        return $this->insertid;
    }

//-------------------------------------------------------------delete
    public function delete() {
        $this->sql = "delete from " . $this->table . " where " . $this->where;
        $this->query($this->sql);
    }

//-------------------------------------------------------------delete
    public function sql() {
        return $this->sql;
    }

//-------------------------------------------------------------old
    var $version = '';
    var $querynum = 0;
    var $link = null;
    var $result = null;

    private function connect($dbhost, $dbuser, $dbpw, $dbname = '', $pconnect = 0, $dbcharset, $halt = TRUE) {

        $func = empty($pconnect) ? 'mysql_connect' : 'mysql_pconnect';
        if (!$this->link = $func($dbhost, $dbuser, $dbpw, 1)) {
            $halt && $this->halt('Can not connect to MySQL server');
        } else {
            if ($this->version() > '4.1') {
                $serverset = 'NAMES ' . $dbcharset . ',CHARACTER SET ' . $dbcharset . ',character_set_connection=' . $dbcharset . ', character_set_results=' . $dbcharset . ', character_set_client=binary';
                $serverset .= $this->version() > '5.0.1' ? (',sql_mode=\'\'') : '';
                $serverset && mysql_query("SET $serverset", $this->link);
            }
            $dbname && mysql_select_db($dbname, $this->link); //没有传入$dbname则不执行mysql_select_db
        }
    }

    private function select_db($dbname) {
        return mysql_select_db($dbname, $this->link);
    }

    private function fetch_array($query, $result_type = MYSQL_ASSOC) {
        return mysql_fetch_array($query, $result_type);
    }

    private function fetch_first($sql) {
        return $this->fetch_array($this->query($sql)); //!!!!!
    }

    private function result_first($sql) {
        return $this->result($this->query($sql), 0);
    }

    private function fetch_all($sql) {
        $rearr = array();
        $this->query($sql);
        while ($re = $this->fetch_array($this->result))
            $rearr[] = $re;
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

    /**
     * 函数名：query 
     * 功  能：对sql的一些字符进行转义
     * 参  数：$sql：请求语句
      $type：请求类型控制 enum('UNBUFFERED','RETRY','')
     * 返回值：资源标识符
     */
    private function query($sql, $type = '') {

        $func = $type == 'UNBUFFERED' && @function_exists('mysql_unbuffered_query') ?
                'mysql_unbuffered_query' : 'mysql_query'; //mysql_unbuffered_query()查询的时候不产生结果集合的缓冲
        if (!($query = $func($sql, $this->link))) {
            if (in_array($this->errno(), array(2006, 2013)) && substr($type, 0, 5) != 'RETRY') {//'RETRY'用以说明是重新连接，只允许重连一次，否则显示错误信息
                $this->close();
                //require SITE_ROOT.'./config.inc.php';
                $this->connect($dbhost, $dbuser, $dbpw, $dbname, $pconnect, true, $dbcharset);
                return $this->query($sql, 'RETRY' . $type);
            } elseif ($type != 'SILENT' && substr($type, 5) != 'SILENT') {//$type设置为'SILENT'用以抑制错误信息**substr($type,5)表示输出下标5元素之后的串
                $this->halt('MySQL Query Error', $sql);
            }
        }

        $this->querynum++;
        $this->result = $query;
        return $query;
    }

    private function affected_rows() {
        return mysql_affected_rows($this->link);
    }

    private function error() {
        return (($this->link) ? mysql_error($this->link) : mysql_error()); //返回mysql错误描述
    }

    private function errno() {
        return intval(($this->link) ? mysql_errno($this->link) : mysql_errno()); //返回mysql错误编号
    }

    private function result($query, $row = 0) {
        $query = @mysql_result($query, $row);
        return $query;
    }

    private function num_rows($query) {
        $query = mysql_num_rows($query);
        return $query;
    }

    private function num_fields($query) {
        return mysql_num_fields($query);
    }

    private function free_result($query) {
        return mysql_free_result($query);
    }

    private function insert_id() {
        return ($id = mysql_insert_id($this->link)) >= 0 ? $id : $this->result($this->query("SELECT last_insert_id()"), 0); //注意赋值语句外括号的使用
    }

    private function fetch_row($query) {
        $query = mysql_fetch_row($query);
        return $query;
    }

    private function fetch_fields($query) {
        return mysql_fetch_field($query);
    }

    private function version() {
        if (empty($this->version)) {
            $this->version = mysql_get_server_info($this->link);
        }
        return $this->version;
    }

    private function close() {
        return mysql_close($this->link);
    }

    private function selector($what, $table, $where = '', $orderby = '', $order = '', $limit = '', $type = '') {
        $sql = 'SELECT ' . $what . ' FROM ' . tname($table);
        if ($where)
            $sql.=' WHERE ' . $where;
        if ($orderby)
            $sql.=' ORDER BY ' . $orderby . ' ' . $order;
        if ($limit)
            $sql.=' LIMIT ' . $limit;
        //echo $sql;
        return $this->query($sql, $type);
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
