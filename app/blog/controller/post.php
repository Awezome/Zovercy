<?php

class post extends Controller {

    public function show() {
        $pid =Get::number(0);
        $result = DB::table('post')->where('pid=' . $pid)->findOne();
        Check::isEmpty($result);
        View::load('postshow',array('result' => $result));
    }
}
