<?php

class index extends Controller {
    public function auto() {
       $data=array(
            'hello' => 'hello world',
        );        
        View::page('index',$data);
    }
}
