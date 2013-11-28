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

    private static $url = "Cloud/ext/kindeditor/";

    public static function style() {
        echo Html::js(self::$url . 'kindeditor.js');
        echo Html::js(self::$url . 'lang/zh_CN.js');
        echo Html::css(self::$url . 'themes/default/default.css');
    }

    public static function textarea($name, $value = '',$width='80%', $height='400px') {
        self::edit($name);
        echo "<textarea id=\"" . $name . "\" name=\"" . $name . "\" style=\"width:" . $width . ";height:" . $height . ";visibility:hidden;\" >" . $value . "</textarea>";
    }

    private static function edit($name) {
       echo "<script>var editor;KindEditor.ready(function(K) { editor = K.create('textarea[name=\"" . $name . "\"]', {";
       echo "uploadJson : '" . self::kindJson() . "', allowFileManager:true,resizeType:1,filterMode : false });});</script>";
    }

    private static function kindJson($water = 0) {
       $this_water =$water == 1? '?water=1':'';
        return THIS_HOST . self::$url . 'php/upload_json.php' . $this_water;
    }

    static function fileupload($name = '', $class = '') {
        self::fileupload_script();
        echo "<input type=\"text\" name=\"" . $name . "\" class=\"" . $class . "\" id=\"url\" value=\"\" />";
        echo	"<input type=\"text\" name=\"" . $name . "\" class=\"" . $class . "\" id=\"short\" value=\"\" />";
        echo "<input type=\"button\" id=\"insertfile\" value=\"选择文件\" />";
    }

    private function fileupload_script() {
        echo "<script>KindEditor.ready(function(K) {var editor = K.editor({allowFileManager : false});";
        echo "K('#insertfile').click(function() {editor.loadPlugin('insertfile', function() {";
        echo "editor.plugin.fileDialog({fileUrl : K('#url').val(),clickFn : function(url, title) {";
        echo "K('#url').val(url);K('#short').val(title);editor.hideDialog();}});});});});</script>";
    }
}
