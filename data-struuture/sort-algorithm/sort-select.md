### 选择排序 select sorting

* 选择排序也是内部排序

* 排序思想：

第一次先随便选择一个数，就是在要排序的数组中选择一个元素和数组的其它元素比较。然后比较交换位置得到最小值或者最大值，
然后再次在剩下的数组中，选择一个数和数组剩下的元素比较，最后得到第二个最小或最大的元素。一次类推

* 示意图：

> 选择排序一共有数组大小 - 1 轮排序；每一轮排序又是一个循环；先假定当前的这个数组就是最小数，然后和后面的元素依次比较，如果发现有比当
前数更小的数，就重新确定最小数，并得到下标，当遍历到数组的最后时，就得到本轮最小数和下标，交换

1. 假设有一个待排序的数组 `[3, 1, 15, 5, 20]`

2. 随机选择一个元素，假设第一个就是最小的元素，拿 `3` 和数组剩下的元素比较，第一轮排序后得到最小元素 `1`

```php
<?php

$arr = [3, 1, 15, 5, 20];

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
```

3. 再次选择一个假定最小值，与后面的元素一次比较，得到第二个最小值

```php
<?php

$arr = [1, 3, 15, 5, 20];

$count = count($arr);
//假设最小的元素就是第二个元素
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

```

4. 以此类推，就可以使用双重for循环，得到选择排序的算法如下：

```php
    public static function sortSelect(array $arr) :array
    {
        if (!is_array($arr)) {
            return ['message' => '$arr不是一个数组'];
        }

        $count = count($arr);

        if ($count <= 1) {
            return $arr;
        }

        for ($i = 0; $i < $count; $i++) {
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
```

* 完整代码如下：

```php
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

        for ($i = 0; $i < $count; $i++) {
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
```
