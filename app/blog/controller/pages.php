<?php

class pages extends Controller {
    public function show() {
        $pid =Get::string(0);
        $result = DB::table('page')->where("name='$pid'")->findOne();
        Check::isEmpty($result);        
        View::load('page',array('result' => $result));
    }

}
