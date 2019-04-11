<?php
namespace Zovercy\Http;

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
}
