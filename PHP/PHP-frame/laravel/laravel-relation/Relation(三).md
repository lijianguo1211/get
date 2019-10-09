### 模型关联 多对多 belongsToMany

* `belongsToMany` 多对多关联，在权限控制中，一个用户可以有多个角色，同时一个角色也可以有多个用户。这样构成多对多的关系

##### 准备工作

* 创建角色表`roles`

```php
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('role_name')->comment('角色名');
            $table->string('slug')->comment('url');
            $table->timestamps();
        });
    }
```

* 创建角色模型 `Role`,定义关联关系

```php
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_roles', 'role_id', 'user_id');
    }
```

> 参数一：多对多关联的模型；参数二：多对多关联关系表；参数三：当前模型在关联表的id，参数四，多对多关联表，在这里就是user表的关联id

* 创建角色用户关联表 `user_roles`

```php
    public function up()
    {
        Schema::create('user_roles', function (Blueprint $table) {
           $table->bigInteger('user_id')->comment('用户id');
           $table->bigInteger('role_id')->comment('角色id');
        });
    }
```

* 在`User`模型定义多对多关联关系

```php
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles', 'user_id', 'role_id');
    }
```

* 数据填充

```php

<?php

use Illuminate\Database\Seeder;
use App\Models\DataBase\UserRole;
use App\Models\DataBase\Role;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\DataBase\Role::class, 50)->create();
    }
}

class UserRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 50; $i++) {
            $data = [
                'user_id' => mt_rand(1, 100),
                'role_id' => mt_rand(1, 50),
            ];
            UserRole::create($data);
        }
    }
}

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/
/** @var \Illuminate\Database\Eloquent\Factory $factory */

$factory->define(Role::class, function (Faker $faker) {
    return [
        'role_name' => $faker->name,
        'slug' => $faker->slug,
    ];
});
```

* 使用

1. 查询某一个角色与用户的关联

```php
$role = Role::where('id', $id)->with('users')->get()->toArray();
```

2. 查询SQL

```php
array:2 [▼
  0 => array:3 [▼
    "query" => "select * from `roles` where `id` = ?"
    "bindings" => array:1 [▼
      0 => "47"
    ]
    "time" => 62.64
  ]
  1 => array:3 [▼
    "query" => "select `users`.*, `user_roles`.`role_id` as `pivot_role_id`, `user_roles`.`user_id` as `pivot_user_id` from `users` inner join `user_roles` on `users`.`id` = `user_roles`.`user_id` where `user_roles`.`role_id` in (47) ◀"
    "bindings" => []
    "time" => 53.51
  ]
]
```

3. 得到结果

```php
array:1 [▼
  0 => array:6 [▼
    "id" => 47
    "role_name" => "Koby Jones"
    "slug" => "molestiae-sit-maxime-velit-ut-tempora-neque-alias"
    "created_at" => "2019-10-02 10:12:50"
    "updated_at" => "2019-10-02 10:12:50"
    "users" => array:4 [▼
      0 => array:7 [▼
        "id" => 19
        "name" => "Asha Macejkovic"
        "email" => "lilliana88@example.net"
        "email_verified_at" => "2019-09-27 02:55:19"
        "created_at" => "2019-09-27 02:55:21"
        "updated_at" => "2019-09-27 02:55:21"
        "pivot" => array:2 [▼
          "role_id" => 47
          "user_id" => 19
        ]
      ]
      1 => array:7 [▼
        "id" => 19
        "name" => "Asha Macejkovic"
        "email" => "lilliana88@example.net"
        "email_verified_at" => "2019-09-27 02:55:19"
        "created_at" => "2019-09-27 02:55:21"
        "updated_at" => "2019-09-27 02:55:21"
        "pivot" => array:2 [▼
          "role_id" => 47
          "user_id" => 19
        ]
      ]
      2 => array:7 [▼
        "id" => 19
        "name" => "Asha Macejkovic"
        "email" => "lilliana88@example.net"
        "email_verified_at" => "2019-09-27 02:55:19"
        "created_at" => "2019-09-27 02:55:21"
        "updated_at" => "2019-09-27 02:55:21"
        "pivot" => array:2 [▼
          "role_id" => 47
          "user_id" => 19
        ]
      ]
      3 => array:7 [▼
        "id" => 19
        "name" => "Asha Macejkovic"
        "email" => "lilliana88@example.net"
        "email_verified_at" => "2019-09-27 02:55:19"
        "created_at" => "2019-09-27 02:55:21"
        "updated_at" => "2019-09-27 02:55:21"
        "pivot" => array:2 [▼
          "role_id" => 47
          "user_id" => 19
        ]
      ]
    ]
  ]
]
```
