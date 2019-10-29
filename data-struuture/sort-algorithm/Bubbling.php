<?php
/**
 * Notes:
 * File name:${fILE_NAME}
 * Create by: Jay.Li
 * Created on: 2019/10/18 0018 9:22
 */

class Sort
{
    public static function sortArray(array $data)
    {
        if (!is_array($data)) {
            return ['message' => '非数组'];
        }

        $count = count($data);

        if ($count <= 0) {
            return ['message' => '数组长度小于等于0'];
        }

        if ($count === 1) {
            return $data;
        }

        return static::sortArray2($data, $count);
    }

    public static function sortArray1(array $data, int $count):array
    {
        for ($i = 0; $i < $count; $i++) {
            $flag = false;
            $temp = 0;
            for ($j = $i+1; $j < $count; $j++) {
                if ($data[$i] > $data[$j]) {
                    $temp = $data[$i];
                    $data[$i] = $data[$j];
                    $data[$j] = $temp;
                    $flag = true;
                }
            }

            if (!$flag) {
                break;
            }
        }

        return $data;
    }

    public static function sortArray2(array $data, int $count):array
    {
        $temp = 0;
        for ($i = 0; $i < $count; $i++) {
            $flag = false;
            for ($j = 0; $j < $count-1-$i; $j++) {
                if ($data[$j] > $data[$j+1]) {
                    $temp = $data[$j];
                    $data[$j] = $data[$j+1];
                    $data[$j+1] = $temp;
                    $flag = true;
                }
            }

            if (!$flag) {
                break;
            }
        }
        return $data;

    }
}
$data =  [1, 20, -3, -5, 6];




var_dump(Sort::sortArray($data));
