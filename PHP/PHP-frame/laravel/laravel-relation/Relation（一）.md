### Model 模型关联关系 一对一

* 一对一 **hasOne**

* 反向一对一 **belongsTo**

* 一对一测试

* user table

```php
public function up()
{
    Schema::create('users', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->string('name');
        $table->string('email')->unique();
        $table->timestamp('email_verified_at')->nullable();
        $table->string('password');
        $table->rememberToken();
        $table->timestamps();
    });
}
```

* user Model 定义关联关系

```php
public function userDetail()
{
    return $this->hasOne(UserDetail::class, 'user_id', 'id');
}
```

* user_details table

```php
public function up()
{
    Schema::create('user_details', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->bigInteger('user_id')->unique()->comment('关联用户id');
        $table->string('phone')->comment('手机号');
        $table->string('nick_name', 50)->comment('昵称');
        $table->string('image', 200)->comment('图像');
        $table->tinyInteger('user_type')->default(1)->comment('用户类型,默认1，普通用户');
        $table->bigInteger('empirical_value')->default(0)->comment('经验值，默认为0');
        $table->boolean('deteled_at')->default(false)
            ->comment('用户是否注销，默认false,启用状态');
        $table->timestamps();
    });
}
```

* user_details model

```php
public function user()
{
    return $this->belongsTo(User::class, 'user_id', 'id');
}
```

* 通过user模型访问user_details模型数据

```php
User::where('id', $id)->first()->userDetail;
```

> 这里得到全是user_details表的数据，没有user表的数据

```php
User::where('id', $id)->with('userDetail')->first();
```

> 这里得到的就是user表和user_details表的数据，user_details表的数据访问需要
`User::where('id', $id)->with('userDetail')->first()->userDetail['phone']`

通过打印查询的sql,如下：

* `hasOne`

```php
array:2 [▼
  0 => array:3 [▼
    "query" => "select `id`, `name`, `email` from `users` where `id` = ? limit 1"
    "bindings" => array:1 [▼
      0 => "5"
    ]
    "time" => 5.59
  ]
  1 => array:3 [▼
    "query" => "select `id`, `user_id`, `phone`, `nick_name` from `user_details` where `user_details`.`user_id` in (5)"
    "bindings" => []
    "time" => 0.69
  ]
]
```

* `belongTo`

```php
array:2 [▼
  0 => array:3 [▼
    "query" => "select * from `user_details` where `id` = ? limit 1"
    "bindings" => array:1 [▼
      0 => "5"
    ]
    "time" => 76.86
  ]
  1 => array:3 [▼
    "query" => "select * from `users` where `users`.`id` in (5)"
    "bindings" => []
    "time" => 1.45
  ]
]
```

可以看到一对一的关联关系，他们的查询语句是分开查询的，就是得到一个结果之后，然后拿到关联数据再做`in`的查询，并不是我想象中的做join连表查询。

* 关联关系中得到指定的字段

1. 使用`select()`方法得到的就是当前模型的筛选字段，这个地方不要添加`with()`关联表的字段

2. 想要得到`with()`关联表指定的字段，有三个方法，

2.1 在定义关联关系时候，使用`select()`方法固定写死，这样的话，就不灵活。

2.2 使用`with()`方法的时候，自定义指定，`with()`方法可以传递一个字符串或者数组

2.2.1 传递数组的写法,键是关联模型中定义的方法，值是一个闭包函数，传递一个参数`$query`,然后链式调用查询方法即可

```php
$user = User::where('id', $id)->select('id', 'name', 'email')
        ->with(['userDetail' => function($query){
            $query->select('user_id', 'phone', 'nick_name');
        }])
        ->first();
```

2.2.2 还是传递数组，不过不传递闭包，官方文档 
> 注意：在使用这个特性时，一定要在要获取的列的列表中包含 id 列。

```php
$user = User::where('id', $id)->select('id', 'name', 'email')
        ->with(['userDetail:id,user_id,phone,nick_name'])
        ->first();
```

建议就是：如果没有别的条件限制，那就使用第二种，如果有条件限制那就使用闭包的查询方法