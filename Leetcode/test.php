<?php
/**
 * Notes:
 * File name:${fILE_NAME}
 * Create by: Jay.Li
 * Created on: 2019/11/19 0019 9:58
 */

function sums($nums, $target)
{
    $count = count($nums);
    $arr = [-1];
    for ($i = 0; $i < $count; $i++) {
        for ($j = $i + 1; $j < $count; $j++) {
            if ($target - $nums[$i] == $nums[$j]) {
                $arr = [$i, $j];
            }
        }
    }
    return $arr;
}

function sums2($data, $target)
{
    $temp = [];//定义一个临时数组
    foreach ($data as $k => $item) {
        $diffValue = $target - $item;//得到差值，
        if (!isset($temp[$diffValue])) {//判断差值是否在临时数组中,
            $temp[$item] = $k;//如果不在临时数组中，把当前循环的值放入临时数组当作键，键当作值，
            continue;//跳出本次循环
        }
        return [$temp[$diffValue], $k];
    }
    return [-1];
}
$nums = [2, 3, 3, 15];
$target = 6;
var_dump(sums2($nums, $target));