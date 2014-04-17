<?php
/**
 * Created by PhpStorm.
 * User: Awezome
 * Date: 4/4/14
 * Time: 1:57 PM
 */

interface ExecutionInterface {
    public function findOne($data,$fetchType);
    public function findAll($data,$fetchType);

    public function count(array $data);
    public function update(array $data);
    public function save(array $data);
    public function delete();

    public function transaction(Closure $callback);
    public function query($sql,array $blind);
}