<?php

/**
 * Created by PhpStorm.
 * User: Awezome
 * Date: 4/4/14
 * Time: 1:57 PM
 */
class Execution implements ExecutionInterface {
    private $con=NULL;
    private $table;
    private $where='';
    private $blind=array();
    private $sql='';
    private $showLog=FALSE;
    private $config=array();

    public function pod() {
        return $this->con;
    }

    public function __construct(ConnectorInterface $connector, array $config=array()) {
        $this->con=$connector->connect();
        $this->config=$config;
    }

    public function table($table) {
        $this->table=empty($this->config['prefix']) ? $table : $this->config['prefix'].'_'.$table;
        return $this;
    }

    public function where($where=1, array $blind=array()) {
        $this->where=' where '.$where;
        $this->blind=$blind;
        return $this;
    }

    public function find($data='*', $fetchType=PDO::FETCH_ASSOC) {
        $this->sql='select '.$data.' from '.$this->table.$this->where.' limit 0,1';
        $stmt=$this->executeQuery();
        return $stmt->fetch($fetchType);
    }

    public function fetch($data='*', $fetchType=PDO::FETCH_ASSOC) {
        return $this->find($data, $fetchType);
    }

    public function findOne($data='*', $fetchType=PDO::FETCH_ASSOC) {
        return $this->find($data, $fetchType);
    }

    public function findAll($data='*', $fetchType=PDO::FETCH_ASSOC) {
        $this->sql='select '.$data.' from '.$this->table.$this->where;
        $stmt=$this->executeQuery();
        return $stmt->fetchAll($fetchType);
    }

    public function fetchAll($data='*', $fetchType=PDO::FETCH_ASSOC) {
        return $this->findAll($data, $fetchType);
    }

    public function save(array $data) {
        $column=implode(',', array_keys($data));
        $this->blind=array_values($data);
        $mark=self::buildMark(count($data)); // build ? marks .
        $this->sql='insert into '.$this->table.' ('.$column.') values ('.$mark.')';
        $this->executeQuery();
        return $this->con->lastInsertId();
    }

    public function insert(array $data) {
        return $this->save($data);
    }

    public function update(array $data) {
        $arra=array_keys($data);
        $sql=implode('=?,', $arra).'=?';
        $this->blind=array_merge(array_values($data), $this->blind);
        $this->sql='update '.$this->table.' set '.$sql.$this->where;
        $stmt=$this->executeQuery();
        return $stmt->rowCount();
    }

    public function delete() {
        $this->sql='delete from '.$this->table.$this->where;
        $stmt=$this->executeQuery();
        return $stmt->rowCount();
    }

    public function count(array $data=array()) {
        /*
         * $this->sql='select count(*) from '.$this->table.$this->where;
        $stmt=$this->executeQuery();
        return $stmt->fetchColumn();
        to see :http://stackoverflow.com/questions/883365/row-count-with-pdo
        */
        $c=$this->find('count(*)', PDO::FETCH_NUM);
        return $c[0];
    }

    private function executeQuery() {
        if($this->sql!='*') {
            $stmt=$this->con->prepare($this->sql);
        }
        if($this->showLog) {
            $this->showLogDetail();
        }
        $stmt->execute($this->blind);
        $this->sql='';
        $this->where='';
        $this->blind=array();
        return $stmt;
    }

    public function query($sql, array $blind=array()) {
        //$letter=strtoupper(strstr(ltrim($sql),' ',true));
        $letter=strtoupper(substr(ltrim($sql), 0, 1));
        $this->sql=$sql;
        $this->blind=$blind;
        $stmt=$this->executeQuery();
        switch($letter) {
            case 'S':
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            case 'I':
                return $this->con->lastInsertId();
            case 'U':
            case 'D':
                return $stmt->rowCount();
            default:
                return;
        }
    }

    public function transaction(Closure $callback) {
        $this->beginTransaction();
        try {
            $result=$callback($this);
            $this->commit();
            return $result;
        } catch(Exception $e) {
            $this->rollBack();
            echo $e->getMessage();
        }
    }

    public function log($b) {
        $this->showLog=$b==TRUE ? TRUE : FALSE;
    }

    private static function buildMark($size) {
        $count=$size-1;
        $str='';
        for($i=0; $i<$count; $i++) {
            $str.='?,';
        }
        $str.='?';
        return $str;
    }

    private function beginTransaction() {
        return $this->con->beginTransaction();
    }

    private function commit() {
        return $this->con->commit();
    }

    private function rollback() {
        return $this->con->rollback();
    }

    private function showLogDetail() {
        echo '<pre style="background:#eee;font-weight: 700;font-size: 14px">';
        echo '<span style="color:blue">sql : </span>';
        echo $this->sql;
        echo '<br /><span style="color:blue">blind : </span><br />';
        print_r($this->blind);
        echo '</pre>';
    }
}