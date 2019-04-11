<?php
/**
 * User: zyp
 * Date: 2019-04-11
 * Time: 13:44
 */

namespace App\Controllers;

class ExampleController
{
    public function index(){
        return [
            'name'=>'Mike',
            'age'=>18,
        ];
    }
}
