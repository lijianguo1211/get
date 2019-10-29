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

<<<<<<< HEAD
echo $j;

$arr = [];

var_dump($arr[1]);


//* * * * * cd //data/apps/lijianguo && php artisan schedule:run >> /dev/null 2>&1
=======
strtolower('');
>>>>>>> b75cccbc229bf925b523492dd31af0cbd3ed845b
