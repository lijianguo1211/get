### Laravel框架使用whereIn查询SQL时数据出错

在laravel里面执行SQL查询，SQL里面的 `in`查询：

```sql
select * from `users` where id in (1,2,3,4,5,6); 
```

在laravel里面可以这样写：

```php
<?php
DB::table('users')->whereIn('id', [1,2,3,4,5,6])->get()->toArray();

//或者
User::whereIn('id', [1,2,3,4,5,6])->get()->toArray();
```

这样写查询很方便没有问题的，也是可以查询出来的。如果后面再加一个`where`查询：

```php
<?php
DB::table('users')->whereIn('id', [1,2,3,4,5,6])
->where('name', 'liyi')
->get()->toArray();

//或者
User::whereIn('id', [1,2,3,4,5,6])
->where('name', 'liyi')
->get()->toArray();
```

这样写的时候也是没有问题的。现在我们把`whereIn`的数组改变一下：

```php
<?php
DB::table('users')->whereIn('id', [[2],[12],[2],[3],[4]])
->where('name', 'liyi')
->get()->toArray();

//或者
User::whereIn('id', [[2],[12],[2],[3],[4]])
->where('name', 'liyi')
->get()->toArray();
```

这个时候，查询得到的结果还是没有问题的。还是一个正确的结果，那么再改变一下呢：

```php
<?php
DB::table('users')->whereIn('id', [[2,1],[12,2],[2],[3],[4]])
->where('name', 'liyi')
->get()->toArray();

//或者
User::whereIn('id', [[2,1],[12,2],[2],[3],[4]])
->where('name', 'liyi')
->get()->toArray();
```

这个时候它得到的结果就是一个空，why?

实际例子：

```php
<?php
CategoryDetail::whereIn('category_id', [[2,1],[12],[2],[3],[4]])->where('languages_id', 1)->get();

//SQL
select * from `category_details` where `category_id` in (2, 1, 12, 2, 3) and `languages_id` = 4;
```

所以遇到这个情况的时候，暂时可以的办法就是

1. 把`whereIN`的查询放在最后面，这样就可以保证，它的参数绑定的时候不会把正确的参数替换为`In`查询的参数了

2. 对自己的`In`查询的数组，自己先做一个处理，要么保证是一个一维数组，这样肯定没问题，二位数组的话，保证二位数组里每个一维数组都是和子元素个数相同，但
是这样也不现实，所以呢。。。
