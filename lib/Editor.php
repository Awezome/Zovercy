<?php

/*
 * Class Editor
 *
 * update : 2012-10-06
 * ----------------------------------------------------------------------*
 * @author : ZYP            @time : 2012-01-25
 * ----------------------------------------------------------------------*
 * Notes :
 *
 * {echo Editor::textarea($name,"95%","400px",$value)}
 * ----------------------------------------------------------------------*
 */

class Editor {

    private static function kind_json($water = 0) {
        $this_water = '';
        if ($water == 1)
            $this_water = '?water=1';
        return substr('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'], 0, -9) . 'HisunPHP/Ext/kindeditor/php/upload_json.php' . $this_water;
    }

    static function kind_style() {
        self::script();
        self::css();
    }

    static function var_editor($water = 0) {
        $json = self::kind_json($water);
        echo "
		var editor = K.editor({
			uploadJson : '" . $json . "',
			allowFileManager : true
		});		
		";
    }

    static function textarea($name, $width, $height, $value = '') {
        self::script();
        self::edit($name);
        echo "<textarea id=\"" . $name . "\" name=\"" . $name . "\" style=\"width:" . $width . ";height:" . $height . ";visibility:hidden;\" >" . $value . "</textarea>";
    }

    static function fileupload($name = '', $class = '') {
        self::script();
        self::css();
        self::fileupload_script();
        echo "<input type=\"text\" name=\"" . $name . "\" class=\"" . $class . "\" id=\"url\" value=\"\" />
			<input type=\"text\" name=\"" . $name . "\" class=\"" . $class . "\" id=\"short\" value=\"\" />
			<input type=\"button\" id=\"insertfile\" value=\"选择文件\" />";
    }

    private function fileupload_script() {
        echo "<script>
			KindEditor.ready(function(K) {
				var editor = K.editor({
					allowFileManager : false
				});
				K('#insertfile').click(function() {
					editor.loadPlugin('insertfile', function() {
						editor.plugin.fileDialog({
							fileUrl : K('#url').val(),
							clickFn : function(url, title) {
								K('#url').val(url);
								K('#short').val(title);

								editor.hideDialog();
							}	});	});	});	});
							</script>";
    }

    private static function edit($name) {
        echo "<script>var editor;
			KindEditor.ready(function(K) {
				editor = K.create('textarea[name=\"" . $name . "\"]', {
				uploadJson : '" . self::kind_json(1) . "',
				allowFileManager:true,
				resizeType:0,
				filterMode : false
			});});</script>";
    }

    private static function script() {
        echo "<script charset=\"utf-8\" src=\"./HisunPHP/Ext/kindeditor/kindeditor.js\" type=\"text/javascript\"></script>
		<script charset=\"utf-8\" src=\"./HisunPHP/Ext/kindeditor/lang/zh_CN.js\" type=\"text/javascript\"></script>
			";
    }

    private static function css() {
        echo "<link rel=\"stylesheet\" href=\"./HisunPHP/Ext/kindeditor/themes/default/default.css\" />";
    }

}

?>
