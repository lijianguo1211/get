### 查找算法之顺序查找

* 顺序查找

给定一个值，然后在数组中找到这个值，最简单的，最不稳定的就是顺序查找，把数组遍历，然后一个一个比较。比如一个数组是``$arr = [2,36,25,1,-1,45,99]``,
现在需要找到`-1`这个值。

```php
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

```