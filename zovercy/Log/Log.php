<?php
namespace Zovercy\Log;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class Log
{
    private $log=null;
    function __construct($channel)
    {
        $this->log = new Logger($channel);
        $this->log->pushHandler(new StreamHandler('path/to/your.log', Logger::WARNING));
    }

    public function info($message){
        return $this->log->info($message);
    }

    public function error($message){
        return $this->log->error($message);
    }

}
