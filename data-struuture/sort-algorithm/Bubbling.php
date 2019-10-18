<?php
/**
 * Notes:
 * File name:${fILE_NAME}
 * Create by: Jay.Li
 * Created on: 2019/10/18 0018 9:22
 */
$arr =  [1, 20, -3, -5, 6];
$count = count($arr);
$temp = 0;
$num = 0;
for ($i = 0; $i < $count; $i++) {
    for ($j = $i+1; $j < $count; $j ++) {
        echo $arr[$i] . '<----->' . $arr[$j] . PHP_EOL;
        if ($arr[$i] > $arr[$j]) {
            $temp = $arr[$i];
            $arr[$i] = $arr[$j];
            $arr[$j] = $temp;
        }
    }
}

for ($i = 0; $i < $count - 1; $i++) {
    for ($j = $count - 1; $j > $i; $j--) {
        echo $arr[$j] . '<----->' . $arr[$j - 1] . PHP_EOL;
        if ($arr[$j] < $arr[$j - 1]) {
            $temp = $arr[$j];
            $arr[$j] = $arr[$j-1];
            $arr[$j-1] = $temp;
        }
    }
}

var_dump($arr);
