<?php

/*
 * Class Upload
 *
 * update : 2012-02-27
 * ----------------------------------------------------------------------*
 * @improve : ZYP            @time : 2012-02-27
 * ----------------------------------------------------------------------*
 * Notes :
 *
 * ----------------------------------------------------------------------*
 */

class Upload {

    var $save_path;
    var $save_url;
    var $ext_arr = array(
        'image' => array('gif', 'jpg', 'jpeg', 'png', 'bmp'),
        'flash' => array('swf', 'flv'),
        'media' => array('swf', 'flv', 'mp3', 'wav', 'wma', 'wmv', 'mid', 'avi', 'mpg', 'asf', 'rm', 'rmvb'),
        'file' => array('doc', 'docx', 'xls', 'xlsx', 'ppt', 'htm', 'html', 'txt', 'zip', 'rar', 'gz', 'bz2'),
    );
    var $max_size = 1000000; //最大文件大小
    private $FILES;
    private $file_ext;
    private $file_url;
    private $up = 0;
    private $file_info;
    private $upload_type;

    function __construct() {
        $this->save_url = './public/upload/'; //文件保存目录路径
        $this->save_path = SITE_ROOT . $this->save_url; //文件保存目录URL
    }

    function up_file($FILES) {
        $this->FILES = $FILES;
        $this->upload_type = 'file';

        if (!$this->FILES['name']) {
            $this->_error(1);
            return;
        }//检查文件名
        if (@is_dir($this->save_path) === false) {
            $this->_error(2);
            return;
        }//检查目录
        if (@is_writable($this->save_path) === false) {
            $this->_error(3);
            return;
        }//检查目录写权限
        if (@is_uploaded_file($this->FILES['tmp_name']) === false) {
            $this->_error(4);
            return;
        }//检查是否已上传
        if ($this->FILES['size'] > $this->max_size) {
            $this->_error(5);
            return;
        }//检查文件大小

        $this->_ext(); //获得文件扩展名
        if (!in_array($this->file_ext, $this->ext_arr[$this->upload_type])) {
            $this->_error(6);
            return;
        }
        $this->_makedir();
        $this->_creat();
    }

    function getfile() {
        return array('up' => $this->up, 'name' => $this->FILES['name'], 'dir' => $this->file_url, 'size' => ($this->FILES['size'] / 1024) . 'KB',);
    }

    function getinfo() {
        return $this->file_info;
    }

    private function _creat() {
        $new_file_name = date("His") . '_' . rand(1000, 9999) . '.' . $this->file_ext;  //新文件名
        $file_path = $this->save_path . $new_file_name;   //移动文件
        if (move_uploaded_file($this->FILES['tmp_name'], $file_path) === false) {
            $this->_error(7);
            return;
        }

        @chmod($file_path, 0644);
        $this->file_url = $this->save_url . $new_file_name;
        $this->_error(0);
    }

    private function _makedir() {       //创建文件夹
        if ($this->upload_type !== '') {
            $this->save_path .= $this->upload_type . "/";
            $this->save_url .= $this->upload_type . "/";
            if (!file_exists($this->save_path))
                mkdir($this->save_path);
        }
        $ymd = date("Ymd");
        $this->save_path .= $ymd . "/";
        $this->save_url .= $ymd . "/";
        if (!file_exists($this->save_path))
            mkdir($this->save_path);
    }

    private function _ext() {
        $this->file_ext = strtolower(trim(substr(strrchr($this->FILES['name'], '.'), 1)));
    }

    private function _error($num) {
        switch ($num) {
            case 0: $this->file_info = "上传成功。";
                $this->up = 1;
                break;
            case 1: $this->file_info = "请选择文件。";
                break;
            case 2: $this->file_info = "上传目录不存在。";
                break;
            case 3: $this->file_info = "上传目录没有写权限。";
                break;
            case 4: $this->file_info = "临时文件可能不是上传文件。";
                break;
            case 5: $this->file_info = "上传文件大小超过限制。";
                break;
            case 6: $this->file_info = "上传文件扩展名是不允许的扩展名。\n只允许" . implode(",", $this->ext_arr[$this->upload_type]) . "格式。";
                break;
            case 7: $this->file_info = "上传文件失败。";
                break;
            default :break;
        }
    }

}

?>