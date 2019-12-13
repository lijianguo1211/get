<?php

class InsertSort
{
    public static function insertArraySort(array $data):array
    {
        if (!is_array($data)) {
            return ['message' => '待排序的序列非数组'];
        }
        $count = count($data);
        if ($count <= 1) {
            return $data;
        }

        for ($i = 1; $i < $count; $i++) {
            //待插入的元素
            $insertValue = $data[$i];
            //待插入数前面的数的索引
            $insertIndek = $i - 1;

            //$insertIndek >= 0 保证插入循环时，不越界，保证第一个元素的下标要大于等0

            //$insertValue < $arr[$insertIndek] 保证待插入的数还没有找到插入的位置，即待插入的数是小于它前面的那一个元素的

            //符合上述条件的，需要将$arr[$insertIndek] 后移
            while($insertIndek >= 0 && $insertValue < $data[$insertIndek]) {
                $data[$insertIndek+1] = $data[$insertIndek];
                $insertIndek--;//代表的就是有序列表的最前面一个元素的前面一个下标 -1；
            }

            //当退出循环时，代表找到位置 $insertIndek + 1
            //把插入的元素插入到有序列表的第一个位置
            //或者是没发生交换,即待插入元素大于有序列表的最后一个元素，那么这里只需要将有序列表的最后一个元素的索引 + 1,把待插入元素放在后
            //面一位即可
            $data[$insertIndek + 1] = $insertValue;
        }

        return $data;
    }
}
$arr = [36,12,96,-1];


var_dump(InsertSort::insertArraySort($arr));