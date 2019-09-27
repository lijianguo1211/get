<?php
echo date('Y-m-d H:i:s');

echo "\n";

$a = 10;
$b = &$a;
echo $b . "\n";//10
$a = 20;
echo $b . "\n";//20
$b = 5;
echo $b . "\n";//5
echo $a . "\n";//5

$i = 1;

$j = $i++;

echo $i . "\n";

echo $j;

class Abc {
    public function index()
    {

    }
}

$obj = new Abc();

if (is_a($obj, 'Abc')) {
    var_dump('yes you area success');
} else {
    var_dump('no no no you area beach');
}

var_dump(is_bool(true) ? : 123);

try {
    if (true) {
        throw new \Exception('true true true');
    }
} catch (\Exception $exception) {
    var_dump($exception->getMessage());
}

class LiyiArray implements ArrayAccess
{

    private $container = [];

    public function __construct()
    {
        var_dump($this->container);
    }

    public function offsetExists($offset)
    {
        return isset($this->container[$offset]);
    }

    public function offsetGet($offset)
    {
        if ($this->offsetExists($offset)) {
            return $this->container[$offset];
        } else {
            return null;
        }
    }

    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    public function offsetUnset($offset)
    {
        if ($this->offsetExists($offset)) {
            unset($this->container[$offset]);
        } else {
            return null;
        }
    }
}

$obj = new LiyiArray();

$obj->offsetSet('12', '十二');
$obj->offsetSet('13', '十三');
var_dump($obj->offsetGet(36));
var_dump($obj->offsetGet(12));
var_dump($obj->offsetExists(456));
var_dump($obj->offsetUnset(456));

$arr1 = [
    0 => '18',
    1 => '30',
    2 => '31',
    ];
$arr2 = [19,18,30,31,32];
echo "##################################################\n";
var_dump(array_diff($arr2, $arr1));