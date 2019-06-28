### laravel-blade模板

* `@include('layouts._header')` 这是引入不同模板的文件

* `@yield('content')` 布局中占位符

* `@extends('layouts._default')` 继承模板

* `@section('content') <div> <h2>hahah</h2> </div> @endsection` 对占位符模板填充数据 


