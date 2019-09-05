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

9. 接下来就是创建一个文章相关功能，用户相关功能，角色相关功能，权限相关功能，

```php
//posts
php artisna make:conroller PostController -r

//users
php artisna make:controller UserController -r

//role
php artisna make:controller RoleController -r

//permission
php artisan make:controller PermissionController -r
 
```

> 以上是创建资源控制器，毕竟是大量重复的代码，没必要一个一个写。

10. 创建资源路由,在文件route/web.php

```php
Auth::routes();//登陆注册相关

Route::get('/', 'PostController@index')->name('home');//登陆成功首页

Route::resource('users', 'UserController');//用户相关操作

Route::resource('roles', 'RoleController');//角色相关操作

Route::resource('permissions', 'PermissionController');//权限相关操作

Route::resource('posts', 'PostController');//文章相关操作
```

11. 创建视图文件

`users/index.blade.php`
`users/create.blade.php`
`users/edit.blade.php`
`users/show.blade.php`

`posts/index.blade.php`
`posts/create.blade.php`
`posts/edit.blade.php`
`posts/show.blade.php`

`roles/index.blade.php`
`roles/create.blade.php`
`roles/edit.blade.php`
`roles/show.blade.php`

`persissions/index.blade.php`
`persissions/create.blade.php`
`persissions/edit.blade.php`
`persissions/show.blade.php`

12. 修改一下laravel创建auth命令之后创建的公共模板文件。`layouts/app.blade.php`

```php
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <li><a href="{{ url('/') }}">Home</a></li>
                        @if (!Auth::guest())
                            <li><a href="{{ route('posts.create') }}">New Article</a></li>
                        @endif
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        @if(Session::has('flash_message'))
            <div class="container">
                <div class="alert alert-success"><em> {!! session('flash_message') !!}</em>
                </div>
            </div>
        @endif
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @include ('errors.list') {{-- Including error file --}}
            </div>
        </div>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>

```

修改登陆之后跳转的路径，这个是auth登陆之后，在`App\Http\Controllers\Auth\RegisterController.php`
把注册成功后的路径修改为 ``protected $redirectTo = '/';``,和我们创建的首页路由相符合。
把登陆成功后的路径修改位 `protected $redirectTo = '/';`,登陆成功的文件 `App\Http\Controllers\Auth\LoginController.php`

13. 开始写代码：

* 文章相关的代码[PostController](./controller/PostController.php)

