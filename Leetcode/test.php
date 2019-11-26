<?php
/**
 * Notes:
 * File name:${fILE_NAME}
 * Create by: Jay.Li
 * Created on: 2019/11/19 0019 9:58
 */

function sums($nums, $target)
{
    $tempArr = array_flip($nums);
    $arr = [];
    foreach ($nums as $k => $num) {
        $temp = $target - $num;
        if (!isset($tempArr[$temp])) {
            continue;
        }
        if ($k > $tempArr[$temp]) {
            $arr = [$tempArr[$temp], $k];
        } else {
            $arr = [$k, $tempArr[$temp]];
        }
    }
    return $arr;
}
$nums = [2, 7, 11, 15];
$target = 9;
var_dump(sums($nums, $target));