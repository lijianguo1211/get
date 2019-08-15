### laravel中封装权限控制插件

* 原帖地址[laravel-permission](https://scotch.io/tutorials/user-authorization-in-laravel-54-with-spatie-laravel-permission)

> 英语还🆗的可以去看看，当然不🆗的也可以去看看，锻炼一下自己的英语嘛

一般的基于权限控制的就那几个东西：

* 用户 [users]

* 角色 [roles]

* 权限 [permissions]

* 用户角色 [user_role]

* 角色权限 [role_permission]

大概就是以上的五个东西，先给定权限，然后创建角色，最后给用户赋予角色就欧克了，这就是最简单的流程了，但是，这个东西可以组件化的，也就是可以提
供一个模板，大家都去套用，或者在上面创新就可以了。今天介绍的就是这个小鬼

**准备条件**

* composer [windows下载安装composer](https://getcomposer.org/Composer-Setup.exe)

* laravel框架，composer安装 `composer create-project laravel/laravel`

* 安装权限控制包 laravel-permission `composer require spatie/laravel-permission`

* 安装一个form表单包 laravelcollective/html `composer require laravelcollective/html`

* 创建一个测试数据库，只需要创建一个数据库就可以了。

以上是准备工作，这个是准备的测试条件

1. 添加 `Spatie\Permission\PermissionServiceProvider::class,` 它到laravel的config/app.php文件

```php
'providers' => [
    //...
    Spatie\Permission\PermissionServiceProvider::class,
]
```

2. 添加 `Collective\Html\HtmlServiceProvider::class,` 它到laravel的config/app.php文件

```php
'providers' => [
    //...
    Collective\Html\HtmlServiceProvider::class,
]
```

3. 添加 `'Form' => Collective\Html\FormFacade::class,
               'Html' => Collective\Html\HtmlFacade::class,` 它到laravel的config/app.php文件
               
```php
'aliases' => [
        //...
        'Form' => Collective\Html\FormFacade::class,
        'Html' => Collective\Html\HtmlFacade::class,
]
```               

4. 创建这个权限控制包所需要的数据表，执行数据迁移

```php
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider" --tag="migrations"
```

执行成功以后，会在`laravel/dtabase/migrations`文件下生成数据迁移文件，如下：

```php
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableNames = config('permission.table_names');
        $columnNames = config('permission.column_names');

        Schema::create($tableNames['permissions'], function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('guard_name');
            $table->timestamps();
        });

        Schema::create($tableNames['roles'], function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('guard_name');
            $table->timestamps();
        });

        Schema::create($tableNames['model_has_permissions'], function (Blueprint $table) use ($tableNames, $columnNames) {
            $table->unsignedInteger('permission_id');

            $table->string('model_type');
            $table->unsignedBigInteger($columnNames['model_morph_key']);
            $table->index([$columnNames['model_morph_key'], 'model_type', ]);

            $table->foreign('permission_id')
                ->references('id')
                ->on($tableNames['permissions'])
                ->onDelete('cascade');

            $table->primary(['permission_id', $columnNames['model_morph_key'], 'model_type'],
                    'model_has_permissions_permission_model_type_primary');
        });

        Schema::create($tableNames['model_has_roles'], function (Blueprint $table) use ($tableNames, $columnNames) {
            $table->unsignedInteger('role_id');

            $table->string('model_type');
            $table->unsignedBigInteger($columnNames['model_morph_key']);
            $table->index([$columnNames['model_morph_key'], 'model_type', ]);

            $table->foreign('role_id')
                ->references('id')
                ->on($tableNames['roles'])
                ->onDelete('cascade');

            $table->primary(['role_id', $columnNames['model_morph_key'], 'model_type'],
                    'model_has_roles_role_model_type_primary');
        });

        Schema::create($tableNames['role_has_permissions'], function (Blueprint $table) use ($tableNames) {
            $table->unsignedInteger('permission_id');
            $table->unsignedInteger('role_id');

            $table->foreign('permission_id')
                ->references('id')
                ->on($tableNames['permissions'])
                ->onDelete('cascade');

            $table->foreign('role_id')
                ->references('id')
                ->on($tableNames['roles'])
                ->onDelete('cascade');

            $table->primary(['permission_id', 'role_id']);
        });

        app('cache')
            ->store(config('permission.cache.store') != 'default' ? config('permission.cache.store') : null)
            ->forget(config('permission.cache.key'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $tableNames = config('permission.table_names');

        Schema::drop($tableNames['role_has_permissions']);
        Schema::drop($tableNames['model_has_roles']);
        Schema::drop($tableNames['model_has_permissions']);
        Schema::drop($tableNames['roles']);
        Schema::drop($tableNames['permissions']);
    }
}

```

下一步就可以执行数据迁移了，但是它可能会报一个错误，告诉我们创建的索引长度超过最大值，这里需要先修改，报错如下：

```php
[Illuminate\Database\QueryException]
SQLSTATE[42000]: Syntax error or access violation: 1071 Specified key was too long; max key length is 767 bytes (SQL: alter table users add unique users_email_unique(email))

[PDOException]
SQLSTATE[42000]: Syntax error or access violation: 1071 Specified key was too long; max key length is 767 bytes
```

不要慌，到这一步，我们可以先去修改一下我们laravel文件，如下：

```php
<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
    }
}

```

主要是在`boot()`方法添加 `Schema::defaultStringLength(191);`,其实也可以，在我们创建表的迁移文件的时候，为每个字段指定长度，这样就不会
报错了。

5. 执行迁移 `php artisan migrate`,可以去数据库看，我们的五张表已经创建好了。

6. 发布我们的权限包的配置文件 `php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider" --tag="config"`

7. 由于是测试，没有在项目中使用，所以没遇后台，在这里呢，先使用laravel自带的auth登陆。 `php artisan auth`

8. 使用PHP自带的测试服务器，查看我们的页面 `php artisan serve`,可以看到欢迎页面
