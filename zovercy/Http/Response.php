<?php
namespace Zovercy\Http;
use Workerman\Protocols\Http;

class Response
{
    private $content=null;

    function __construct()
    {
    }

    public function setContent($content){
        $this->content=$content;
    }

    public function toJson(){
        $content=$this->content;
        if(is_array($content)){
            $content=json_encode($content,JSON_UNESCAPED_UNICODE);
        }
        return $content;
    }

    public function setHeader($header,$code=200,$replace=true){
        if($header=='json'){
            $header='Content-Type: application/json;charset=utf-8';
        }
        Http::header($header,$replace,$code);
    }
}
