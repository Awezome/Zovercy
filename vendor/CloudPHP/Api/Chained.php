<?php

/*
 * Class Editor
 *
 * update : 2012-04-17
 * ----------------------------------------------------------------------*
 * @author : ZYP            @time : 2012-02-24
 * ----------------------------------------------------------------------*
 * Notes :
 *
 * chained::run();
 * ----------------------------------------------------------------------*
 */

class Chained {

    static private $_id; //要查询内容
    static private $_name; //要查询内容
    static private $_parent = 'parentid'; //要查询内容
    static private $_face = "<option value=''>---请选择---</option>"; //未选择时界面

    static function run($_table, $_id, $_name, $_selected_first = 0) {
        self::$_id = $_id;
        self::$_name = $_name;
        $_parent = self::$_parent;
        $_selected_second = 0;

        if ($_selected_first) {
            $_selected_seconds = DB::table("$_table")->where("$_id=$_selected_first")->findOne("$_parent");
            $_selected_second = $_selected_seconds[$_parent];
            if ($_selected_second == 0) {
                $_selected_second = $_selected_first;
                $_selected_first = 0;
            }
        }

        $data =DB::table("$_table")->where()->findAll("$_id,$_name,$_parent");
        $_max = count($data);

        $option = "<select id=\"first\" name=\"id_first\" class=\"form-control\">" . self::$_face;
        for ($i = 0; $i < $_max; $i++) {
            if ($data[$i][$_parent] == 0)
                $option.=self::HtmlOption('', $data[$i][self::$_id], $data[$i][self::$_name], $_selected_second);
        }
        $option.= " </select>";
        echo $option;

        $option = "<select id=\"second\" name=\"id_second\" class=\"form-control\">" . self::$_face;
        for ($i = 0; $i < $_max; $i++) {
            if ($data[$i][$_parent] != 0)
                $option.=self::HtmlOption($data[$i][self::$_parent], $data[$i][self::$_id], $data[$i][self::$_name], $_selected_first);
        }
        $option.= " </select>";
        echo $option;
    }

    public  static function style() {
        echo Html::js('Cloud/ext/js/jquery_chained.js');
        echo "<script>$(function() {	$('#second').chained('#first');});</script>";
    }

    private static function HtmlOption($class, $value, $content, $_selected) {
        $option = "<option class=\"" . $class . "\" value=\"" . $value . "\" ";
        if ($value == $_selected)
            $option.= "selected='selected'";
        $option.=">" . $content . "</option>";
        return $option;
    }

}
