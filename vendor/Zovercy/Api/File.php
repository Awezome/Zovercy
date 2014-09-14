<?php

class File {

    public static function fileext($filename) {
        return strtolower(trim(substr(strrchr($filename, '.'), 1)));
    }

//获取文件名后缀

    public static function sreadfile($filename) {
        $content = '';
        if (function_exists('file_get_contents')) {
            @$content = file_get_contents($filename);
        } else {
            if (@$fp = fopen($filename, 'r')) {
                @$content = fread($fp, filesize($filename));
                @fclose($fp);
            }
        }
        return $content;
    }

//获取文件内容

    public static function swritefile($filename, $writetext, $openmod = 'w') {
        if (@$fp = fopen($filename, $openmod)) {
            flock($fp, 2);
            fwrite($fp, $writetext);
            fclose($fp);
            return true;
        } else {
            //runlog('error', "File: $filename write error.");
            return false;
        }
    }

//写入文件//$filename 待写入文件的文件名  $string 文件内容

    public static function sreaddir($dir, $extarr = array()) {
        $dirs = array();
        if ($dh = opendir($dir)) {
            while (($file = readdir($dh)) !== false) {
                if (!empty($extarr) && is_array($extarr)) {
                    if (in_array(strtolower(fileext($file)), $extarr)) {
                        $dirs[] = $file;
                    }
                } else if ($file != '.' && $file != '..') {
                    $dirs[] = $file;
                }
            }
            closedir($dh);
        }
        return $dirs;
    }

//获取某个目录下的所有文件名//$dir 目录名（如 $dir = SITE_ROOT.'./data/'）$extarr	文件后缀名

    public static function dl_file($file, $filename) {
        //First, see if the file exists
        if (!is_file($file)) {
            
        }//die("<b>404 File not found!</b>"); }
        //Gather relevent info about file
        $len = filesize($file);
        //$filename = basename($file);
        $file_extension = strtolower(substr(strrchr($filename, "."), 1));
        //encode filename
        $ua = $_SERVER['HTTP_USER_AGENT'];
        $encoded_filename = urlencode($filename);
        $encoded_filename = str_replace("+", "%20", $encoded_filename);
        if (preg_match("/MSIE/", $ua)) {
            $filename = $encoded_filename;
        }
        //This will set the Content-Type to the appropriate setting for the file
        switch ($file_extension) {
            case "pdf": $ctype = "application/pdf";
                break;
            case "exe": $ctype = "application/octet-stream";
                break;
            case "zip": $ctype = "application/zip";
                break;
            case "doc": $ctype = "application/msword";
                break;
            case "xls": $ctype = "application/vnd.ms-excel";
                break;
            case "ppt": $ctype = "application/vnd.ms-powerpoint";
                break;
            case "gif": $ctype = "image/gif";
                break;
            case "png": $ctype = "image/png";
                break;
            case "jpeg":
            case "jpg": $ctype = "image/jpg";
                break;
            case "mp3": $ctype = "audio/mpeg";
                break;
            case "wav": $ctype = "audio/x-wav";
                break;
            case "asf": $ctype = "video/x-ms-asf";
                break;
            case "mpeg":
            case "mpg":
            case "mpe": $ctype = "video/mpeg";
                break;
            case "mov": $ctype = "video/quicktime";
                break;
            case "avi": $ctype = "video/x-msvideo";
                break;
            case "txt": $ctype = "text/plain";
                break;
            //The following are for extensions that shouldn't be downloaded (sensitive stuff, like php files)
            case "php":
            case "htm":
            case "html":die("<b>Cannot be used for " . $file_extension . " files!</b>");
                break;
            default: $ctype = "application/force-download";
        }
        //ob_end_clean();
        //Begin writing headers
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        //Use the switch-generated Content-Type
        header("Content-Type: $ctype");
        //Force the download
        $header = "Content-Disposition: attachment; filename=" . $filename . ";";
        header($header);
        header("Content-Transfer-Encoding: binary");
        header("Content-Length: " . $len);
        readfile($file);
        exit;
    }

//文件下载

    public static function in_filetype($filetype) {
        //$filetype = strtolower($filetype);
        //$types = array('doc','xls','txt','rar','ppt','zip','7z','jpg','git','png','bmp','docx','xlsx','pdf','pptx','asf');
        //return in_array($filetype,$types);
        return true;
    }

//判断文件类型

    public static function is_pictype($filetype) {
        $filetype = strtolower($filetype);
        $types = array('jpg', 'git', 'png', 'bmp', 'jpeg');
        return in_array($filetype, $types);
    }

//判断是否为图片

    public static function createdir($dir) {
        if (file_exists($dir) && is_dir($dir)) {//如果存在这个文件并且这个文件是个目录就不动作
        } else {
            mkdir($dir, 0777); //否则就创造这个目录
        }
    }

//创建文件夹
}

?>