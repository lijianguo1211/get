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

$arr = [];

var_dump($arr[1]);


function index()
{
    /**
     * 这个就是你的业务层处理逻辑
     */
    $mysql = new PDO('', '', '', '');
    if (true) {
        $userName = md5(123456);
    } else {
        $userName = '';
    }
    /**
     * 这个就是你的界面显示的html.等
     */
    $html = <<<ERT
<input name="user" value="{$userName}">//$userName就是你业务处理传递进来的变量
ERT;
    echo $html;
}