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
        $lIndex = $left;
        $rIndex = $right;

        //中轴值 pivot
        $pivot = floor($data[($left + $right) / 2]);

        //while 循环，比pivot值小的放在左边，比pivot大的值放在右边
        while ($lIndex < $rIndex) {

            //从pivot的左边开始找，直到找到大于pivot的值退出
            while ($data[$lIndex] < $pivot) {
                $lIndex++;
            }

            //从pivot的右边开始找，直到小于pivot的值才退出
            while ($data[$rIndex] > $pivot) {
                $rIndex--;
            }

            //如果 lIndex >= rIndex 说明pivot的左右两边的值，已经按照左边全部是小于pivot的值，
            //右边大于pivot的值
            if ($lIndex >= $rIndex) {
                break;
            }

            //交换
            $temp = $data[$lIndex];
            $data[$lIndex] = $data[$rIndex];
            $data[$rIndex] = $temp;

            //交换之后，发现$data[$lIndex] == $pivot 前移
            if ($data[$lIndex] == $pivot) {
                $rIndex -= 1;
            }

            if ($data[$rIndex] == $pivot) {
                $lIndex += 1;
            }
        }

        if ($lIndex == $rIndex) {
            $lIndex += 1;
            $rIndex -= 1;
        }

        if ($left < $rIndex) {
            static::quickSortArray($data, $left, $rIndex);
        }

        if ($right > $lIndex) {
            static::quickSortArray($data, $lIndex, $right);
        }
        return $data;
    }
}

$data = [5,69,32,1,-58,8,69,74,3,0,5];

$count = count($data);

$left = 0;

$right = $count-1;

var_dump(QuickSort::quickSortArray($data, $left, $right));