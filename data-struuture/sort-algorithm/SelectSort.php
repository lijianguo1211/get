<?php


class SelectSort
{
    public static function select(array $arr):array
    {
        $count = count($arr);
        //假设最小的元素就是第二个元素
        $minIndex = 0;//假设的最小元素的下表
        $min = $arr[0];//假定最小元素的值
        for ($j = $minIndex + 1; $j < $count; $j++) {
            if ($min > $arr[$j]) { //假定的最小值大于后面的值，重置最小值
                $min = $arr[$j];
                $minIndex = $j;
            }
        }
        if ($minIndex != 0) {
            $arr[$minIndex] = $arr[0];//假定的最小元素不是最小元素，那么把后面的最小元素和假定的最小元素做交换
            $arr[0] = $min;//元素下标交换
        }
        var_dump($arr);
        $minIndex = 1;//假设的最小元素的下表
        $min = $arr[1];//假定最小元素的值
        for ($j = $minIndex + 1; $j < $count; $j++) {
            if ($min > $arr[$j]) { //假定的最小值大于后面的值，重置最小值
                $min = $arr[$j];
                $minIndex = $j;
            }
        }
        if ($minIndex != 1) {
            $arr[$minIndex] = $arr[1];//假定的最小元素不是最小元素，那么把后面的最小元素和假定的最小元素做交换
            $arr[1] = $min;//元素下标交换
        }
        var_dump($arr);
        $minIndex = 2;//假设的最小元素的下表
        $min = $arr[2];//假定最小元素的值
        for ($j = $minIndex + 1; $j < $count; $j++) {
            if ($min > $arr[$j]) { //假定的最小值大于后面的值，重置最小值
                $min = $arr[$j];
                $minIndex = $j;
            }
        }
        if ($minIndex != 2) {
            $arr[$minIndex] = $arr[2];//假定的最小元素不是最小元素，那么把后面的最小元素和假定的最小元素做交换
            $arr[2] = $min;//元素下标交换
        }
        var_dump($arr);
        return $arr;
    }

    public static function sortSelect(array $arr) :array
    {
        if (!is_array($arr)) {
            return ['message' => '$arr不是一个数组'];
        }

        $count = count($arr);

        if ($count <= 1) {
            return $arr;
        }

        for ($i = 0; $i < $count - 1; $i++) {
            $minIndex = $i;
            $min = $arr[$i];
            for ($j = $i + 1; $j < $count; $j++) {
                if ($min > $arr[$j]) {//选择的假定最小元素大于后面的元素
                    $min = $arr[$j];//把后面的最小元素赋值给假定的最小元素
                    $minIndex = $j;//把后面最小元素的坐标赋值给假定的最小元素
                }
            }

            if ($minIndex != $i) {//如果在这个位置，一开始的假定最小元素的坐标被替换了，说明假定最小元素不是最小元素，那么发生交换
                $arr[$minIndex] = $arr[$i];//交换最小元素，把最小元素和假定元素做交换
                $arr[$i] = $min;
            }
        }
        return $arr;
    }
}
$arr = [3, 1, 15, 5, 20];

var_dump(SelectSort::sortSelect($arr));