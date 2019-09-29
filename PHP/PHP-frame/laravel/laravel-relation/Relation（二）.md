### Model 模型关联关系 一对多 - 多对一

* 一对多 `hasMany()`

* 一对多反向 `belongsTo()`

> 定义关系，一个用户可以发布多篇文章，每一篇文章对应一个用户，用户对文章是一对多，文章对用户就是一对多反向，多对一。

* 创建文章表 `posts`

```php
public function up()
{
    Schema::create('posts', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->bigInteger('user_id')->comment('作者');
        $table->string('title', 150)->comment('标题');
        $table->string('image', 200)->comment('缩略图');
        $table->string('desc', 255)->comment('简介');
        $table->text('content')->comment('内容');
        $table->tinyInteger('type')->default(1)->comment('类型，默认为1');
        $table->boolean('is_examine')->default(false)->comment('是否审核通过，默认false,未通过');
        $table->boolean('deleted_at')->default(false)->comment('是否删除，默认false，未删除');
        $table->timestamps();
    });
}
```

* 创建文章模型 `Post` 并定义与用户模型的关联关系

```php
<?php

namespace App\Models\Database;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public $fillable = [
        'user_id',
        'title',
        'image',
        'desc',
        'content',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}

```

* 在 `User` 模型定义和`posts`表的一对多关系

```php
public function post()
{
    return $this->hasMany(Post::class, 'user_id', 'id');
}
```

*************************
***********测试***********

1. 通过用户id，得到用户相关的文章

1.1 通过查询`User`模型，然后访问关联模型

```php
$postAndUser = User::where('id', $id)->first(['email', 'name']);

$post = [];
foreach ($postAndUser->post as $k => $item) {
    $postTitle[$k][] = $item['title'];
    $postUserId[$k][] = $item['user_id'];
    $postId[$k][] = $item['id'];
    $postImage[$k][] = $item['image'];
    $postDesc[$k][] = $item['desc'];
    $postContent[$k][] = $item['content'];
}

```

1.2 通过预加载的方式查询`with()`

```php
$postAndUser = User::where('id', $id)
->select(['email', 'name'])
->with(['post' => function($query) {
    $query->select(['title', 'user_id', 'id', 'image', 'desc', 'content'])
    ->where('is_examine', 1)
    ->where('deleted_at', 0);
}])->get()->toArray();

array:1 [▼
  0 => array:7 [▼
    "id" => 1
    "name" => "Ms. Shakira Nienow"
    "email" => "bernie.legros@example.net"
    "email_verified_at" => "2019-09-28 15:09:54"
    "created_at" => "2019-09-28 15:09:55"
    "updated_at" => "2019-09-28 15:09:55"
    "post" => array:4 [▼
      0 => array:11 [▼
        "id" => 1
        "user_id" => 1
        "title" => "Mr."
        "image" => "https://lorempixel.com/640/480/?70116"
        "desc" => "8kQTUKJovfVby7nm3Fmne1Ond5Mp2zsPzK5gtQ5ovQxu5dmTys0EDUCGaNI9pVmO4RH2H6bn0mB85Fn05AZ1gVDbv8osMVRyJZLQ"
        "content" => "BOGq5dpnQlDmi5EXv3uGpdL1evPwEpRd3YC52zC0WVMnHABQmo20BCta9yA8yxlwJQUOzkJq8yTGE2OjnWxZm6foTibSNY8xoM4rA2hd7aQuhZsMrMuG9ezToSILe4WXfSwLLxNtKOvnH4oRokQoorY7zJWq7jZR ▶"
        "type" => 1
        "is_examine" => 0
        "deleted_at" => 0
        "created_at" => "2019-09-29 11:42:34"
        "updated_at" => "2019-09-29 11:42:34"
      ]
      1 => array:11 [▶]
      2 => array:11 [▶]
      3 => array:11 [▶]
    ]
  ]
]
```

2. 反向查询，通过文章id得到用户的相关信息

```php
$post = Post::where('id', $id)->first();

//得到用户相关信息
$user = $post->user
//访问user相关的字段
$email = $user->email;
$name  = $user->name;
```

2.2 预加载`with()`方法查询

```php
$post = Post::where('id', $id)->with(['user' => function($query) {
    $query->where();
}
])->first()->toArray();

//查询sql
array:2 [▼
  0 => array:3 [▼
    "query" => "select * from `posts` where `id` = ? limit 1"
    "bindings" => array:1 [▼
      0 => "1"
    ]
    "time" => 7.1
  ]
  1 => array:3 [▼
    "query" => "select * from `users` where `users`.`id` in (1)"
    "bindings" => []
    "time" => 0.65
  ]
]

//得到结果
array:12 [▼
  "id" => 1
  "user_id" => 1
  "title" => "Mr."
  "image" => "https://lorempixel.com/640/480/?70116"
  "desc" => "8kQTUKJovfVby7nm3Fmne1Ond5Mp2zsPzK5gtQ5ovQxu5dmTys0EDUCGaNI9pVmO4RH2H6bn0mB85Fn05AZ1gVDbv8osMVRyJZLQ"
  "content" => "BOGq5dpnQlDmi5EXv3uGpdL1evPwEpRd3YC52zC0WVMnHABQmo20BCta9yA8yxlwJQUOzkJq8yTGE2OjnWxZm6foTibSNY8xoM4rA2hd7aQuhZsMrMuG9ezToSILe4WXfSwLLxNtKOvnH4oRokQoorY7zJWq7jZR ▶"
  "type" => 1
  "is_examine" => 0
  "deleted_at" => 0
  "created_at" => "2019-09-29 11:42:34"
  "updated_at" => "2019-09-29 11:42:34"
  "user" => array:6 [▼
    "id" => 1
    "name" => "Ms. Shakira Nienow"
    "email" => "bernie.legros@example.net"
    "email_verified_at" => "2019-09-28 15:09:54"
    "created_at" => "2019-09-28 15:09:55"
    "updated_at" => "2019-09-28 15:09:55"
  ]
]
```
