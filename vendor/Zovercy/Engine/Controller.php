<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Controller
 *
 * @author YunPeng
 */
class Controller {

    public function __construct() {
    }

    public function __destruct() {
    }

    protected function json($str) {
        echo json_encode($str);
    }
}
