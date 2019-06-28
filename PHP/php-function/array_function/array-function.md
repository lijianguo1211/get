### 常用的数组函数

* `count($array):int` 得到数组元素个数

* `array_push(&$array, $item):int` 将一个或多个单元压入数组的末尾（入栈）返回处理之后数组的元素个数。

* `array_pop(&$array)` 弹出数组最后一个单元（出栈）弹出并返回 array 数组的最后一个单元，并将数组 array 的长度减一。

* `array_shift(&$array)` 将数组开头的单元移出数组

* `array_unshift(&$array, $item):int` 在数组开头插入一个或多个单元

* `array_merge($array, $array1)` 合并一个或多个数组

* `is_array($var):bool` 检测变量是否是数组

* `in_array($item, $array, $strict):bool` 检查数组中是否存在某个值

* `array_map($callback, $array)` 为数组的每个元素应用回调函数

```php
<?php

$func = function($num) {
    echo $num * $num;
    echo "\n";
};

$array = [1,2,3,4,5];

$data = array_map($func, $array);

print_r($data);

//1 , 4 , 9, 16, 25
?>
```
