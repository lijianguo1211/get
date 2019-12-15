<?php
/**
 * Notes:
 * File name:${fILE_NAME}
 * Create by: Jay.Li
 * Created on: 2019/12/11 0011 16:49
 */

class Search
{
    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    function searchValue(int $findValue)
    {
        if (!is_array($this->data)) {
            return ['message' => '非数组', 'status' => 0];
        }

        foreach ($this->data as $k => $value) {
            if ($value != $findValue) {
                continue;
            }

            return ['message' => 'success', 'status' => 1, 'data' => $k];
        }

        return ['message' => '数据不存在', 'status' => 0];
    }
}

$arr = [2, 36, 25, 1, -1, 45, 99];

$obj = new Search($arr);

var_dump($obj->searchValue(-1));
var_dump($obj->searchValue(100));
