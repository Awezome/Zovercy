<?php

/*
 * Class Editor
 *
 * update : 2013-11-28
 * ----------------------------------------------------------------------*
 * @author : ZYP            @time : 2012-01-25
 * ----------------------------------------------------------------------*
 * Notes :
 * Editor::style()
 * Editor::textarea($name,$value,"95%","400px")
 * ----------------------------------------------------------------------*
 */

class Editor {
    public static function load($name, $value = '', $width = '100%', $height = '400px') {
        echo '<textarea id="editor' . $name . '" name="' . $name . '" style="width:' . $width . ';height:' . $height.';" >' . $value. '</textarea>';
        echo '<script type="text/javascript">UM.getEditor("editor'.$name.'");</script>';
    }
    public static function style() {
        $link = URL::web() . 'vendor/umeditor/';
        echo '<link href="' . $link . 'themes/default/css/umeditor.css" type="text/css" rel="stylesheet">'
            . '<script type="text/javascript" charset="utf-8" src="' . $link . 'umeditor.config.js"></script>'
            . '<script type="text/javascript" charset="utf-8" src="' . $link . 'umeditor.min.js"></script>'
            . '<script type="text/javascript" src="' . $link . 'lang/zh-cn/zh-cn.js"></script>';
    }

}
