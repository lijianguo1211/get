### 插入排序 Insert Sort

* 插入排序的思想：

> 将一个待排序的无序的数组看作是两个列表，一个有序的列表，一个无序的列表，从无序的列表每次拿出一个待插入的元素，插入到有序的列表中，直
到无序列表为空，排序完毕

* 实际举例：

1. 有一个无序的一维数组是这次需要排序的数组，数组是：``[36,12,96,-1]``

2. 首先把数组的第一个元素 `[36]` 看作是一个独立的有序的列表，把剩下的元素 `[12, 96, -1]`看作是一个无序的列表

3. 第一个待插入的元素就是 `12`，要把`12`插入到有序的列表中，首先需要`12`和`36`比较，如果带插入的元素`12`小于`36`,就需要把`12`插入到`36`
前面，也就是`36`要后移一位。

4. 插入排序实际是需要比较数组元素的总数减一轮，因为第一个元素不需要比较。

```php
$arr = [36,12,96,-1];
//待插入的数
$insertValue = $arr[1];
//待插入数前面的数的索引
$insertIndek = 1 - 1;

//$insertIndek >= 0 保证插入循环时，不越界，保证第一个元素的下标要大于等0

//$insertValue < $arr[$insertIndek] 保证待插入的数还没有找到插入的位置，即待插入的数是小于它前面的那一个元素的

//符合上述条件的，需要将$arr[$insertIndek] 后移
while($insertIndek >= 0 && $insertValue < $arr[$insertIndek]) {
       $arr[$insertIndek+1] = $arr[$insertIndek];
       $insertIndek--;//代表的就是有序列表的最前面一个元素的前面一个下标 -1；
}

//当退出循环时，代表找到位置 $insertIndek + 1

$arr[$insertIndek + 1] = $insertValue;//把插入的元素插入到有序列表的第一个位置或者是没发生交换就在本身的位置

$arr = [12,36,96,-1];
//待插入的数
$insertValue = $arr[2];
//待插入数前面的数的索引
$insertIndek = 2 - 1;

//$insertIndek >= 0 保证插入循环时，不越界，保证第一个元素的下标要大于等0

//$insertValue < $arr[$insertIndek] 保证待插入的数还没有找到插入的位置，即待插入的数是小于它前面的那一个元素的

//符合上述条件的，需要将$arr[$insertIndek] 后移
while($insertIndek >= 0 && $insertValue < $arr[$insertIndek]) {
       $arr[$insertIndek+1] = $arr[$insertIndek];
       $insertIndek--;//代表的就是有序列表的最前面一个元素的前面一个下标 -1；
}

//当退出循环时，代表找到位置 $insertIndek + 1

$arr[$insertIndek + 1] = $insertValue;//把插入的元素插入到有序列表的第一个位置或者是没发生交换就在本身的位置
```

4. 依次类推，得到完成的有序数组

5. 完整代码如下：

```php
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
```