### laravel-blade模板基本语法

* `@include('layouts._header')` 这是引入不同模板的文件

* `@yield('content')` 布局中占位符

* `@extends('layouts._default')` 继承模板

* `@section('content') <div> <h2>hahah</h2> </div> @endsection` 对占位符模板填充数据 

* `{{ $variable }}` 要显示的变量

* `{!! $html !!}` 要显示的原生的html内容，显示非转义字符

* `@json($json)` 渲染json转义数据，相当于`json_encode()`,参数和`json_encode`一致

* `@isset($variable) @endisset` 相当于PHP函数 `isset()`

* `@empty($variable) @endenpty` 相当于PHP函数 `empty()`

* **身份验证：**

```php
@auth()
    //验证通过 
@else
    //验证未通过    
@endauth

@guest()
    //验证通过
@else
    //验证未通过 
@endguest()
```

* `@if @eles @elseif @end` if 判断语句

* **switch语句**

```php
@switch($variable)
    @case
    haha
    @break
    @default
    hah
    @break
@endswitch 
```

* **循环语句-for**

```php
@for($i = 0; $i < 10; $i++)
    {{ $i * ($i-1) }}
@endfor
```

* **循环语句-foreach**

```php
@foreach($arr as $k => $item)
    {{ $k }} => {{ $item }}
@endforeach

@foreach($arr as $item)
    {{ $item }}
@endforeach
```

* **循环语句-while**

```php
@while(true) 

{{ $item }}

@endwhile
```

* **原生PHP**

```php

@php

@endphp
```

* **form表单之token**

```php
@cerf
```

* **form表单之伪造提交method方法**

```php
@method('PUT')

@method('DELETE')
```