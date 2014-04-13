<?php

class index extends Controller {
    public function auto() {
       $data=array(
            'hello' => 'hello world',
        );        
        $this->setData($data);        
        $this->loadSingle('index');
    }

}
