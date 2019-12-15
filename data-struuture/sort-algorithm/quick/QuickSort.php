<?php
/**
 * Notes:
 * File name:QuickSort
 * Create by: Jay.Li
 * Created on: 2019/11/12 0012 14:44
 */


class QuickSort
{
    public static function quickSortArray(array $data, int $left, int $right)
    {
        $leftIndex = $left;
        $rightIndex = $right;

        //中轴值 pivot

        $pivot = intval($data[($left + $right) / 2]);
        echo implode(',', $data) . PHP_EOL;
        echo 'lindex => ' . $leftIndex . '  rindex => ' . $rightIndex . ' pivot => ' . $pivot .PHP_EOL;

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

$data = [5,69,109,99,32,60,8,69,74,3,0,5];


$count = count($data);

$left = 0;

$right = $count-1;


//var_dump(QuickSort::quickSortArray($data, $left, $right));

function quickArray($data)
{
    if (count($data) < 2) {
        return $data;
    }

    //选择最开始的基准比较数字，假设就是第一个
    $leftArr = [];//存放比基准小的
    $rightArr = [];//存放比基准大的
    $middle  = $data[0];
    for ($i = 1; $i < count($data); $i++) {
        if ($middle  < $data[$i]) {
            $rightArr[] = $data[$i];
        } else {
            $leftArr[] = $data[$i];
        }
    }

    $leftArr = quickArray($leftArr);
    $rightArr = quickArray($rightArr);

    return array_merge($leftArr, (array)$middle , $rightArr);
}

var_dump(quickArray($data));

//5,69,109,99,32,60,8,69,74,3,0,5
//lindex => 0  rindex => 11 pivot => 60
// 5 < 60 => lindex++ = 1 = $data[lIndex] = 69 | 5 > 60
//$data[$lIndex] = 69;
//$data[$rIndex] = 5;
//5,5,109,99,32,60,8,69,74,3,0,69
// 5 < 60 => lindex++ = 2 $data[$lindex]=109 < 60 $data[rIndex] = $data[11] = 69 > 60 rindex-- = 10 = $data[10] = 10 > 60 !=
//5,5,0,99,32,60,8,69,74,3,109,69

//5,5,0,3,32,8,60,69,74,99,109,69

//lindex => 0  rindex => 5 pivot => 0
//0,5,5,3,32,8,60,69,74,99,109,69
//lindex => 1  rindex => 5 pivot => 3
//0,3,5,5,32,8,60,69,74,99,109,69
//lindex => 2  rindex => 5 pivot => 5
//0,3,5,5,32,8,60,69,74,99,109,69
//lindex => 3  rindex => 5 pivot => 32
//0,3,5,5,8,32,60,69,74,99,109,69
//lindex => 3  rindex => 4 pivot => 5
//5,5,0,3,32,8,60,69,74,99,109,69
//lindex => 7  rindex => 11 pivot => 99
//5,5,0,3,32,8,60,69,74,69,99,109
//lindex => 7  rindex => 10 pivot => 74
//5,5,0,3,32,8,60,69,69,74,99,109
//lindex => 7  rindex => 8 pivot => 69
echo implode(',', QuickSort::quickSortArray($data, $left, $right));