```php
class MiddlewareModel
{
    protected $obj;

    /**
     * 注入具体的model
     * MiddlewareModel constructor.
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->obj = $model;
    }

    /**
     * Notes:添加
     * Name: add
     * User: LiYi
     * Date: 2019/8/17
     * Time: 18:21
     * @param array $data
     * @return array
     */
    public function add(array $data)
    {
        try {
            $result = $this->obj->create($data);
        } catch (\Exception $e) {
            \Log::error($this->obj->getTable() . ' create error :' . $e->getMessage());
            $result = ['error' => $e->getMessage()];
        }
        return $result;
    }

    /**
     * Notes:列表
     * Name: getList
     * User: LiYi
     * Date: 2019/8/17
     * Time: 18:21
     * @return mixed
     */
    public function getList()
    {
        return $this->obj->orderby('id', 'desc')->paginate(5);
    }

    /**
     * Notes:根据id查看
     * Name: getIndex
     * User: LiYi
     * Date: 2019/8/17
     * Time: 18:20
     * @param int $id
     * @return mixed
     */
    public function getIndex(int $id)
    {
        return $this->obj->findOrFail($id);
    }

    /**
     * Notes:删除
     * Name: delete
     * User: LiYi
     * Date: 2019/8/17
     * Time: 18:20
     * @param int $id
     * @return array
     */
    public function delete(int $id)
    {
        try {
            $result = $this->getIndex($id);
            $result->delete();
        } catch (\Exception $e) {
            \Log::error('delete error :' . $e->getMessage());
            $result = ['error' => $e->getMessage()];
        }

        return $result;
    }

    /**
     * Notes:更新
     * Name: update
     * User: LiYi
     * Date: 2019/8/17
     * Time: 18:20
     * @param array $data
     * @param int $id
     * @return array
     */
    public function update(array $data, int $id)
    {
        try {
            $result = $this->getIndex($id);
            foreach ($data as $k => $item) {
                $result->$k = $item;
            }
            $result->save();
        } catch (\Exception $e) {
            \Log::error('update error:' . $e->getMessage());
            $result = ['error' => $e->getMessage()];
        }

        return $result;
    }
}

class PostController
{
    protected $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    /**
     * Notes:posts 列表数据
     * Name: index
     * User: LiYi
     * Date: 2019/8/17
     * Time: 18:18
     * @return mixed
     */
    public function index()
    {
        $result = (new MiddlewareModel($this->post))->getList();
        return view($this->post->getTable() . '.' . __FUNCTION__)->with([$this->post->getTable() => $result]);
    }

    /**
     * Notes: 添加文章 form
     * Name: create
     * User: LiYi
     * Date: 2019/8/17
     * Time: 18:18
     * @return mixed
     */
    public function create()
    {
        return view($this->post->getTable() . '.' . __FUNCTION__);
    }

    /**
     * Notes: 添加文章form 提交
     * Name: store
     * User: LiYi
     * Date: 2019/8/17
     * Time: 18:18
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'=>'required|max:100',
            'body' =>'required',
        ]);

        $result = (new MiddlewareModel($this->post))->add($request->only('title', 'body'));

        return redirect()->route($this->post->getTable() . 'index')
            ->with('flash_message', 'Article,
             '. $result['title'].' created');
    }

    /**
     * Notes: 编辑文章页面
     * Name: edit
     * User: LiYi
     * Date: 2019/8/17
     * Time: 18:19
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        $result = (new MiddlewareModel($this->post))->getIndex($id);
        return view($this->post->getTable() . '.' . __FUNCTION__)
            ->with([$this->post->getTable() => $result]);
    }

    /**
     * Notes: 查看文章
     * Name: show
     * User: LiYi
     * Date: 2019/8/17
     * Time: 18:19
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        $result = (new MiddlewareModel($this->post))->getIndex($id);
        return view($this->post->getTable() . '.' . __FUNCTION__)
            ->with([$this->post->getTable() => $result]);
    }

    /**
     * Notes: 更新文章
     * Name: update
     * User: LiYi
     * Date: 2019/8/17
     * Time: 18:19
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title'=>'required|max:100',
            'body' =>'required',
        ]);
        $result = (new MiddlewareModel($this->post))->update($request->only('title', 'body') ,$id);

        if (isset($result['error'])) {
            return redirect()->route('posts.show',
                $id)->with('flash_message',
                'Article, '. $result['error'].' updated');
        }
        return redirect()->route('posts.show',
            $result->id)->with('flash_message',
            'Article, '. $result->title.' updated');
    }

    /**
     * Notes: 删除文章
     * Name: destroy
     * User: LiYi
     * Date: 2019/8/17
     * Time: 18:20
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        (new MiddlewareModel($this->post))->delete($id);

        return redirect()->route($this->post->getTable() . '.index')
            ->with('flash_message',
                'Article successfully deleted');
    }
}
```

* 用户相关的代码[UserController](./controller/UserController.php)

