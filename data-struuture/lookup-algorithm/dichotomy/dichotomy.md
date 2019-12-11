### 查找算法之二分法

* 二分法查找的前提是待找的数组是一个有序的数组（这里假设数组是一个从小到大的数组）

* 递归的查找需要找到的值

* 思路：首先是一个有序的数组，找到这个数组的中间值，然后需要找到的值和这个中间值比较，如果是比中间值小，就向右递归，否则向左递归

* 数组 ``$arr = [2, 36, 25, 1, -1, 45, 99];``

* 待找到的值 `-1`

```php
<?php
/**
 * Notes:
 * File name:${fILE_NAME}
 * Create by: Jay.Li
 * Created on: 2019/12/11 0011 17:00
 */
class dichotomy
{
    public function searchValue(array $data, int $leftIndex, int $rightIndex, int $findValue)
    {
        if (!is_array($data)) {
            return ['message' => '非数组', 'status' => 0];
        }

        $middleIndex = floor(($leftIndex + $rightIndex) / 2);//中间值的键
        $middleValue = $data[$middleIndex];//中间值

        /**
         * 递归结束条件
         */
        if ($leftIndex > $rightIndex) {
            return -1;
        }

        if ($findValue > $middleValue) {
            return $this->searchValue($data, $middleIndex + 1, $rightIndex, $findValue);
        } elseif ($findValue < $middleValue) {
            return $this->searchValue($data, $leftIndex, $middleIndex - 1, $findValue);
        } else {
            return $middleIndex;
        }
    }
}

$obj = new dichotomy();
//$data = [2, 36, 25, 1, -1, 45, 99];
$data = [20,50,60,70,80,90,100,280,290,390,490,490,590,690,790,890,990,1000,10101,1000000];
var_dump($obj->searchValue($data, 0, count($data) - 1, 590));
```