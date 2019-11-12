<?php
/**
 * Notes:
 * File name:QuickSort
 * Create by: Jay.Li
 * Created on: 2019/11/12 0012 14:44
 */


class QuickSort
{
    public static function quickSortArray(array $data, int $left, int $right):array
    {
        $center = ($left + $right) / 2;

        return $data;
    }
}

$data = [5,69,32,1,-58,8,69,74,3,0,5];

$count = count($data);

$left = $data[0];

$right = $data[$count-1];

var_dump(QuickSort::quickSortArray($data, $left, $right));