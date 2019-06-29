<?php

require '../routine/User.php';

//获取User的reflectionClass对象

$reflector  = new reflectionClass(User::class);

var_dump($reflector);

//得到user的构造函数

$controller = $reflector->getConstructor();

var_dump($controller);

// 拿到User的构造函数的所有依赖参数

$params = $controller->getParameters();

var_dump($params);

// 创建user对象,没有参数的
$user = $reflector->newInstance();

var_dump($user);

$user->login();