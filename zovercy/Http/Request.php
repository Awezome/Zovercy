<?php
/**
 * User: zyp
 * Date: 2019-04-11
 * Time: 12:16
 */

namespace Zovercy\Http;

class Request
{
    private $get=null;
    private $post=null;
    private $request=null;
    private $server=null;
    private $files=null;
    private $rawData=null;

    public function __construct()
    {
        $this->get     = $_GET;
        $this->post    = $_POST;
        $this->request = $_REQUEST;
        $this->server  = $_SERVER;
        $this->files   = $this->files();
        $this->rawData = $GLOBALS['HTTP_RAW_POST_DATA'];
    }

    public function method()
    {
        return $this->server['REQUEST_METHOD'];
    }

    public function uri(){
        $uri = $this->server['REQUEST_URI'];
        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }
        return rawurldecode($uri);
    }

    public function files()
    {
        $files = [];
        foreach ($_FILES as $file) {
            if ( ! empty($file['file_data'])) {
                $files[$file['file_name']][] = new File($file);
            } else {
                $files[$file['file_name']] = NULL;
            }
        }
        // count file
        foreach ($files as $name => $file) {
            if (count($file) == 1) {
                $files[$name] = $file[0];
            }
        }
        return $files;
    }
}

