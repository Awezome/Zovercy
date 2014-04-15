<?php
/**
 * Created by PhpStorm.
 * User: Awezome
 * Date: 4/4/14
 * Time: 1:57 PM
 */
include 'ConnectionInterface.php';
class Connection implements ConnectionInterface {
    private $con=NULL;
    private $table;
    private $where;
    private $blind;
    private $query;

    public function setConnector(ConnectorInterface $connector) {
        $this->con=$connector->connect();
    }

    public function table($table) {
        $this->table=$table;
        return $this;
    }

    public function where($where=1, array $blind=array()) {
        $this->where=$where;
        $this->blind=$blind;
        return $this;
    }

    public function find(array $data=array('*')) {
        $str=implode(',', $data);
        $this->query='select '.$str.' from '.$this->table.' where '.$this->where;
        $stmt=$this->executeQuery();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findAll(array $data=array('*')) {
        $str=implode(',', $data);
        $this->query='select '.$str.' from '.$this->table.' where '.$this->where;
        $stmt=$this->executeQuery();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert(array $data) {
        $column=implode(',', array_keys($data));
        $this->blind=array_values($data);
        $mark=self::buildMark(count($data)); // build ? marks .
        $this->query='insert into '.$this->table.' ('.$column.') values ('.$mark.')';
        $stmt=$this->executeQuery();
        return $this->con->lastInsertId();
    }

    public function update(array $data) {
        $arra=array_keys($data);
        $sql=implode('=?,',$arra).'=?';
        $this->blind=array_merge(array_values($data),$this->blind);
        $this->query='update '.$this->table.' set '.$sql.' where '.$this->where;
        $stmt=$this->executeQuery();
        return $stmt->rowCount();
    }

    public function delete() {
        $this->query='delete from '.$this->table.$this->where;
        $stmt=$this->executeQuery();
        return $stmt->rowCount();
    }

    private function executeQuery() {
        if($this->query!='*'){
            p($this->query,"query");
            p($this->blind,"blind");
            $stmt=$this->con->prepare($this->query);
        }
        $stmt->execute($this->blind);
        return $stmt;
    }

    public function transaction(Closure $callback) {
        $this->beginTransaction();
        try {
            $result=$callback($this);
            $this->commit();
        } catch(Exception $e) {
            $this->rollBack();
            throw $e;
        }
        return $result;
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
}