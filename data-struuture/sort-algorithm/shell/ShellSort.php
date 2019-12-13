<?php


class ShellSort
{
    /**
     * Notes: 希尔排序之交换法排序
     * User: LiYi
     * Date: 2019/11/12 0012
     * Time: 14:30
     * @param array $data
     * @return array
     */
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

    /**
     * Notes: 希尔排序之移位法排序
     * User: LiYi
     * Date: 2019/11/12 0012
     * Time: 14:29
     * @param array $data
     * @return array
     */
    public static function ShellSortMoveArray(array $data)
    {
        $count = count($data);//得到数组总数
        for ($gap = $count / 2; $gap > 0; $gap /= 2) {//缩小增量，每次减半
            $gap = floor($gap);
            for ($i = $gap; $i < $count; $i++) {//
                $insertIndex = $i;//待插入元素的下表
                $insertValue = $data[$insertIndex];//待插入元素的值
                echo "insertIndex=$insertIndex" . PHP_EOL;
                echo "insertValue=$insertValue" . PHP_EOL;
                if ($data[$insertIndex] < $data[$insertIndex - $gap]) {//判断待插入元素和它步长的元素比较，待插入元素小就进入循环
                    //判断是否越界了，第一个元素的下标是要大于等于0的，否则退出循环
                    //判断后面的元素比前面的元素小，进入循环，否则退出循环
                    while ($insertIndex - $gap >= 0 && $insertValue < $data[$insertIndex - $gap]) {
                        //把步长前面的大的值向后移动
                        $data[$insertIndex] = $data[$insertIndex - $gap];
                        $insertIndex -= $gap;//每循环一次就把带插入的坐标减去补偿
                    }
                    //把带插的小值插入到前面
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
var_dump(ShellSort::shellSortMoveArray([0 => 9, 1 => 6, 2 => 1, 3 => 3, 4 => 0, 5 => 5, 6 => 7, 7 => 2, 8 => 8, 9 => 4]));

// $gap = 10 / 2 = 5

// $insertIndex  = $i = $gap = 5
// $insertValue = $data[$insertIndex] = $data[5] = 5;
// $data[$insertIndex] < $data[$insertIndex - $gap] == $data[5] < $data[5-5] = $data[0] ==> 5 < 9
// while(5 - 5 >= 0 && 5 < 9) {
//  $data[5] = $data[5-5] = $data[0] = 9
//  $insertIndex -= 5 = 0;
//}
// $data[$insertIndex] = $data[0] = $insertValue = 5
// $i++ = 6;
// $insertIndex  = $i =  6
// $insertValue = $data[$insertIndex] = $data[6] = 7;
// $data[$insertIndex] < $data[$insertIndex - $gap] == $data[6] < $data[6-5] = $data[1] ==> 7 < 6
// $i++ = 7;
// $insertIndex  = $i =  7
// $insertValue = $data[$insertIndex] = $data[7] = 2;
// $data[$insertIndex] < $data[$insertIndex - $gap] == $data[7] < $data[7-5] = $data[2] ==> 2 < 1
// $i++ = 8;
// $insertIndex  = $i =  8
// $insertValue = $data[$insertIndex] = $data[8] = 8;
// $data[$insertIndex] < $data[$insertIndex - $gap] == $data[8] < $data[8-5] = $data[3] ==> 8 < 3
// $i++ = 9;
// $insertIndex  = $i =  9
// $insertValue = $data[$insertIndex] = $data[9] = 4;
// $data[$insertIndex] < $data[$insertIndex - $gap] == $data[9] < $data[9-5] = $data[4] ==> 4 < 0