```php
<?php


class UserController
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Notes:用户列表
     * Name: index
     * User: LiYi
     * Date: 2019/8/17
     * Time: 18:34
     * @return mixed
     */
    public function index()
    {
        $result = User::all();
        return view($this->user->getTable() . '.' . __FUNCTION__)->with([$this->user->getTable() => $result]);
    }

    /**
     * Notes:创建用户form
     * Name: create
     * User: LiYi
     * Date: 2019/8/17
     * Time: 18:35
     * @return mixed
     */
    public function create()
    {
        $roles = Role::get();//得到角色列表
        return view($this->user->getTable() . '.' . __FUNCTION__)
            ->with(['roles'=>$roles]);
    }

    /**
     * Notes:创建用户form提交
     * Name: store
     * User: LiYi
     * Date: 2019/8/17
     * Time: 18:35
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        /**
         * 验证参数
         */
        $request->validate([
            'name'=>'required|max:120',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:6|confirmed'
        ]);

        $data = ['password' => Hash::make($request->only('email', 'name', 'password')['password'])];

        /**
         * 用户数据MySQL提交
         */
        $user = User::create(array_merge($request->only('email', 'name', 'password'), $data)); //Retrieving only the email and password data

        $roles = $request['roles']; //Retrieving the roles field
        //验证角色id是否存在
        if (isset($roles)) {

            foreach ($roles as $role) {
                $role_r = Role::where('id', '=', $role)->firstOrFail();
                $user->assignRole($role_r); //给用户赋权
            }
        }
        //Redirect to the users.index view and display message
        return redirect()->route('users.index')
            ->with('flash_message',
                'User successfully added.');
    }

    /**
     * Notes:编辑用户
     * Name: edit
     * User: LiYi
     * Date: 2019/8/17
     * Time: 18:35
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        $user = User::findOrFail($id); //得到用户星系
        $roles = Role::get(); //得到全部权限
        return view($this->user->getTable() . '.' . __FUNCTION__, compact('user', 'roles'));
    }

    /**
     * Notes:查看
     * Name: show
     * User: LiYi
     * Date: 2019/8/17
     * Time: 18:35
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        return redirect($this->user->getTable());
    }

    /**
     * Notes:编辑用户提交
     * Name: update
     * User: LiYi
     * Date: 2019/8/17
     * Time: 18:36
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id); //得到用户信息

        //验证参数
        $request->validate([
            'name'=>'required|max:120',
            'email'=>'required|email|unique:users,email,'.$id,
            'password'=>'required|min:6|confirmed'
        ]);
        $input = $request->only(['name', 'email', 'password']); //Retreive the name, email and password fields
        $data = ['password' => Hash::make($input['password'])];
        $roles = $request['roles']; //Retreive all roles
        $user->fill(array_merge($input, $data))->save();//保存用户信息修改

        if (isset($roles)) {
            $user->roles()->sync($roles);  //判断权限是否存在，存在重新赋权
        } else {
            $user->roles()->detach(); //不存在，把之前的权限全部删除
        }
        return redirect()->route('users.index')
            ->with('flash_message',
                'User successfully edited.');
    }

    /**
     * Notes:删除用户
     * Name: destroy
     * User: LiYi
     * Date: 2019/8/17
     * Time: 18:34
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')
            ->with('flash_message',
                'User successfully deleted.');
    }
}

```

* 角色相关的代码[RoleController](./controller/RoleController.php)

```php
class RoleController
{
    protected $role;

    public function __construct(Role $role)
    {
        $this->role = $role;
    }

    /***
     * Notes:角色列表
     * Name: index
     * User: LiYi
     * Date: 2019/8/17
     * Time: 19:00
     * @return mixed
     */
    public function index()
    {
        $roles = Role::all();;
        return view($this->role->getTable() . '.' . __FUNCTION__)->with([$this->role->getTable() => $roles]);
    }

    /**
     * Notes:创建角色表单
     * Name: create
     * User: LiYi
     * Date: 2019/8/17
     * Time: 19:00
     * @return mixed
     */
    public function create()
    {
        $permissions = Permission::all();
        return view($this->role->getTable() . '.' . __FUNCTION__)->with( ['permissions'=>$permissions]);
    }

    /**
     * Notes:创建角色提交
     * Name: store
     * User: LiYi
     * Date: 2019/8/17
     * Time: 19:00
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        /**
         * 验证参数
         */
        $request->validate([
                'name'=>'required|unique:roles|max:10',
                'permissions' =>'required',
            ]
        );

        $name = $request['name'];
        $role = new Role();
        $role->name = $name;

        $permissions = $request['permissions'];

        $role->save();//保存角色

        /**
         * 得到权限数组
         */
        foreach ($permissions as $permission) {
            $p = Permission::where('id', '=', $permission)->firstOrFail();
            //给对应的角色赋权
            $role = Role::where('name', '=', $name)->first();
            $role->givePermissionTo($p);
        }

        return redirect()->route('roles.index')
            ->with('flash_message',
                'Role'. $role->name.' added!');
    }

    /**
     * Notes:编辑角色表单
     * Name: edit
     * User: LiYi
     * Date: 2019/8/17
     * Time: 18:59
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::all();

        return view($this->role->getTable() . '.' . __FUNCTION__, compact('role', 'permissions'));
    }

    /**
     * Notes:查看角色
     * Name: show
     * User: LiYi
     * Date: 2019/8/17
     * Time: 18:59
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        return redirect($this->role->getTable());
    }

    /**
     * Notes:更新角色信息
     * Name: update
     * User: LiYi
     * Date: 2019/8/17
     * Time: 18:59
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);//得到角色信息

        /**
         * 验证参数
         */
        $request->validate([
            'name'=>'required|max:10|unique:roles,name,'.$id,
            'permissions' =>'required',
        ]);

        $input = $request->except(['permissions']);//去掉权限参数
        $permissions = $request['permissions'];
        $role->fill($input)->save();//保存角色

        $p_all = Permission::all();//得到全部权限

        foreach ($p_all as $p) {
            $role->revokePermissionTo($p); //删除对应角色所拥有的权限
        }

        foreach ($permissions as $permission) {
            $p = Permission::where('id', '=', $permission)->firstOrFail(); //得到权限信息
            $role->givePermissionTo($p);  //权限角色关联
        }

        return redirect()->route('roles.index')
            ->with('flash_message',
                'Role'. $role->name.' updated!');
    }

    /**
     * Notes:删掉角色
     * Name: destroy
     * User: LiYi
     * Date: 2019/8/17
     * Time: 18:59
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return redirect()->route('roles.index')
            ->with('flash_message',
                'Role deleted!');
    }
}
```

