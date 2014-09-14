<?php
/**
 * Created by PhpStorm.
 * User: Awezome
 * Date: 4/14/14
 * Time: 2:36 PM
 */


function p($o,$title=''){
    echo '<pre style="background:#ddd;font-weight: 700;font-size: 14px">';
    echo '<span style="color:red">'.$title.'</span><br />';
    print_r($o);
    echo '</pre>';
}


function jump($url) {
    header("Location: " . $url);
    exit();
}

function arrayValueToKey($a,$value='',$key=''){
    $ds=array();
    if($key==''||$value==''){
        $kk=array_keys($a[0]);
        $key=$kk[0];
        $value=$kk[1];
    }
    foreach($a as $b){
        $ds[$b[$key]]=$b[$value];
    }
    return $ds;
}

function arrayInsert(&$array, $index, $position) {
    //  $pos   = array_search($position, array_keys($array))+1;
    $pos=$position;
    $start = array_slice($array, 0, $pos);
    $end = array_slice($array, $pos);
    $array=array_merge($start,$index,$end);
}

	
function g($v=''){
    $content=date('Y-m-d H:i:s')."\t".$v."\n";
   // echo $content;
    file_put_contents(Z::$config['LOG']['dir'], $content, FILE_APPEND);
}

//function array_convert($var, $rField='name', $rKey='id'){
//	$count = count($var);
//	for($i=0;$i<$count;$i++)
//	{
//		$temp[$var[$i][$rKey]] = $var[$i][$rField];
//	}
//	return $temp;
//}
