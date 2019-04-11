<?php
namespace Zovercy\Http;
use FastRoute;

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
        return $this->content;
    }
}
