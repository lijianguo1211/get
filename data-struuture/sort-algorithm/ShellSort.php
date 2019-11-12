<?php


class ShellSort
{
    public static function shellSortArray(array $data):array
    {
        if (!is_array($data)) {
            return ['message' => '必须传入数组比较排序'];
        }

        $count = count($data);//得到数组的个数

        //如果数组的个数小于等于1就直接返回
        if ($count <= 1) {
            return $data;
        }

        //$gap 是每次减半的分组，直到只可以分为一组结束，在php里面需要注意，两个整数相除，除不尽的情况下，得到的是一个浮点数，不是一个向下
        //取整的的整数，所以在最后判断gap 退出循环的时候，需要判断它 >= 1
        for ($gap = $count / 2; $gap >= 1; $gap /= 2) {
            for ($i = $gap; $i < $count; $i++) {
                for ($j = $i - $gap; $j >= 0; $j-=$gap) {
                    if ($data[$j] > $data[$j+$gap]) {//这个地方是比较第一个数和它的步长做比较，交换也是一样
                        $temp = $data[$j];
                        $data[$j] = $data[$j+$gap];
                        $data[$j+$gap] = $temp;
                    }
                }
            }
        }
        return $data;
    }

    public static function validate(array $data)
    {
        if (!is_array($data)) {
            return ['message' => '必须传入数组比较排序'];
        }

        $count = count($data);//得到数组的个数

        //如果数组的个数小于等于1就直接返回
        if ($count <= 1) {
            return $data;
        }

        return [$data, $count];
    }

    public static function ShellSortMoveArray(array $data)
    {
        $count = count($data);
        for ($gap = $count / 2; $gap >= 1; $gap /= 2) {
            $gap = floor($gap);
            for ($i = $gap; $i < $count; $i++) {
                $insertIndex = $i;
                $insertValue = $data[$insertIndex];
                echo "insertIndex=$insertIndex" . PHP_EOL;
                echo "insertValue=$insertValue" . PHP_EOL;
                if ($data[$insertIndex] < $data[$insertIndex - $gap]) {
                    while ($insertIndex - $gap > 0 && $insertValue < $data[$insertIndex - $gap]) {
                        $data[$insertIndex] = $data[$insertIndex - $gap];
                        $insertIndex -= $gap;
                    }

                    $data[$insertIndex] = $insertValue;
                }
            }

        }
        return $data;
    }

    public static function testShellOne(array $data)
    {
        $temp = 0;
        $count = count($data);
        for ($i = 5; $i < $count; $i++) {
            for ($j = $i - 5; $j >= 0; $j-=5) {
                if ($data[$j] > $data[$j+5]) {
                    $temp = $data[$j];
                    $data[$j] = $data[$j+5];
                    $data[$j+5] = $temp;
                }
            }
        }

        for ($i = 2; $i < $count; $i++) {
            for ($j = $i - 2; $j >= 0; $j-=2) {
                if ($data[$j] > $data[$j+2]) {
                    $temp = $data[$j];
                    $data[$j] = $data[$j+2];
                    $data[$j+2] = $temp;
                }
            }
        }

        for ($i = 1; $i < 10; $i++) {
            for ($j = $i - 1; $j >= 0; $j-=1) {
                if ($data[$j] > $data[$j+1]) {
                    $temp = $data[$j];
                    $data[$j] = $data[$j+1];
                    $data[$j+1] = $temp;
                }
            }
        }

        var_dump($data);
    }
}
var_dump(ShellSort::shellSortMoveArray([9,6,1,3,0,5,7,2,8,4]));
