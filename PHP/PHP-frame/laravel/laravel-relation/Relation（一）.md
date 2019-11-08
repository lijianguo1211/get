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

*****************************************************

### 一对一关联模型 `hasOne()`

* 源码文件 `vendor\laravel\framework\src\Illuminate\Database\Eloquent\Concerns\HasRelationships.php`

```php
<?php

trait HasRelationships
{
        // 参数一：待关联的模型
        // 参数一：当前模型的外键，
        // 参数一：当前模型的主键
        public function hasOne($related, $foreignKey = null, $localKey = null)
        {
            //创建一个新的模型实例
            $instance = $this->newRelatedInstance($related);
    
            //当前模型的外键
            $foreignKey = $foreignKey ?: $this->getForeignKey();
            
            //当前模型的主键
            $localKey = $localKey ?: $this->getKeyName();
    
            return $this->newHasOne($instance->newQuery(), $this, $instance->getTable().'.'.$foreignKey, $localKey);
        }

        protected function newHasOne(Builder $query, Model $parent, $foreignKey, $localKey)
        {
            return new HasOne($query, $parent, $foreignKey, $localKey);
        }

}
```

* `HasOne` 类的源文件 `vendor\laravel\framework\src\Illuminate\Database\Eloquent\Relations\HasOne.php`

```php
<?php

class HasOne extends HasOneOrMany
{

}

```

* `HasOneOrMany` 类的源文件 `vendor\laravel\framework\src\Illuminate\Database\Eloquent\Relations\HasOneOrMany.php`

```php
<?php

abstract class HasOneOrMany extends Relation
{
    public function __construct(Builder $query, Model $parent, $foreignKey, $localKey)
    {
        $this->localKey = $localKey;
        $this->foreignKey = $foreignKey;

        parent::__construct($query, $parent);
    }
}
```


### 一对一关联模型 `belongsTo()`

* 源码文件 `vendor\laravel\framework\src\Illuminate\Database\Eloquent\Concerns\HasRelationships.php`

对应的函数：

```php
<?php
trait HasRelationships
{
    /**
    * $related 关联模型
    * $foreignKey 当前模型的外键
    * $ownerKey 当前模型的主键
    * $relation 当前模型
    */
    public function belongsTo($related, $foreignKey = null, $ownerKey = null, $relation = null)
    {
        //判断第四个参数是否为null, 如果为null,默认得到就是当前关联方法的方法名
        if (is_null($relation)) {
            $relation = $this->guessBelongsToRelation();
        }
        
        // 得到当前关联模型的对象
        $instance = $this->newRelatedInstance($related);
    
        // 判断外键是否为空，如果为空，就拿当前关联方法的名拼接上待关联模型的主键id
        if (is_null($foreignKey)) {
            $foreignKey = Str::snake($relation).'_'.$instance->getKeyName();
        }
    
        //判断是否传递了待关联模型的主键，没有，就直接读取当前待关联的模型的主键
        $ownerKey = $ownerKey ?: $instance->getKeyName();
    
        return $this->newBelongsTo(
            $instance->newQuery(), $this, $foreignKey, $ownerKey, $relation
        );
    }
    
    protected function guessBelongsToRelation()
    {
        // debug_backtrace 产生一条回溯跟踪(backtrace),最后得到当前调用的方法名，也就是定义这个关联关系的方法名
        [$one, $two, $caller] = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 3);
        /*
        *array:3 [▼
           0 => array:5 [▼
             "file" => "E:\work\project\laravel-blog\vendor\laravel\framework\src\Illuminate\Database\Eloquent\Concerns\HasRelationships.php"
             "line" => 176
             "function" => "guessBelongsToRelation"
             "class" => "Illuminate\Database\Eloquent\Model"
             "type" => "->"
           ]
           1 => array:5 [▼
             "file" => "E:\work\project\laravel-blog\app\Models\PostDetail.php"
             "line" => 88
             "function" => "belongsTo"
             "class" => "Illuminate\Database\Eloquent\Model"
             "type" => "->"
           ]
           2 => array:5 [▼
             "file" => "E:\work\project\laravel-blog\vendor\laravel\framework\src\Illuminate\Database\Eloquent\Builder.php"
             "line" => 586
             "function" => "post"
             "class" => "App\Models\PostDetail"
             "type" => "->"
           ]
         ]
        */
        return $caller['function'];
    }
    
    /**
    * 得到待关联模型
    * 得到当前模型
    * 当前待关联模型的外键
    * 当前待关联模型的主键
    * 当前定义的关联方法
    */
    protected function newBelongsTo(Builder $query, Model $child, $foreignKey, $ownerKey, $relation)
    {
        return new BelongsTo($query, $child, $foreignKey, $ownerKey, $relation);
    }
}

```

* `BelongsTo` 对应的源码文件 `vendor\laravel\framework\src\Illuminate\Database\Eloquent\Relations\BelongsTo.php`

```php
<?php

class BelongsTo extends Relation
{
    public function __construct(Builder $query, Model $child, $foreignKey, $ownerKey, $relationName)
    {
        $this->ownerKey = $ownerKey;
        $this->relationName = $relationName;
        $this->foreignKey = $foreignKey;
       
        $this->child = $child;

        parent::__construct($query, $child);
    }
    
    //继承自 Relation 覆盖重写
    public function addConstraints()
    {
        if (static::$constraints) {
            
            //$this->related 就是待关联的模型的表名
            $table = $this->related->getTable();
    
            $this->query->where($table.'.'.$this->ownerKey, '=', $this->child->{$this->foreignKey});
        }
    }
}

//继承父类

abstract class Relation
{
    public function __construct(Builder $query, Model $parent)
    {
        $this->query = $query;
        $this->parent = $parent;
        $this->related = $query->getModel();

        $this->addConstraints();
    }
}

//执行方法 addConstraints 被 BelongsTo 类继承覆盖
```

