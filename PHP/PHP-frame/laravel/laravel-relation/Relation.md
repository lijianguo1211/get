### 模型关联关系

**一对一**

* users表

```php
<?php
Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
```

* user_details表

```php
<?php
Schema::create('user_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->comment('用户id');
            $table->string('nick_name')->comment('用户昵称');
            $table->string('image')->comment('用户图像');
            $table->tinyInteger('type')->default(1)->comment('用户类型，默认1普通用户');
            $table->bigInteger('empiric_value')->default(0)->comment('用户经验值');
            $table->tinyInteger('deleted_at')->default(1)->comment('账户状态，默认为1正常');
            $table->timestamps();
        });
```

users表通过主键`id`和user_details表的`user_id`形成一对一的关联关系

* User模型

```php
<?php
class User
{
    //参数一：关联模型名
    //参数二：关联模型的外键id
    //参数三：本模型与关联模型的关联id
    punlic function userDetail()
    {
        return $this->hasOne(UserDetails::class, 'user_id', 'id');
    }
}


```

* UserDetails模型,反向关联

```php
<?php

class UserDetail
{
    //参数一：关联模型名
    //参数二：关联模型的外键id
    //参数三：本模型与关联模型的关联id
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
```

* 查询

```php
//得到user模型数据
$result = User::where('id', $id)->first();

//通过user模型得到userDetails模型数据
$nickName = $result->userDetail['nick_name']
$image = $result->userDetail['image']
```

