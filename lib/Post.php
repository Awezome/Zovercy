<?php

/*
 * Class News
 *
 * update : 2012-01-30
 * ----------------------------------------------------------------------*
 * @author : ZYP            @time : 2012-01-28
 * ----------------------------------------------------------------------*
 * Notes :
 *
 * ----------------------------------------------------------------------*
 */

class Post {

    static function getTopList($table, $num) {
        $Link = new db();
        return $Link->table($table)->where('1 order by date desc limit 0,' . $num)->selectall();
    }

    static function statsPage($dbTable, $idName, $id) {
        $Link = new db();
        $stats = $Link->table($dbTable)->where($idName . "=" . $id)->selectone('stats');
        $times = $stats['stats'] + 1;
        $Link->table($dbTable)->where($idName . " = " . $id)->update('stats=' . $times);
    }

    static function formSelect($id, $getid) {
        $Link = new db();
        $selects = $Link->table('column')->where(' parentid=' . $id)->selectall();
        echo "<select id='select' name='cid'>";
        echo "<option value='0'>请选择分类</option>";
        foreach ($selects as $select) {
            echo "<option value=" . $select['cid'];
            if ($select['cid'] == $getid)
                echo " selected='selected'";
            echo ">" . $select['cname'] . "</option>";
        }
        echo "</select>";
    }

}

?>
