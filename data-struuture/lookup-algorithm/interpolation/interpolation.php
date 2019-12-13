<?php
/**
 * Notes:
 * File name:${fILE_NAME}
 * Create by: Jay.Li
 * Created on: 2019/12/13 0013 11:40
 */

class SearchValue
{
    protected static $num = 0;

    public function findValue1(array $data, int $leftIndex, int $rightIndex, int $findValue)
    {
        var_dump("循环次数：" . ++self::$num);
        if (!is_array($data)) {
            return ['code' => -1, 'message' => sprintf("$data 非数组")];
        }

        if ($leftIndex > $rightIndex) {
            return ['code' => -2, 'message' => sprintf("此 [ %d ] 不在 $data 中", $findValue)];
        }

        $middleIndex = $leftIndex + ($rightIndex - $leftIndex) * ($findValue - $data[$leftIndex]) / ($data[$rightIndex] - $data[$leftIndex]);

        $middleIndex = intval($middleIndex);
        if ($middleIndex < $leftIndex || $middleIndex > $rightIndex) {
            return ['code' => -3, 'message' => sprintf("中间值的索引 [ %d ] 越界", $middleIndex)];
        }

        $middleValue = $data[$middleIndex];
        if ($findValue < $middleValue) {
            return $this->findValue1($data, $leftIndex, $middleIndex - 1, $findValue);
        } elseif ($findValue > $middleValue) {
            return $this->findValue1($data, $middleIndex +1, $rightIndex, $findValue);
        } else {
            return $middleValue;
        }
    }
}

$obj = new SearchValue();
$data = [1,2,3,4,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20];
var_dump($obj->findValue1($data, 0, count($data) - 1, 20));