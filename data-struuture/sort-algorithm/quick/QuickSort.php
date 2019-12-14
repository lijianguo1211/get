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
        $leftIndex = $left;
        $rightIndex = $right;

        //中轴值 pivot
        $pivot = intval($data[($leftIndex + $rightIndex) / 2]);

        //while 循环，比pivot值小的放在左边，比pivot大的值放在右边
        while ($leftIndex < $rightIndex) {

            //从pivot的左边开始找，直到找到大于pivot的值退出
            while ($data[$leftIndex] < $pivot) {
                $leftIndex++;
            }

            //从pivot的右边开始找，直到小于pivot的值才退出
            while ($data[$rightIndex] > $pivot) {
                $rightIndex--;
            }

            //如果 lIndex >= rIndex 说明pivot的左右两边的值，已经按照左边全部是小于pivot的值，
            //右边大于pivot的值
            if ($leftIndex >= $rightIndex) {
                break;
            }

            //交换
            $temp = $data[$leftIndex];
            $data[$leftIndex] = $data[$rightIndex];
            $data[$rightIndex] = $temp;

            //交换之后，发现$data[$lIndex] == $pivot 前移
            if ($data[$leftIndex] == $pivot) {
                $rightIndex -= 1;
            }

            if ($data[$rightIndex] == $pivot) {
                $leftIndex += 1;
            }
        }

//        if ($leftIndex == $rightIndex) {
//            $leftIndex += 1;
//            $rightIndex -= 1;
//        }
//
//        if ($left < $rightIndex) {
//            static::quickSortArray($data, $left, $rightIndex);
//        }
//
//        if ($right > $leftIndex) {
//            static::quickSortArray($data, $leftIndex, $right);
//        }
        return $data;
    }
}

$data = [5,69,32,1,-58,8,69,74,3,0,5];

$count = count($data);

$left = 0;

$right = $count-1;

echo implode(',', QuickSort::quickSortArray($data, $left, $right));