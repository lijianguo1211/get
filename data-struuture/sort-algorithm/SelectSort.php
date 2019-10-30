<?php


class SelectSort
{
    public static function select(array $arr):array
    {
        $count = count($arr);
//假设最小的元素就是第一个元素
        $minIndex = 0;
        $min = $arr[0];
        for ($j = $minIndex + 1; $j < $count; $j++) {
            if ($min > $arr[$j]) { //假定的最小值大于后面的值，重置最小值
                $min = $arr[$j];
                $minIndex = $j;
            }
        }

        $arr[$minIndex] = $arr[0];
        $arr[0] = $min;

        return $arr;
    }
}
$arr = [3, 1, 15, 5, 20];

var_dump(SelectSort::select($arr));