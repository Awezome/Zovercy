<?php
/**
 * Created by PhpStorm.
 * User: Awezome
 * Date: 4/4/14
 * Time: 1:57 PM
 */

interface ConnectionInterface {
    public function find(array $data=array('*'));
    public function findAll(array $data=array('*'));

    public function update(array $data);
    public function insert(array $data);
    public function delete();

    public function transaction(Closure $callback);
}