* 权限相关的代码[PermissionController](./controller/PermissionController.php)

```php
class PermissionController
{
    protected $permission;

    public function __construct(Permission $permission)
    {
        $this->permission = $permission;
    }

    /**
     * Notes: 列表
     * Name: index
     * User: LiYi
     * Date: 2019/8/17
     * Time: 18:50
     * @return mixed
     */
    public function index()
    {
        $result =  $permissions = Permission::all();
        return view($this->permission->getTable() . '.' . __FUNCTION__)
            ->with([$this->permission->getTable() => $result]);
    }

    /**
     * Notes:创建 form
     * Name: create
     * User: LiYi
     * Date: 2019/8/17
     * Time: 18:50
     * @return mixed
     */
    public function create()
    {
        $roles = Role::get();
        return view($this->permission->getTable() . '.' . __FUNCTION__)->with('roles', $roles);
    }

    /**
     * Notes:创建提交数据
     * Name: store
     * User: LiYi
     * Date: 2019/8/17
     * Time: 18:50
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        /**
         * 参数验证
         */
        $request->validate([
            'name'=>'required|max:40',
        ]);

        $name = $request['name'];
        $permission = new Permission();
        $permission->name = $name;

        $roles = $request['roles'];

        $permission->save();//保存权限

        if (!empty($request['roles'])) {//判断角色是否存在
            foreach ($roles as $role) {
                $r = Role::where('id', '=', $role)->firstOrFail();
                $permission = Permission::where('name', '=', $name)->first();
                $r->givePermissionTo($permission);//给每个角色和权限绑定
            }
        }

        return redirect()->route('permissions.index')
            ->with('flash_message',
                'Permission'. $permission->name.' added!');

    }

    /**
     * Notes:编辑form
     * Name: edit
     * User: LiYi
     * Date: 2019/8/17
     * Time: 18:50
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        $permission = Permission::findOrFail($id);
        return view($this->permission->getTable() . '.' . __FUNCTION__)
            ->with([$this->permission->getTable() => $permission]);
    }

    /**
     * Notes:查看
     * Name: show
     * User: LiYi
     * Date: 2019/8/17
     * Time: 18:49
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        return redirect($this->permission->getTable());
    }

    /**
     * Notes:更新
     * Name: update
     * User: LiYi
     * Date: 2019/8/17
     * Time: 18:49
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function update(Request $request, $id)
    {
        $permission = Permission::findOrFail($id);
        /**
         *
         * 验证参数
         */
        $request->validate($request, [
            'name'=>'required|max:40',
        ]);
        $input = $request->all();
        $permission->fill($input)->save();//保存权限

        return redirect()->route('permissions.index')
            ->with('flash_message',
                'Permission'. $permission->name.' updated!');

    }

    /**
     * Notes:
     * Name: destroy
     * User: LiYi
     * Date: 2019/8/17
     * Time: 18:49
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);

        /**
         * 是管理员就不让删除
         */
        if ($permission->name == "Administer") {
            return redirect()->route('permissions.index')
                ->with('flash_message',
                    'Cannot delete this Permission!');
        }

        $permission->delete();

        return redirect()->route('permissions.index')
            ->with('flash_message',
                'Permission deleted!');
    }
}
```

> 创建文章相关的数据迁移文件

```php
php artisan make:migration create_posts_table --table=posts
```

* [posts数据表迁移文件](./database/migrations/create_posts_table.php)

```php
<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('body');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
```

到这里，我们的基本程序控制的东西已经搞定了，剩下的就我们去添加我们的用户，添加所需要的角色，添加所需要的权限，已经验证权限所需要的中间件